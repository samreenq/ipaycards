<?php

namespace App\Libraries\Custom;
use App\Http\Models\Custom\OrderPaymentLogs;
use App\Http\Models\Custom\TopupPaymentLogs;
use GuzzleHttp\Client;

Class PaymentLib
{

    /**
     * MintRoute constructor.
     */
    public function __construct()
    {
        $this->_client = new Client();

    }

    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function getSessionID($request,$order_type = 'order')
    {
// init params
        $request = is_array($request) ? (object) $request : $request;
       // echo '<pre>'; print_r($request); exit;
        try {

            $params = [
                "apiOperation" => "CREATE_CHECKOUT_SESSION",
                "order" => [
                    "currency" => config('service.MASTER_CARD.currency'),
                    "id" => $request->lead_order_id,
                    "amount" =>  $request->amount
                ]
            ];

            $call = $this->_client->post(
                config('service.MASTER_CARD.url').config('service.MASTER_CARD.merchant_id')."/session",
                [
                    'auth' => [config('service.MASTER_CARD.username'), config('service.MASTER_CARD.password')], /*if you don't need to use a password, just leave it null*/
                    'headers' => [
                    'Content-Type' => 'application/json'
                ],
                    'json' => $params
                ]
            );

            $response = $call->getBody()->getContents();

            //Save Payment Logs
            if($order_type == 'order'){
                $order_payment_logs = new OrderPaymentLogs();
                $order_payment_logs->add('create_session',$request->lead_order_id,$params,json_decode($response));
            }else{
                $order_payment_logs = new TopupPaymentLogs();
                $order_payment_logs->add($request->service_type,'create_session',$request->lead_order_id,$params,json_decode($response));
            }


            return json_decode($response);


        } catch ( BadResponseException $e ) {
            //$response = json_decode($e->getResponse()->getBody()->getContents());
            $response = $e->getResponse()->getBody()->getContents();
            $response = strip_tags($response, "<p>");
            throw new \Exception($response);
        } catch ( \Exception $e ) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function getPaymentStatus($request,$order_type = 'order')
    {
        $request = is_array($request) ? (object) $request : $request;

        try{

            $url = config('service.MASTER_CARD.url').config('service.MASTER_CARD.merchant_id')."/order/".$request->order_id;

           $call = $this->_client->get($url,[
               'auth' => [config('service.MASTER_CARD.username'), config('service.MASTER_CARD.password')], /*if you don't need to use a password, just leave it null*/
               'headers' => [
                   'Content-Type' => 'application/json'
               ]]);
            $response = $call->getBody()->getContents();

            //Save Payment Logs
            if($order_type == 'order'){
                $order_payment_logs = new OrderPaymentLogs();
                $order_payment_logs->add('payment_status',$request->order_id,['order_id'=>$request->order_id],json_decode($response));

            }else{
                $order_payment_logs = new TopupPaymentLogs();
                $order_payment_logs->add($request->service_type,'payment_status',$request->order_id,['order_id'=>$request->order_id],json_decode($response));
            }


            return json_decode($response);

        } catch ( BadResponseException $e ) {
            //$response = json_decode($e->getResponse()->getBody()->getContents());
            $response = $e->getResponse()->getBody()->getContents();
            $response = strip_tags($response, "<p>");
            throw new \Exception($response);
        } catch ( \Exception $e ) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createPayment($request,$order_type = 'order')
    {
        // init params
        $request = is_array($request) ? (object) $request : $request;
        // echo '<pre>'; print_r($request); exit;
        try {

            $params = [
                "apiOperation" => "PAY",
                "session" =>[
                  "id" => $request->session_id
                ],
                "order" => [
                    "currency" => config('service.MASTER_CARD.currency'),
                    "amount" =>  $request->amount
                ],
                "sourceOfFunds" => [
                    "type" => "CARD"
                ],
                "transaction" => [
                    "source" => "INTERNET",
                    "frequency" => "SINGLE"
                ],
                "3DSecureId" => "dceae03d"
            ];

            $call = $this->_client->put(
                config('service.MASTER_CARD.mobile_gateway_url')."?order=$request->lead_order_id&transaction=$request->lead_order_id",
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $params
                ]
            );

            $response = $call->getBody()->getContents();

            //Save Payment Logs
            if($order_type == 'order'){
                $order_payment_logs = new OrderPaymentLogs();
                $order_payment_logs->add('pay',$request->lead_order_id,$params,json_decode($response));
            } else{
                $order_payment_logs = new TopupPaymentLogs();
                $order_payment_logs->add($request->service_type,'pay',$request->lead_order_id,$params,json_decode($response));
            }

            return json_decode($response);


        } catch ( BadResponseException $e ) {
            //$response = json_decode($e->getResponse()->getBody()->getContents());
            $response = $e->getResponse()->getBody()->getContents();
            $response = strip_tags($response, "<p>");
            throw new \Exception($response);
        } catch ( \Exception $e ) {
            throw new \Exception($e->getMessage());
        }
    }


}