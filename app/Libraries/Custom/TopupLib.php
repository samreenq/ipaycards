<?php
/**
 * Created by PhpStorm.
 * User: Samreen Quyyum
 * Date: 5/29/2019
 * Time: 2:10 PM
 */
namespace App\Libraries\Custom;

use App\Http\Models\SYSTableFlat;
use App\Libraries\Services\Topup;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;

Class TopupLib
{

    private $_apiData = array();

    /**
     * Mobile Topup
     *
     * @param Request $request
     *
     * @return array
     */
    public function mobileTopup($request)
    {
        // validation
        $validation = validator($request, [
            'service_type' => 'required|in:du,etisalat',
            'recharge_type' => 'required_if:service_type,du',
            'customer_no' => 'required|numeric|min:5',
            'amount' => 'required|numeric|min:5',
        ]);

        if ( $validation->fails() ) {
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $validation->errors()->first();
        } else {

            try {

                // load library
                $simbox_lib = new Topup('simbox');
                $one_prepay_lib = new Topup('one_prepay');

                // init vars
                $params = $request;
                $response = NULL;
                $params['customer_no'] = "+971589802894";

                // get product denomination (product code for one_prepay)
                $products = $one_prepay_lib->products([
                    'brand' => $params['service_type']
                ]);
                $denomination = $products['denominations'][0]['denomination_id'];

               // echo '<pre>'; print_r($params);

                // if request for du
                if ( $params['service_type'] == 'du' ) {

                    try {
                        // send
                        $response = $simbox_lib->send([
                            'account_no' => ltrim($params['customer_no'],"+"),
                            'type' => $params['recharge_type'],
                            'amount' => $params['amount']
                        ]);

                    } catch ( \Exception $e ) {
                        // if load credit, let it continue with one_prepay
                        if ( intval($params['recharge_type']) == 5 ) {
                            try {
                                // send
                                $response = $one_prepay_lib->send([
                                    'account_no' => $params['customer_no'],
                                    'amount' => $params['amount'],
                                    'denomination_id' => $denomination
                                ]);

                            } catch ( \Exception $e ) {
                                // if load credit, let it continue to other API
                                //throw new \Exception($e->getMessage());
                                $this->_apiData['error'] = 1;
                                $this->_apiData['message'] = $e->getMessage();
                                $this->_apiData['trace'] = $e->getTraceAsString();
                                return  $this->_apiData;
                            }
                        } else{
                            // throw new \Exception($e->getMessage());
                            $this->_apiData['error'] = 1;
                            $this->_apiData['message'] = $e->getMessage();
                            $this->_apiData['trace'] = $e->getTraceAsString();
                            return  $this->_apiData;
                        }

                    }

                } else {

                    try {
                        // send
                        $response = $one_prepay_lib->send([
                            'account_no' => $params['customer_no'],
                            'amount' => $params['amount'],
                            'denomination_id' => $denomination
                        ]);

                    } catch ( \Exception $e ) {
                        // if load credit, let it continue to other API
                      // throw new \Exception($e->getMessage());
                        $this->_apiData['error'] = 1;
                        $this->_apiData['message'] = $e->getMessage();
                        $this->_apiData['trace'] = $e->getTraceAsString();
                        return  $this->_apiData;
                    }

                }


                // assign to output
                $this->_apiData['data'] = $response;
                $this->_apiData['response'] = trans('system.success');
                $this->_apiData['error'] = 0;

                // message
                $this->_apiData['message'] = trans('system.success');


            } catch ( \Exception $e ) {
                $this->_apiData['error'] = 1;
                $this->_apiData['message'] = $e->getMessage();
                $this->_apiData['trace'] = $e->getTraceAsString();
            }

        }


        return $this->_apiData;
    }
    /**
     * Service Topup
     *
     * @param Request $request
     *
     * @return array
     */
    public function serviceTopup($request)
    {
        // validation
        $validation = validator($request, [
            'service_type' => 'required|in:fly_dubai,addc',
            'customer_no' => 'required|string|min:5',
            'amount' => 'required|numeric|min:1',
            'request_key' => 'required|string|min:5',
        ]);

        if ( $validation->fails() ) {
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $validation->errors()->first();
        } else {

            try {

                // load library
                $one_prepay_lib = new Topup('one_prepay');

                // init vars
                $params = $request;
                $response = NULL;

                // get product denomination (product code for one_prepay)
                $products = $one_prepay_lib->products([
                    'brand' => $params['service_type']
                ]);
                $denomination = $products['denominations'][0]['denomination_id'];

                try {
                    // send
                    $response = $one_prepay_lib->sendVerified([
                        'account_no' => $params['customer_no'],
                        'amount' => $params['amount'],
                        'denomination_id' => $denomination,
                        'request_key' => $params['request_key'],
                    ]);

                } catch ( \Exception $e ) {
                    // if load credit, let it continue to other API
                  //  throw new \Exception($e->getMessage());
                    $this->_apiData['error'] = 1;
                    $this->_apiData['message'] = $e->getMessage();
                    $this->_apiData['trace'] = $e->getTraceAsString();
                }


                // assign to output
                $this->_apiData['data'] = $response;
                $this->_apiData['response'] = trans('system.success');
                $this->_apiData['error'] = 0;

                // message
                $this->_apiData['message'] = trans('system.success');


            } catch ( \Exception $e ) {
                $this->_apiData['error'] = 1;
                $this->_apiData['message'] = $e->getMessage();
                $this->_apiData['trace'] = $e->getTraceAsString();
            }

        }


        return $this->_apiData;
    }

    /**
     * Topup Order - WEB
     * @param $request
     * @return array|mixed
     */
    public function topupOrder($request)
    {

        $request = is_array($request) ? (object) $request : $request;

        try{

            //check lead order
            $flat_table = new SYSTableFlat('lead_topup');
            $topup_order = $flat_table->getDataByWhere(' entity_id = '.$request->lead_topup_id);

            if($topup_order){

                $topup_order_raw = $topup_order[0];
                $data = json_decode($topup_order_raw->order_detail,true);
                $transaction_id = $request->lead_topup_id;

                if($data['paid_amount'] > 0){

                    //Get Payment Status/////////////////
                    $payment_lib = new PaymentLib();
                    $payment_response =  $payment_lib->getPaymentStatus(['order_id'=>$request->lead_topup_id,'service_type'=>$data['service_type']],'topup');

                    // echo '<pre>'; print_r($payment_response); exit;

                    if(!isset($payment_response->result)){
                        return array(
                            'error' => 1,
                            'message' => "Unable to process request, Please contact to support team"
                        );
                    }

                    if(strtolower($payment_response->result) == 'error'){
                        return array(
                            'error' => 1,
                            'message' => "Unable to get payment status, Please contact to support team",
                            /* 'debug'  => $response->error->explanation*/
                        );
                    }


                    $card = $payment_response->sourceOfFunds->provided->card;
                    $transaction_id = $payment_response->transaction[0]->authorizationResponse->transactionIdentifier;
                }



                //Send Topup/////////////////////
                //$params = $data;
                // $data['customer_no'] = "+".$data['customer_no'];
                $data['reference_id'] = ($data['source'] == 'web') ? '' : '';
              //  echo "<pre>"; print_r($data); exit;

                if(in_array($data['service_type'],array('du','etisalat'))){
                    $send_topup =  $this->mobileTopup($data);
                }else{

                   // echo "<pre>"; print_r($data);
                    $send_topup = $this->serviceTopup($data);

                  //  echo "<pre>"; print_r($send_topup); exit;
                }

               // echo "<pre>"; print_r($send_topup);
                if($send_topup['error'] == 1){
                    return $send_topup;
                }

                //Save Topup History///////////////////////
              //  echo "<pre>"; print_r($send_topup);
                $data['entity_type_id'] = 'topup';
                $t_response = isset($send_topup['data']) ? json_encode($send_topup['data']) : '';
                $data['topup_response'] = "$t_response";


                // $data['transaction_response'] = json_encode($payment_response);
                $data['reference_id'] = isset($request->reference_id) ? $request->reference_id : '127.0.0.1';
                $data['lead_order_id'] = $request->lead_topup_id;
                $data['card_id'] = isset($card->nameOnCard) ? $card->nameOnCard : '';
                $data['card_type'] = isset($card->scheme) ? $card->scheme :'';
                $data['card_last_digit'] = isset($card->number) ? substr($card->number,-4) : '';
                $data['transaction_id'] = $transaction_id;
                $data['wallet'] = (string) $data['wallet'];
                $data['paid_amount'] = (string) $data['paid_amount'];


                $entity_lib = new Entity();
                $topup_response = $entity_lib->apiPost($data);
                $topup_response = json_decode(json_encode($topup_response));

             //  echo "<pre>"; print_r($topup_response); exit;
                if (isset($topup_response->data->entity->entity_id)) {
                    $param = array(
                        'entity_type_id' => 'topup',
                        'entity_id' => $topup_response->data->entity->entity_id,
                        'topup_no' => 'T'.$topup_response->data->entity->entity_id,
                    );

                    $entity_lib->apiUpdate($param);

                    //Update Wallet
                    if($data['wallet'] > 0 && $data['customer_id'] > 0){
                        $wallet = $data['wallet'];

                        $pos_arr = [];
                        $pos_arr['entity_type_id'] = 'wallet_transaction';
                        $pos_arr['credit'] = "0";
                        $pos_arr['debit'] = "$wallet";
                        $pos_arr['balance'] = '';
                        $pos_arr['customer_id'] = $data['customer_id'];
                        $pos_arr['transaction_type'] = 'debit';
                        $pos_arr['wallet_source'] = 'topup';
                        $pos_arr['topup_id'] = $topup_response->data->entity->entity_id;
                        $pos_arr['mobile_json'] = isset($request->mobile_json) ? $request->mobile_json : 0;
                        $pos_arr['login_entity_id'] = $data['customer_id'];
                         $entity_lib->doPost($pos_arr);
                    }


                    $this->_apiData['error'] = 0;
                    $this->_apiData['message'] = 'Success';
                    $this->_apiData['data'] = array('order_id' => 'T'.$topup_response->data->entity->entity_id);
                }
                else{
                   return $topup_response;
                }
                // echo "<pre>"; print_r($resp);

            }
            else{
                $this->_apiData['error'] = 1;
                $this->_apiData['message'] = 'No order found';
            }
        } catch ( \Exception $e ) {
            // if load credit, let it continue to other API
            //  throw new \Exception($e->getMessage());
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }


        return $this->_apiData;
    }

    /**
     * Topup Order - Mobile
     * @param $request
     * @return array|mixed|object
     */
    public function topupOrderApi($request)
    {
        try{

            //Validate Request
           $validate = $this->validateRequest($request);
            if($validate['error'] == 1){
                return $validate;
            }

            //Create Lead Order
            $request['customer_id'] = isset($request['user_id']) ? $request['user_id'] : "";
            $lead_order = $this->createLead($request);
            if($lead_order->error == 1){
                return $lead_order;
            }

            $lead_order_id = $lead_order->data->entity->entity_id;

            try{

                if($request['paid_amount'] > 0){

                    //Payment
                    $payment_request = $request['payment'];
                    $payment_request['lead_order_id'] = $lead_order_id;
                    $payment_request['service_type'] = $request['service_type'];

                    $payment_lib = new OrderLib();
                    $payment_response = $payment_lib->payment($payment_request,'topup');
                    $payment_response = (object)($payment_response);
                    // echo '<pre>'; print_r($payment_response); exit;
                    if(isset($payment_response->error)){
                        return $payment_response;
                    }
                }
                else{
                    $payment_response = false;
                }

                // Topup
                if(in_array($request['service_type'],array('du','etisalat'))){
                    $send_topup =  $this->mobileTopup($request);
                }else{
                    $send_topup = $this->serviceTopup($request);
                }


                if($send_topup['error'] == 1){
                    return $send_topup;
                }

                //Save Topup History
                return $this->saveTopup($lead_order,$send_topup,$payment_response);

            }
            catch ( \Exception $e ) {
                // if load credit, let it continue to other API
                //  throw new \Exception($e->getMessage());
                $this->_apiData['error'] = 1;
                $this->_apiData['message'] = $e->getMessage();
                $this->_apiData['trace'] = $e->getTraceAsString();
            }


        }
        catch ( \Exception $e ) {
            // if load credit, let it continue to other API
            //  throw new \Exception($e->getMessage());
            $this->_apiData['error'] = 1;
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;
    }

    /**
     * @param $request
     * @return array|mixed
     */
    public function createLead($request)
    {
        $params = array(
            'entity_type_id' => 'lead_topup',
            'order_detail' => json_encode($request)
        );

        $entity_lib = new Entity();
        $lead_order_response =  $entity_lib->apiPost($params);
        $lead_order_response = json_decode(json_encode($lead_order_response));

        if (isset($lead_order_response->data->entity->entity_id)) {
            return $lead_order_response;
        }else{
            return array('error'=> 1, 'message' => $lead_order_response->message);
        }
    }

    /**
     * @param $lead_order
     * @param $send_topup
     * @param $payment_response
     * @return array|mixed
     */
    public function saveTopup($lead_order,$send_topup,$payment_response = false)
    {
        try{

            //Save Topup History///////////////////////

            //Create Order
            $lead_order_id = $lead_order->data->entity->entity_id;
            $params = json_decode($lead_order->data->entity->attributes->order_detail, true);
            $params['entity_type_id'] = 'topup';
            $params['mobile_json'] = 1;

            if($params['paid_amount'] > 0){

                if(isset($payment_response->gatewayResponse->sourceOfFunds->provided->card)){

                    $card = $payment_response->gatewayResponse->sourceOfFunds->provided->card;
                    //
                    // $data['transaction_response'] = json_encode($payment_response);
                    $params['card_id'] = $card->nameOnCard;
                    $params['card_type'] = $card->scheme;
                    $params['card_last_digit'] = substr($card->number,-4);
                    $params['transaction_id'] = $payment_response->gatewayResponse->transaction->id;
                    unset($params['payment']);
                }
            }else{
                $params['transaction_id'] = "$lead_order_id";
            }

            $params['lead_order_id'] = "$lead_order_id";
            $params['topup_response'] = isset($send_topup['data']) ? json_encode($send_topup['data']) : '';

            // echo '<pre>'; print_r($params); exit;

            $entity_lib = new Entity();
            $topup_response = $entity_lib->apiPost($params);
            $topup_response = json_decode(json_encode($topup_response));

             //echo "<pre>"; print_r($topup_response);
            if (isset($topup_response->data->topup->entity_id)) {
                $param = array(
                    'entity_type_id' => 'topup',
                    'entity_id' => $topup_response->data->topup->entity_id,
                    'topup_no' => 'T' . $topup_response->data->topup->entity_id,
                    'mobile_json' => 1
                );
              //  echo "<pre>"; print_r($param);
               $ret =  $entity_lib->apiUpdate($param);

                //Update Wallet
                if($params['wallet'] > 0 && $params['customer_id'] > 0){
                    $wallet = $params['wallet'];

                    $pos_arr = [];
                    $pos_arr['entity_type_id'] = 'wallet_transaction';
                    $pos_arr['credit'] = "0";
                    $pos_arr['debit'] = "$wallet";
                    $pos_arr['balance'] = '';
                    $pos_arr['customer_id'] = $params['customer_id'];
                    $pos_arr['transaction_type'] = 'debit';
                    $pos_arr['wallet_source'] = 'topup';
                    $pos_arr['topup_id'] = $topup_response->data->topup->entity_id;
                    $pos_arr['mobile_json'] = 1;
                    $pos_arr['login_entity_id'] = $params['customer_id'];
                    $entity_lib->doPost($pos_arr);

                }
               return $ret = json_decode(json_encode($ret));
            }
            return $topup_response;
        }
        catch ( \Exception $ee ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] =  $ee->getMessage();
            $this->_assignData['trace'] = $ee->getTraceAsString();
            // throw new \Exception($e->getMessage());
        }

        return $this->_assignData;

    }

    /**
     * @param $request
     * @return mixed
     */
    public function validateRequest($request)
    {
        $rules = [
            'service_type' => 'required|in:du,etisalat,fly_dubai,addc',
            'customer_no' => 'required|numeric|min:5',
            'amount' => 'required|numeric|min:5',
        ];

        if(isset($request['service_type'])){
            if (in_array($request['service_type'], array('du', 'etisalat'))) {
                $rules['recharge_type'] ='required_if:service_type,du';
            }
            else if (in_array($request['service_type'], array('fly_dubai', 'addc'))) {
                $rules['request_key'] ='required|string|min:5';
            }
        }

        $validation = validator($request, $rules);
        if ($validation->fails()) {
            $apiData['error'] = 1;
            $apiData['message'] = $validation->errors()->first();
        } else {
            $apiData['error'] = 0;
            $apiData['message'] = 'success';
        }
        return $apiData;
    }


}