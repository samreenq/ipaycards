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
use App\Http\Models\Custom\OrderFlat;
use App\Libraries\Driver;
use App\Libraries\OrderProcess;
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
            'hook' => 'order_item',
            'mobile_json' => 1,
            'in_detail' => 1
        );

        $entity_lib = new Entity();
        $response = $entity_lib->apiList($params);
        $response = json_decode(json_encode($response));

        if(isset($response->data->page->total_records)){

            if($response->data->page->total_records > 0){

                $orders = $response->data->order;

                echo '<h3>Orders to Process</h3>';


                if(count($orders) > 0){

                    foreach($orders as $order_data){

                        $order_id = $order_data->entity_id;
                        $order = $order_data;

                        //Check In Stock or Out of stock
                        $order_flat = new OrderFlat();
                        $vendor_stock_count = $order_flat->checkVendorStockOrder($order_id);

                        //in stock Order
                        $order_process_lib = new OrderProcess();
                        if($vendor_stock_count == 0){
                           // echo "<pre>"; print_r($order_data); exit;
                            $order_process_lib->processInStockItem($order_id,$order,$order_data->order_item);

                        }else{

                            //Vendor Stock Order


                        }

                    }

                }
            }
        }


    }







}