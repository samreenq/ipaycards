<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Libraries\Custom\OrderLib;
use App\Libraries\Custom\PaymentLib;
use App\Libraries\Custom\TopupLib;
use App\Libraries\GeneralSetting;
use App\Libraries\System\Entity;
use App\Libraries\WalletTransaction;
use Illuminate\Http\Request;

use Validator;
use View;

Class PayController extends Controller
{

    private $_apiData = array();
    private $_mobile_json = FALSE;
    private $_langIdentifier = 'system';

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->_apiData['kick_user'] = 0;
        $this->_apiData['response'] = trans($this->_langIdentifier . ".error");
        $this->_mobile_json = intval($request->input('mobile_json', 0)) > 0 ? TRUE : FALSE;
    }

    /**
     * @param Request $request
     * @return array
     */

    public function getSessionID(Request $request)
    {
        try{

            $payment_lib = new PaymentLib();
            $this->_apiData['data'] = $payment_lib->getSessionID($request->all());
           /* $html = View::make('payment',  [])->render();
            $this->_apiData['payment_page'] = $html;*/

        } catch ( \Exception $e ) {
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }

    /**
     * @param Request $request
     * @return array
     */
    public function getTopupSession(Request $request)
    {
        try{
           // echo "<pre>"; print_r($request->all()); exit;
            $this->_apiData['error'] = 0;
            $customer_id = isset($request->user_id) ? $request->user_id : '';
            $lead_order_data = $request->data;


            $customer_wallet = new WalletTransaction();
            $wallet_data = $customer_wallet->checkWalletAmount($customer_id,$request->data['amount']);


            $wallet = $lead_order_data['wallet'] = $wallet_data['wallet'];
            $paid_amount = $lead_order_data['paid_amount'] = $wallet_data['paid_amount'];
            $lead_order_data['customer_id'] = $customer_id;


            $params = array(
                'entity_type_id' => 'lead_topup',
                'order_detail' => json_encode($lead_order_data),

            );

            $entity_lib = new Entity();

           // echo "<pre>"; print_r($params);
           $lead_order =  $entity_lib->apiPost($params);
            $lead_order = json_decode(json_encode($lead_order));

           // echo "<pre>"; print_r($lead_order); exit;
            if($lead_order->error == 0){

                if (isset($lead_order->data->entity->entity_id)) {

                    $lead_order_id = $lead_order->data->entity->entity_id;

                    $general_setting = new GeneralSetting();
                   $currency_conversion = $general_setting->getColumn('currency_conversion');

                    $converted_paid_amount = round($paid_amount*$currency_conversion,2);
                    $request_param = ['lead_order_id'=>$lead_order_id,'amount' => $converted_paid_amount,'service_type'=>$request->data['service_type']];

                    $payment_lib = new PaymentLib();
                    $this->_apiData['data'] = $payment_lib->getSessionID($request_param,'topup');
                    $this->_apiData['lead_topup_id'] = $lead_order_id;
                    $this->_apiData['wallet'] = $wallet;
                    $this->_apiData['paid_amount'] = $paid_amount;
                    $this->_apiData['converted_paid_amount'] = $converted_paid_amount;

                }
            }
            else{
                $this->_apiData['error'] = 1;
                $this->_apiData['message'] = $lead_order->message;
            }


        } catch ( \Exception $e ) {
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }

    /**
     * Create Topup Order with payment - Web
     * @param Request $request
     * @return array|mixed
     */
    public function createTopupOrder(Request $request)
    {
        try{
            $params = $request->all();

            $topup_lib = new TopupLib();
            $response = $topup_lib->topupOrder($params);

            return $response;
        }
        catch(\Exception $e){
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;
    }

    /**
     * Order Cards with payment API
     * @param Request $request
     * @return array|void
     */
    public function createOrder(Request $request)
    {
        try{
            $params = $request->all();

            $topup_lib = new OrderLib();
            $response = $topup_lib->placeOrder($params);
            $response = json_decode(json_encode($response));

            $this->_apiData['error'] = $response->error;
            $this->_apiData['message'] = $response->message;

            if(isset($response->data)){
                $this->_apiData['data'] = $response->data;
            }

            if($this->_apiData['error'] == 1 && isset($response->debug)){
                $this->_apiData['debug'] = $response->debug;
            }
        }
        catch(\Exception $e){
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;
    }

    /**
     * Topup Order with payment Api
     * @param Request $request
     * @return array
     */
    public function createTopupOrderApi(Request $request)
    {
        try{
            $params = $request->all();

            $topup_lib = new TopupLib();
            $response = $topup_lib->topupOrderApi($params);
            $response = json_decode(json_encode($response));
          // echo '<pre>'; print_r($response); exit;
            $this->_apiData['error'] = $response->error;
            $this->_apiData['message'] = $response->message;

            if(isset($response->data)){
                $this->_apiData['data']['topup'] = $response->data;
            }

            if($this->_apiData['error'] == 1 && isset($response->debug)){
                $this->_apiData['debug'] = $response->debug;
            }
           // echo "<pre>"; print_r($this->_apiData); exit;
        }
        catch(\Exception $e){
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;
    }

}