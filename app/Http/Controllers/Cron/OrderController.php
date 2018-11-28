<?php

/**
 * This is written to send notification
 * Class CustomNotificationController
 * Date: 13-07-2018
 * Author: Cubix
 * Copyright: cubix
 */

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Http\Models\Conf;
use App\Http\Models\Custom\OrderFlat;
use App\Http\Models\EmailTemplate;
use App\Http\Models\Setting;
use App\Http\Models\SYSTableFlat;
use App\Libraries\Driver;
use App\Libraries\GeneralSetting;
use App\Libraries\OrderStatus;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;

Class OrderController extends Controller
{

    /**
     * @param Request $request
     */
    public function processOrder(Request $request)
    {
        $current_date = date('Y-m-d');

        $params = array(
            'entity_type_id' => 15,
            'order_status' => 'pending',
           // 'where_condition' => ' AND created_date >= '.trim($current_date)
            'hook' => 'order_item'
        );

        $entity_lib = new Entity();
        $response = $entity_lib->apiList($params);
        $response = json_decode(json_encode($response));

        if(isset($response->data->page->total_records)){

            if($response->data->page->total_records > 0){

                $orders = $response->data->entity_listing;

                echo '<h3>Orders to Process</h3>';
                //echo "<pre>"; print_r($orders);

                if(count($orders) > 0){

                    foreach($orders as $order_data){

                        //echo "<pre>"; print_r($order_data); exit;
                        $order_id = $order_data->entity_id;
                        $order = $order_data->attributes;

                        //Check In Stock or Out of stock
                        $order_flat = new OrderFlat();
                        $vendor_stock_count = $order_flat->checkVendorStockOrder($order_id);
                        $order_items =  $order_data->order_item;

                        //in stock Order
                        if($vendor_stock_count == 0){
                            $this->_processInStockItem($order_id,$order,$order_items);

                        }else{

                            //Vendor Stock Order

                        }

                    }

                }
            }
        }


    }

    /**
     * @param $order
     * @param $order_items
     */
    private function _processInStockItem($order_id,$order,$order_items)
    {
        //Get Inventory of Item
        if($order_items){

            $email_content = "<br>The ordered items are following <br>";

            foreach($order_items as $order_item_data){

                $order_item = $order_item_data->attributes;
                $product_code = $order_item->inventory_id->value;
                //Create email content
                $email_content .= $order_item->product_id->value.' has product code '.$product_code.'<br>';

                $this->_updateInventory($order_item->inventory_id->id);
            }

            //Send Email
            $this->_sendEmail($order,$email_content);
            $this->_updateOrder($order_id);

        }

    }

    /**
     * @param $order_id
     */
    private function _updateOrder($order_id){

        $entity_lib = new Entity();
        //Update Inventory Status
        $params = array(
            'entity_type_id' => 68,
            'entity_id' => $order_id,
            'order_status' => 'delivered',
        );

        $entity_lib->apiPost($params);
    }

    /**
     * @param $inventory_id
     */
    private function _updateInventory($inventory_id)
    {
        $entity_lib = new Entity();
        //Update Inventory Status
        $params = array(
            'entity_type_id' => 73,
            'entity_id' => $inventory_id,
            'availability' => 'sold',
        );

        $entity_lib->apiUpdate($params);
    }

    /**
     * @param $order
     * @param $email_content
     */
    private function _sendEmail($order,$email_content)
    {
        $conf_model = new Conf();
        $setting_model = new Setting();
        $email_template_model = new EmailTemplate();

        // configuration
        $conf = $conf_model->getBy('key', 'site');
        $conf = json_decode($conf->value);

        $data = $order->customer_id->detail->auth;

        $data->created_at = date('Y-m-d H:i:s');

        // send email to new admin
        # admin email
        $setting = $setting_model->getBy('key', 'admin_email');
        $data->from = $setting->value;
        # admin email name
        $setting = $setting_model->getBy('key', 'admin_email_name');
        $data->from_name = $setting->value;

        # load email template
        $query = $email_template_model
            ->where("key", "=", 'new_order')
            ->whereNull("deleted_at");

        $query->whereNull("plugin_identifier");

        $email_template = $query->first();

        $wildcard['key'] = explode(',', $email_template->wildcards);
        $wildcard['replace'] = array(
            $conf->site_name, // APP_NAME
            url('/'), // APP_LINK
            $data->name, // ENTITY_NAME
            $order->order_number, // order number
            $email_content, // order items
        );
        # body
         $body = str_replace($wildcard['key'], $wildcard['replace'], $email_template->body);


        # subject
        $data->subject = str_replace($wildcard['key'], $wildcard['replace'], $email_template->subject);
        # send email
        $this->sendMail(
            array($data->email, $data->name),
            $body,
            (array)$data
        );
    }





}