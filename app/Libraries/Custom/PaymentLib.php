<?php

namespace App\Libraries\Custom;
use GuzzleHttp\Client;

Class PaymentLib
{

    private $_apiData = array();


    /**
     * MintRoute constructor.
     */
    public function __construct()
    {
        $this->_client = new Client();

    }


    public function getSessionID($request)
    {
// init params
        $params = [];
        $request = is_array($request) ? (object) $request : $request;
        try {

            $call = $this->_client->post(
                "https://ap-gateway.mastercard.com/api/rest/version/51/merchant/TEST222204083001/session",
                [
                    'auth' => ['merchant.TEST222204083001', 'ffa4f48c03844c346cccede2eb790ca5'], /*if you don't need to use a password, just leave it null*/
                    'headers' => [
                    'Content-Type' => 'application/json'
                ],
                    'json' => [
                        "apiOperation" => "CREATE_CHECKOUT_SESSION",
                        "order" => [
                            "currency" => "USD",
                            "id" => $request->lead_order_id,
                            "amount" =>  $request->amount
                        ]

                    ]
                ]
            );

            $response = $call->getBody()->getContents();

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

    public function getPaymentStatus($request)
    {
        $request = is_array($request) ? (object) $request : $request;
        try{

            $url = "https://ap-gateway.mastercard.com/api/rest/version/50/merchant/TEST222204083001/order/".$request->order_id;

           $call = $this->_client->get($url,[
               'auth' => ['merchant.TEST222204083001', 'ffa4f48c03844c346cccede2eb790ca5'], /*if you don't need to use a password, just leave it null*/
               'headers' => [
                   'Content-Type' => 'application/json'
               ]]);
            $response = $call->getBody()->getContents();

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