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
use App\Libraries\OrderSendCards;
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
        echo '<h3>Orders to Process</h3>';

        try {
            $current_date = date('Y-m-d');

            $order_flat = new OrderFlat();
            $order_process = new OrderSendCards();
            $entity_lib = new Entity();

            $orders = $order_flat->getVendorStockOrder();
            //echo "<pre>"; print_r($orders); exit;
            if (count($orders) > 0) {

                foreach ($orders as $order_data) {

                    $params = [
                        'entity_type_id' => 'order',
                        'entity_id' => $order_data->order_id,
                        'hook' => 'order_item',
                        'mobile_json' => 1,
                        'in_detail' => 1
                    ];

                    $response = $entity_lib->apiGet($params);
                    $response = json_decode(json_encode($response));
                    // echo "<pre>"; print_r($response); exit;
                    if (isset($response->data->order)) {

                        $order = $response->data->order;
                        $return = $order_process->processOutOfStockItem($order_data->order_id, $order, $order->order_item);

                        $this->_apiData['message'] = $return['message'];

                        // echo "<pre>"; print_r($order->order_item); exit;
                    }
                    break;
                } //end of foreach
            } else {
                $this->_apiData['message'] = 'No Orders Found';
            }

        } catch (\Exception $e) {
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }


}