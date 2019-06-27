<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Libraries\Custom\PaymentLib;
use App\Libraries\Custom\TopupLib;
use App\Libraries\System\Entity;
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

    public function getTopupSession(Request $request)
    {
        try{
           // echo "<pre>"; print_r($request->all()); exit;
            $this->_apiData['error'] = 0;

            $params = array(
                'entity_type_id' => 'lead_topup',
                'order_detail' => json_encode($request->data),

            );

            $entity_lib = new Entity();

           // echo "<pre>"; print_r($params);
           $lead_order =  $entity_lib->apiPost($params);
            $lead_order = json_decode(json_encode($lead_order));

           // echo "<pre>"; print_r($lead_order); exit;
            if($lead_order->error == 0){

                if (isset($lead_order->data->entity->entity_id)) {

                    $lead_order_id = $lead_order->data->entity->entity_id;
                    $request_param = ['lead_order_id'=>$lead_order_id,'amount' => $request->amount,'service_type'=>$request->data['service_type']];

                    $payment_lib = new PaymentLib();
                    $this->_apiData['data'] = $payment_lib->getSessionID($request_param,'topup');
                    $this->_apiData['lead_topup_id'] = $lead_order_id;
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

}