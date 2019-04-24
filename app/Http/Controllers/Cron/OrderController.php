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

    private $_apiData;
    /**
     * @param Request $request
     */
    public function processOrder(Request $request)
    {

        try {
            $current_date = date('Y-m-d');

            $order_flat = new OrderFlat();
            $order_process = new OrderProcess();

            $orders = $order_flat->getVendorStockOrder();

            if(count($orders) > 0) {

                foreach ($orders as $order_data) {

                    $params = array(
                        'entity_type_id' => 15,
                        'entity_id' => $order_data->order_id,
                        'hook' => 'order_item',
                        'mobile_json' => 1,
                        'in_detail' => 1
                    );

                    $entity_lib = new Entity();
                    $response = $entity_lib->apiGet($params);
                    $response = json_decode(json_encode($response));
                    // echo "<pre>"; print_r($response); exit;
                    if(isset($response->data->order)){

                        $order = $response->data->order;

                        echo '<h3>Orders to Process</h3>';

                        $order_process->processOutOfStockItem($order_data->order_id,$order,$order->order_item);


                        // echo "<pre>"; print_r($order->order_item); exit;




                    }


                }
            }

            // success response
            $this->_apiData['response'] = "success";

            // message
            $this->_apiData['message'] = trans('system.success');

        } catch ( \Exception $e ) {
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }



}