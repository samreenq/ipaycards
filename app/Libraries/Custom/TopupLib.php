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


                //Save Topup History
               /* $arr = array(
                    'entity_type_id' => 'topup',
                    'service_type' => isset($params['service_type']) ? $params['service_type'] : '',
                    'customer_no' => $params['customer_no'],
                    'amount' => $params['amount'],
                    'recharge_type' => isset($params['recharge_type']) ? $params['recharge_type'] : '',
                    'request_key' => isset($params['request_key']) ? $params['request_key'] : '',
                    'source' => isset($params['source']) ? $params['source'] : '',
                    'reference_id' => isset($params['reference_id']) ? $params['reference_id'] : '',
                    'topup_response' => isset($response) ? json_encode($response) : '',
                );

                $entity_lib = new Entity();
                $topup_response = $entity_lib->apiPost($arr);
                $topup_response = json_decode(json_encode($topup_response));

                //  echo "<pre>"; print_r($inventory_response);
                if (isset($topup_response->data->entity->entity_id)) {
                    $param = array(
                        'entity_type_id' => 'topup',
                        'entity_id' => $topup_response->data->entity->entity_id,
                        'topup_no' => 'T'.$topup_response->data->entity->entity_id,
                    );

                    $entity_lib->apiUpdate($param);
                }*/

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

                //Get Payment Status/////////////////
                $payment_lib = new PaymentLib();
                $payment_response =  $payment_lib->getPaymentStatus(['order_id'=>$request->lead_topup_id]);

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


                //Send Topup/////////////////////
                //$params = $data;
                // $data['customer_no'] = "+".$data['customer_no'];
                $data['reference_id'] = ($data['source'] == 'web') ? '' : '';
                // echo "<pre>"; print_r($data); exit;

                if(in_array($data['service_type'],array('du','etisalat'))){
                    $send_topup =  $this->mobileTopup($data);
                }else{
                    $send_topup = $this->serviceTopup($data);
                }

               // echo "<pre>"; print_r($send_topup);
                if($send_topup['error'] == 1){
                    return $send_topup;
                }

                //Save Topup History///////////////////////

                $data['entity_type_id'] = 'topup';
                $data['topup_response'] = isset($send_topup['data']) ? json_encode($send_topup['data']) : '';

                $card = $payment_response->sourceOfFunds->provided->card;

                // $data['transaction_response'] = json_encode($payment_response);
                $data['reference_id'] = isset($request->reference_id) ? $request->reference_id : '127.0.0.1';
                $data['lead_order_id'] = $request->lead_topup_id;
                $data['card_id'] = $card->nameOnCard;
                $data['card_type'] = $card->scheme;
                $data['card_last_digit'] = substr($card->number,-4);
                $data['transaction_id'] = $payment_response->transaction[0]->authorizationResponse->transactionIdentifier;

                //echo "<pre>"; print_r($data);
                $entity_lib = new Entity();
                $topup_response = $entity_lib->apiPost($data);
                $topup_response = json_decode(json_encode($topup_response));

               // echo "<pre>"; print_r($topup_response);
                if (isset($topup_response->data->entity->entity_id)) {
                    $param = array(
                        'entity_type_id' => 'topup',
                        'entity_id' => $topup_response->data->entity->entity_id,
                        'topup_no' => 'T'.$topup_response->data->entity->entity_id,
                    );

                    $entity_lib->apiUpdate($param);

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



}