<?php

namespace App\Libraries;

use App\Http\Models\SYSTableFlat;
use App\Libraries\System\Entity;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\OrderStatus;


/**
 * Class OrderProcess
 */
Class OrderProcess
{
   private $_apiUrl = '';
    private $_apiUrlListing = '';
    private $_entityLib = '';

    public function __construct()
    {
        $this->_apiUrl = config("system.API_SYSTEM_ENTITIES");
        $this->_apiUrlListing =  $this->_apiUrl.'listing';
        $this->_entityLib = new Entity();
    }

    /**
     * @param $request
     * @param bool $suggest_truck
     * @return mixed
     */

    public function processRequest($order_id,$request,$suggest_truck = false)
    {
        $return['message'] = 'success';
        $return['warning'] = 0;
        $return['error'] = 0;

        if (isset($request['depend_entity'])) {
            $depend_entity = $request['depend_entity'];
            unset($request['depend_entity']);
            // $request->replace($request);
        }

        $order = $request;
      //  echo "<pre>"; print_r($order); exit;
        $flat_table = new SYSTableFlat('order');
        $order_db = $flat_table->getColumnByWhere(' entity_id = '.$order_id,'*');
        //echo "<pre>"; print_r($order_db); exit;
        //Get general setting for loyalty points and other setting
        $general_setting_lib = new GeneralSetting();
        $general_setting = $general_setting_lib->getSetting();

        if(isset($order['per_extra_item_charge']) && !empty($order['per_extra_item_charge'])){
            $per_extra_charge = $order['per_extra_item_charge'];
        }
        else{
            $per_extra_charge = ($general_setting->per_extra_item_charge > 0) ? $general_setting->per_extra_item_charge : 0;
        }


        //Now process order items to calculate sutotal, discounts etc
        if(isset($depend_entity[0])) {

            // $order_items = array();
            $count =  $total_weight = $total_volume = $extra_item_charges = 0;

            $item_lib = new ItemLib();

            foreach ($depend_entity as $order_item) {

                $order_item = is_array($order_item) ? (object)$order_item : $order_item;

                $volume = CustomHelper::calculateVolume($order_item);
                $total_volume += $volume*$order_item->quantity;
                $total_weight +=  ($order_item->weight*$order_item->quantity);

                $depend_entity[$count]['volume'] = $volume;

                //Suggest item box
                $item_boxes = $item_lib->getItemBoxByVolume($volume);

                if(isset($item_boxes->data->item_box[0])){
                    $item_box  = $item_boxes->data->item_box[0];

                    $depend_entity[$count]['item_box_id'] = $item_box->entity_id;
                    $depend_entity[$count]['item_box_title'] = $item_box->title;
                }


                //$depend_entity[$count]['charge_extra_item'] = 0;
                $depend_entity[$count]['per_extra_item_charge'] = 0;

                if(isset($order_item->charge_extra_item)){

                   $depend_entity[$count]['charge_extra_item'] = 1;
                    $depend_entity[$count]['per_extra_item_charge'] = $per_extra_charge;

                    $extra_item_charges +=  $per_extra_charge;
                }

                unset($order_item);
                $count++;

            }

          /* echo "<pre>"; print_r($depend_entity);
            exit;*/

            $loading_price = (isset($order['loading_price']) && $order['loading_price'] > 0) ? $order['loading_price'] : 0;
            $est_charges_range = (isset($general_setting->est_charges_range) && $general_setting->est_charges_range > 0) ? $general_setting->est_charges_range : 0;


            $truck_exist = 0; $suggested_truck = array();

            if($suggest_truck) {

                $truck_lib = new Truck();
                $truck_list = $truck_lib->getTruckByWeightVol($total_weight, $total_volume, 't.*');

                if ($truck_list) {
                    if (count($truck_list) > 0) {
                        foreach ($truck_list as $truck) {
                            if ($truck->entity_id == $order['truck_id']) {
                                $truck_exist++;
                            }

                            $suggest_truck = new \StdClass();
                            $suggest_truck->entity_id = $truck->entity_id;
                            $suggest_truck->title = $truck->title;
                            $suggested_truck[] = $suggest_truck;
                        }
                    }

                    if($truck_exist == 0)
                    $return['suggested_truck'] = $suggested_truck;
                }
                else{
                    $return['error'] = 1;
                    $return['message'] = "Please update items, There is no truck is capable for your request";
                    return $return;
                }


                if ($truck_exist == 0) {
                    //  print_r($truck_exist); exit;
                    $selected_truck = $truck_list[0];
                    $return['warning'] = 1;
                     $return['warning_message'] = "The truck is not capable for the changes you have made, so Please select another truck";
                   // $order['truck_id'] = $truck_list[0]->entity_id;
                  //  $order['charge_per_minute'] = $truck_list[0]->charge_per_minute;
                   // $order['base_fee'] = $truck_list[0]->base_fee;

                  //  $return['selected_truck'] = $selected_truck;
                }
            }
          /* echo "<pre>"; print_r($order_db->truck_id);
            echo "<pre>"; print_r($order['truck_id']);
            exit;*/
            if($order_db->truck_id != $order['truck_id']){

                if(!isset($order['truck_vehicle']) || $order['truck_vehicle'] == ''){
                    $return['error'] = 1;
                    $return['message'] = "Truck cannot be updated without selecting available vehicle";
                    return $return;
                }
            }




            $est_charges = ($order['charge_per_minute'] * $order['estimated_minutes']) + $order['base_fee'];

            $est_min_charges = CustomHelper::roundOffPrice($est_charges);
            $est_max_charges =  CustomHelper::roundOffPrice($est_charges + $est_charges_range);

            $pre_grand_total =  $loading_price + $est_max_charges;

            $order['volume'] = "$total_volume";
            $order['weight'] = "$total_weight";
            $order['loading_price'] = "$loading_price";
            $order['min_estimated_charges'] = "$est_min_charges";
            $order['max_estimated_charges'] = "$est_max_charges";
            $order['pre_grand_total'] = "$pre_grand_total";
            $order['extra_item_charges'] = "$extra_item_charges";
            $order['per_extra_item_charge'] = "$per_extra_charge";

            $return['order'] = $order;
            $return['depend_entity'] = $depend_entity;
            $return['selected_truck_id'] = $order['truck_id'];

            $pickup_date = $order['pickup_date'].' '.$order['pickup_time'];
            $pickup_date_obj = Carbon::createFromFormat('Y-m-d H:i:s', $pickup_date, APP_TIMEZONE);
            $pickup_date_cst =  $pickup_date_obj->setTimezone('EST');
            $return['pickup_date_cst'] = $pickup_date_cst;

           // echo "<pre>"; print_r($return); exit;
            return $return;

        }
    }


    /**
     * Get Order Items
     * @param $order_id
     * @return array
     */
    public function getOrderItems($order_id)
    {
        $entity_ids = array();
        $order_item_ids = \DB::select("SELECT entity_id From order_item_flat where order_id = $order_id");

        if($order_item_ids) {
            foreach ($order_item_ids as $order_item) {
                $entity_ids[] = $order_item->entity_id;
            }
        }

        return $entity_ids;
    }


    /**
     * Update Order final charges
     * @param $request
     * @return \StdClass
     */
    public function updateFinalOrder($request)
    {
        $request = is_array($request) ? (object)$request : $request;
        $return = new \StdClass();
        $return->error = 0;

        try{
            $order_id = $request->order_id;

            $flat_model = new SYSTableFlat('order');
            $order_raw = $flat_model->getDataByWhere('entity_id = '.$order_id);

            if(isset($order_raw[0])){

                $order = $order_raw[0];
                $actual_charges = ($order->charge_per_minute * $request->total_minutes)+ $order->base_fee;
                $actual_charges = CustomHelper::roundOffPrice($actual_charges);

                $grand_total =  $actual_charges + $order->loading_price + $order->extra_item_charges;

                 if($order->payment_method_type == 'stripe'){
                     $stripeFee = ((($grand_total*2.9)/100)+0.3);
                     $grand_total = $grand_total+$stripeFee;
                 }

                $grand_total = CustomHelper::roundOffPrice($grand_total);

                $params['entity_type_id'] = 15;
                $params['entity_id'] = $order_id;
                $params['total_distance'] = "$request->total_distance";
                $params['total_minutes'] = "$request->total_minutes";
                $params['actual_charges'] = "$actual_charges";
                $params['payment_method_fee'] = $stripeFee;
                $params['grand_total'] = "$grand_total";
              //  $params['delivery_date'] = date('Y-m-d H:i:s');
                $params['mobile_json'] = $request->mobile_json;
                $params['hook'] = $request->hook;

                //Update Order
                $entity_lib = new Entity();
                $order_response =  $entity_lib->apiUpdate($params);
                $order_response = json_decode(json_encode($order_response));

                if($order_response->error == 1){
                    $return->error = 1;
                    $return->message = $order_response->message;
                    return $return;
                }

                $return = $order_response;

            }
        }
        catch (\Exception $e) {
            $return->error = 1;
            $return->message = $e->getMessage();
            $return->debug = 'File : ' . $e->getFile() . ' : Line ' . $e->getLine();
        }

        return $return;
    }

    /**
     * Update Order when driver updated statuses
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function updateOrderDriverEnd($request)
    {
        $entity_lib = new Entity();
        $post_arr = [];
        $post_arr['entity_type_id'] = 15;
        $post_arr['entity_id'] = $request->order_id;
        $post_arr['order_status'] = $request->order_status;


        if(isset($request->comment)){
            $post_arr['comment'] = $request->comment;
        }


        if($request->status_keyword == 'completed'){
            $post_arr['delivery_date'] = date('Y-m-d H:i:s');

            if(isset($request->transaction_id) && !empty($request->transaction_id))
            $post_arr['transaction_id'] = $request->transaction_id;

            if(isset($request->card_id) && !empty($request->card_id))
                $post_arr['card_id'] = $request->card_id;

            if(isset($request->card_type) && !empty($request->card_type))
                $post_arr['card_type'] = $request->card_type;

            if(isset($request->card_last_digit) && !empty($request->card_last_digit))
                $post_arr['card_last_digit'] = $request->card_last_digit;
        }

            //update order
        $response = $entity_lib->apiUpdate($post_arr);
        return json_decode(json_encode($response));

    }

    public static function calcStripeFee($total_amount)
    {
       return  ((($total_amount*2.9)/100)+0.3);
    }





}