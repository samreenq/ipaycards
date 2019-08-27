<?php

namespace App\Libraries;

use App\Http\Models\Custom\VendorOrderLogs;
use App\Libraries\InventoryLib;
use App\Http\Models\SYSTableFlat;
use App\Libraries\System\Entity;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\Services\Cards;
use App\Libraries\EmailLib;

Class OrderSendCards {
    
    private $_emailContent = '';
    private $_orderID;
    private $_pLib;
    private $_assignData;
    private $_emailContentGift = '';

    public function __construct()
    {
        $this->_pLib = new Entity();
        $this->_vendorOrderLogsModel = new VendorOrderLogs();
        $this->_inventory_lib = new InventoryLib();
        $this->_emailContent =  "";
        $this->_emailContentGift =  "";
    }
    /**
     * @param $order
     * @param $order_items
     */
    public function processInStockItemOrder($order_id,$order,$order_items)
    {
        //Get Inventory of Item
        if($order_items){

            //  echo "<pre>"; print_r($order_items); exit;
            foreach($order_items as $order_item_data){
                    $this->processInStockItem($order_id,$order_item_data,$order_item_data->item_type->value);
            }

            //Send Email
            $email_lib = new EmailLib();
            $order_history = new OrderHistory();

            if($this->_emailContentGift != ''){
                $this->_emailContent .= $this->_emailContentGift;
                $email_lib->sendGiftEmail($order,$this->_emailContentGift);
            }

            if($this->_emailContent != ''){
                $email_lib->sendOrderEmail($order,$this->_emailContent);
            }
           $order_history->updateOrderDelivered($order_id);
        }

        unset($this->_emailContent);
        unset($this->_emailContentGift);

    }

    public function processInStockItem($order_id,$order_item,$item_type)
    {
        $encryption_key = config('constants.ENCRYPTION_KEY');
        $column = "CAST(AES_DECRYPT(voucher_code, '".$encryption_key."') AS CHAR(50)) AS voucher_code";

        $sys_flat_model = new SYSTableFlat('inventory');

        $params = array(
            'entity_type_id' => 'order_item_deal',
            'order_item_id' => $order_item->entity_id,
            'order_id' => $order_id,
            'order_from' => 'in_stock',
            'mobile_json' => 1,
            'in_detail' => 1
        );

        $item_deals =  $this->_pLib->apiList($params);
        $item_deals = json_decode(json_encode($item_deals));
        //
        //Create email content
            if($order_item->item_type->value == 'deal'){

                if($item_deals->data->page->total_records > 0){

                    $this->_emailContent .= '<br>';
                    $this->_emailContent .= 'You have ordered deal: '.$order_item->product_id->value.':';

                    foreach($item_deals->data->order_item_deal as $deals){

                        $inventory =  $sys_flat_model->getDataByWhere(' entity_id = '.$deals->inventory_id->id,array($column));
                        $product_code = $inventory[0]->voucher_code;

                        $this->_emailContent .= '<br>';
                        $this->_emailContent .= $deals->product_id->value.' has voucher '.$product_code.'<br>';

                        $this->_inventory_lib->updateStatusSold($deals->inventory_id->id);

                        //Update Order item Deal
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'entity_id' => $deals->entity_id,
                            'delivery_status' => 'delivered'
                        ];

                        // echo "<pre>"; print_r($params);
                        $oi_response = $this->_pLib->apiUpdate($params);
                        $oi_response = json_decode(json_encode($oi_response));

                    }
                }
            }
            elseif($order_item->item_type->value == 'gift_card') {
              //  $is_gift_card++;

                if($item_deals->data->page->total_records > 0) {

                    $email_cont = '';
                    foreach ($item_deals->data->order_item_deal as $deals) {

                        $inventory = $sys_flat_model->getDataByWhere(' entity_id = ' . $deals->inventory_id->id, [$column]);
                        $product_code = $inventory[0]->voucher_code;

                        $email_cont .= '<br>';
                        $email_cont .= $deals->product_id->value . ' has voucher ' . $product_code;

                       // $this->_emailContent .= $email_cont;

                        $this->_inventory_lib->updateStatusSold($deals->inventory_id->id);

                        //Update Order item Deal
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'entity_id' => $deals->entity_id,
                            'delivery_status' => 'delivered'
                        ];
                        // echo "<pre>"; print_r($params);
                        $oi_response = $this->_pLib->apiUpdate($params);
                        $oi_response = json_decode(json_encode($oi_response));

                    }

                     $this->_emailContentGift .= $email_cont;
                     unset($email_cont);
                    //$this->_emailContent .= $this->_emailContentGift;
                }
            }
            else{
               // $normal_product++;
                if($item_deals->data->page->total_records > 0) {

                    $emailContent = '';
                    foreach ($item_deals->data->order_item_deal as $deals) {

                        $inventory =  $sys_flat_model->getDataByWhere(' entity_id = '.$deals->inventory_id->id,array($column));
                        $product_code = $inventory[0]->voucher_code;

                        $emailContent .= '<br>';
                        $emailContent .= $deals->product_id->value.' has voucher '.$product_code;

                        $this->_inventory_lib->updateStatusSold($deals->inventory_id->id);

                        //Update Order item Deal
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'entity_id' => $deals->entity_id,
                            'delivery_status' => 'delivered'
                        ];
                        // echo "<pre>"; print_r($params);
                        $oi_response = $this->_pLib->apiUpdate($params);
                        $oi_response = json_decode(json_encode($oi_response));
                    }

                    $this->_emailContent .= $emailContent;
                }


            }

                //Update Order Item
              /*  $params = [
                    'entity_type_id' => 'order_item',
                    'entity_id' => $order_item->entity_id,
                    'delivery_status' => 'delivered'
                ];

                // echo "<pre>"; print_r($params);
                $oi_response = $this->_pLib->apiUpdate($params);
                $oi_response = json_decode(json_encode($oi_response));*/
    }


    /**
     * @param $order_id
     * @param $order
     * @param $order_items
     * @return mixed
     */
    public function processOutOfStockItem($order_id,$order,$order_items)
    {
        $this->_assignData['error'] = 0;
        $this->_assignData['message'] =  trans('system.success');
        $this->_assignData['message'] =  '';
        
        $this->_emailContent = '';
        
        try {
            //Get Inventory of Item
              //  $this->_emailContent = "<br>The ordered items are following <br>";

                $this->_mLib = new Cards(request('vendor', 'mint_route'));
                $this->_oLib = new Cards(request('vendor', 'one_prepay'));

                $flat_table = new SYSTableFlat('vendor');
                $this->_mVendor = $flat_table->getColumnByWhere(' identifier = "mintroute"','entity_id');
                 $this->_oVendor  = $flat_table->getColumnByWhere(' identifier = "oneprepay"','entity_id');

                foreach ($order_items as $order_item) {

                    $this->_processDeal($order_id,$order_item,$order_item->item_type->value);
                    $this->processInStockItem($order_id,$order_item,$order_item->item_type->value);

                }

            $email_lib = new EmailLib();
            $order_history = new OrderHistory();

            if($this->_emailContentGift != ''){
                 $this->_emailContent .= $this->_emailContentGift;
                $email_lib->sendGiftEmail($order,$this->_emailContentGift);
            }


            if ($this->_emailContent != '') {
                $email_lib->sendOrderEmail($order, $this->_emailContent);
            }

            $order_history->updateOrderDelivered($order_id);

        }
        catch ( \Exception $e ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] .=  $e->getMessage();
            echo $e->getTraceAsString();
            // throw new \Exception($e->getMessage());
        }

        unset($this->_emailContent);
        unset($this->_emailContentGift);
        $this->_assignData['message'] = empty($this->_assignData['message']) ? trans('system.success') : $this->_assignData['message'];
        return $this->_assignData;
    }

    private function _processDeal($order_id,$order_item,$item_type)
    {
        try{
            $params = array(
                'entity_type_id' => 'order_item_deal',
                'order_item_id' => $order_item->entity_id,
                'order_id' => $order_id,
                'mobile_json' => 1,
                'order_from' => 'vendor_stock',
                'in_detail' => 1
            );

            $item_deals =  $this->_pLib->apiList($params);
            $item_deals = json_decode(json_encode($item_deals));

            if($item_deals->data->page->total_records > 0) {

                if($item_type == 'deal'){
                    $this->_emailContent .= '<br>';
                    $this->_emailContent .= 'You have ordered deal: '.$order_item->product_id->value . ':';
                }

                $this->_assignData['deal_count'] = 0;

                foreach ($item_deals->data->order_item_deal as $deal) {
                    $this->_processProduct($order_id,$deal,$item_type,$deal->entity_id);

                }

                //Update Order Item
               /* $param = [
                    'entity_type_id' => 'order_item',
                    'entity_id'     => $order_item->entity_id,
                    'delivery_status' => 'delivered'
                ];

                if($this->_assignData['deal_count'] > 0
                    && count($item_deals->data->order_item_deal) == $this->_assignData['deal_count']){
                    $param['delivery_status'] = 'delivered';

                }else{
                    $param['delivery_status'] = 'pending';
                }

                $this->_pLib->apiUpdate($param);*/
            }
        }
        catch ( \Exception $e ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] .=  $e->getMessage();
            // throw new \Exception($e->getMessage());
        }

    }

    /**
     * @param $order_id
     * @param $order_item
     */
    private function _processProduct($order_id,$order_item,$item_type,$deal_id = false)
    {
        try {
            echo "<h5>Order# $order_id</h5>";
            $cat_ids = '';
            $order_item_id = ($deal_id) ? $deal_id : $order_item->entity_id;

            if (count($order_item->product_id->detail->category_id) > 0) {
                foreach ($order_item->product_id->detail->category_id as $cat_id) {
                    $category_ids[] = $cat_id->category_id;
                }
                $cat_ids = implode(',', $category_ids);
            }

            $mintroute_product_id = $order_item->product_id->detail->mintroute_product_id;
            $prepay_product_id = $order_item->product_id->detail->oneprepay_product_id;

            $mintroute_product_info = json_decode($order_item->product_id->detail->mintroute_product_info);
            $oneprepay_product_info = json_decode($order_item->product_id->detail->oneprepay_product_info);
             echo "<pre>"; print_r($mintroute_product_info);
            echo "<pre>"; print_r($oneprepay_product_info);
            $mintroute_order = FALSE;
            $prepay_order = FALSE;

            //Compare Both
            if (!empty($mintroute_product_id) && !empty($prepay_product_id)) {

                if ($mintroute_product_info->denomination_value <= $oneprepay_product_info->denomination_value) {
                    //Order from mintroute
                    $mintroute_order = TRUE;
                } else {
                    //Order from One Prepay
                    $prepay_order = TRUE;
                }
            } elseif (!empty($mintroute_product_id) && empty($prepay_product_id)) { //Order from mintroute
                $mintroute_order = TRUE;
            } elseif (empty($mintroute_product_id) && !empty($prepay_product_id)) { //Order from One Prepay
                $prepay_order = TRUE;
            }
            else{
                echo '<br>'.$order_item->product_id->detail->title. ' not integrated with vendors<br>';
            }
//dump($mintroute_order);
                try {
                    if ($mintroute_order) {

                        $vendor_id = isset($this->_mVendor->entity_id) ? $this->_mVendor->entity_id : '';
                        //Order from mintroute
                        $order_response = $this->_mLib->purchase(['denomination_id' => $mintroute_product_id]);
                        $this->_vendorOrderLogsModel->add('mintroute', $order_id, $order_item_id,$deal_id, $order_item->product_id->id, ['denomination_id' => $mintroute_product_id], (array)$order_response);
                      //  echo "<pre>"; print_r($order_response);
                        if (isset($order_response->status) && $order_response->status == 1) {

                            //echo "<pre>"; print_r($order_response); exit;
                            $voucher_arr = (array)$order_response->voucher;
                            $voucher_code = $voucher_arr['Serial Number'];
                        }

                    }

                    if ($prepay_order) {

                        $vendor_id = isset($this->_oVendor->entity_id) ? $this->_oVendor->entity_id : '';
                        //Order from One Prepay
                        $order_response = $this->_oLib->purchase(['denomination_id' => $prepay_product_id, 'amount' => $oneprepay_product_info->denomination_value]);
                        $this->_vendorOrderLogsModel->add('oneprepay', $order_id, $order_item_id, $deal_id,$order_item->product_id->id, ['denomination_id' => $mintroute_product_id], (array)$order_response);

                        if ($order_response['StatusCode'] == 0) {
                            $voucher_code = $order_response['PinData']['PinSerial'];
                        }

                    }
                   // echo $voucher_code.'voucherCode';
                   // exit;
                    if(isset($order_response)){
                        echo "<pre>"; print_r($order_response);
                    }

                    // change keys
                    if (isset($order_response) && (isset($voucher_code) && $voucher_code != '')) {

                        //Add Inventory
                        $params = [
                            'entity_type_id' => 'inventory',
                            'vendor_id' => $vendor_id,
                            'category_id' => $cat_ids,
                            'brand_id' => $order_item->product_id->detail->brand_id->id,
                            'product_id' => $order_item->product_id->id,
                            'voucher_code' => $voucher_code,
                            'order_from' => 'vendor_stock',
                            'availability' => 'sold',
                        ];
                        //  echo "<pre>"; print_r($params);
                        $inventory_response = $this->_pLib->apiPost($params);
                        $inventory_response = json_decode(json_encode($inventory_response));
                        // echo "<pre>"; print_r($inventory_response);
                        if (isset($inventory_response->data->entity->entity_id)) {

                            //Update Order Item
                            $params = [
                                'inventory_id' => $inventory_response->data->entity->entity_id,
                                'vendor_id' => $vendor_id,
                                'delivery_status' => 'delivered'
                            ];

                            $params['entity_type_id'] = 'order_item_deal';
                            $params['entity_id'] = $deal_id;
                            /*if ($item_type == 'deal') {

                                $params['entity_type_id'] = 'order_item_deal';
                                $params['entity_id'] = $deal_id;
                            } else {
                                $params['entity_type_id'] = 'order_item';
                                $params['entity_id'] = $order_item->entity_id;
                            }*/

                            // echo "<pre>"; print_r($params);
                            $oi_response = $this->_pLib->apiUpdate($params);
                            $oi_response = json_decode(json_encode($oi_response));
                            // echo "<pre>"; print_r($oi_response);

                            $this->_assignData['deal_count']++;
                        }

                        $this->_emailContent .= '<br>';
                        $this->_emailContent .= $order_item->product_id->value . ' has voucher ' . $voucher_code;

                    } else {
                        $this->_emailContent .= '<br>';
                        $this->_emailContent .= $order_item->product_id->value . ' is out of stock';
                    }

                } catch (\Exception $ee) {
                    //
                    $this->_assignData['error'] = 1;
                    $this->_assignData['message'] .= 'Order# ' . $order_id . ' ' . $order_item->product_id->value . ' is out of stock';
                    $this->_assignData['message'] .= ' - Error: ';
                    $this->_assignData['message'] .= $ee->getMessage();
                   // echo  $ee->getTraceAsString();
                    //  print_r($ee->getMessage());
                    //  throw new \Exception($ee->getMessage());

                    $this->_emailContent .= '<br>';
                    $this->_emailContent .= $order_item->product_id->value . ' is out of stock';

                    //Update Order Item
                    $params = [
                        'entity_type_id' => 'order_item_deal',
                        'entity_id' => $deal_id,
                        'vendor_id' => $vendor_id,
                        'delivery_status' => 'pending'
                    ];
                    /*if ($item_type == 'deal') {
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'entity_id' => $deal_id,
                            'vendor_id' => $vendor_id,
                            'delivery_status' => 'pending'
                        ];
                    } else {
                        $params = [
                            'entity_type_id' => 'order_item',
                            'entity_id' => $order_item->entity_id,
                            'vendor_id' => $vendor_id,
                            'delivery_status' => 'pending'
                        ];
                    }*/

                    $ret = $this->_pLib->apiUpdate($params);
                    $ret = json_decode(json_encode($ret));
                    $this->_assignData['message'] .= $ret->message;

                    //echo "<pre>"; print_r($ret);
                }


        } catch ( \Exception $e ) {
                $this->_assignData['error'] = 1;
                $this->_assignData['message'] .=  $e->getMessage();
                $this->_assignData['debug']  =  $e->getTraceAsString();
                // throw new \Exception($e->getMessage());
            }

            return  $this->_assignData;
    }
    
    
}