<?php
/**
 * Created by PhpStorm.
 * User: Samreen Quyyum
 * Date: 08/02/2019
 * Time: 2:10 PM
 */
namespace App\Libraries\Custom;

use App\Libraries\EntityHelper;
use App\Libraries\System\Entity;

Class OrderLib
{

    private $_assignData = array();


    public function placeOrder($request)
    {

        try{
            //Validate Order
            $validate = $this->validateEntity($request);
            if($validate['error'] == 1){
                return $validate;
            }

            //Create Lead Order
            $lead_order = $this->createLead($request);
            if($lead_order->error == 1){
                return $lead_order;
            }

            $lead_order_id = $lead_order->data->entity->entity_id;

            //Payment
            $payment_request = $request['payment'];
            $payment_request['lead_order_id'] = $lead_order_id;

            $payment_response = $this->payment($payment_request);
            echo '<pre>'; print_r($payment_response); exit;

            if($payment_response['error'] == 1){
                return $payment_response;
            }

            //Create Order
            return $this->saveOrder($lead_order);

        }
        catch ( \Exception $e ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] =  $e->getMessage();
            throw new \Exception($e->getMessage());
        }

        return $this->_assignData;
    }

    public function validateEntity($request)
    {
        $depend_params = $request['depend_entity'];
        unset($request['depend_entity']);

        $entity_helper = new EntityHelper();
        //Validate Order
        $entity_validate = $entity_helper->validateEntity($request);
        if($entity_validate['error'] == 1){
            $assignData['error'] = 1;
            $assignData['message'] = $entity_validate['message'];
            return $assignData;
        }
        else{
            //Validate Order Items
            if(count($depend_params) > 0){

                foreach($depend_params as $depend_param){

                    $entity_depend_validate = $entity_helper->validateEntity($depend_param);
                    if($entity_depend_validate['error'] == 1){
                        $assignData['error'] = 1;
                        $assignData['message'] = $entity_depend_validate['message'];
                        return $assignData;
                    }
                }
            }
        }
        return array('error'=> 0, 'message' => 'success');
    }

    /**
     * @param $request
     * @return array|mixed
     */
    public function createLead($request)
    {
        $params = array(
            'entity_type_id' => 'lead_order',
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

    public function payment($payment_request)
    {
        try{
            $payment_lib = new PaymentLib();
            $payment_response = $payment_lib->createPayment($payment_request,'order');

        }
        catch ( \Exception $ee ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] .=  $ee->getMessage();
            // throw new \Exception($e->getMessage());
        }

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

        return $payment_response;
    }

    public function saveOrder($lead_order)
    {
        try {
            //Create Order
            $params = json_decode($lead_order->data->entity->attributes->order_detail, true);
            $params['entity_type_id'] = 'order';
            $params['mobile_json'] = 1;
            $params['hook'] = 'order_item';

            $entity_lib = new Entity();
            return $entity_lib->apiPost($params);

        }
        catch ( \Exception $ee ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] .=  $ee->getMessage();
            // throw new \Exception($e->getMessage());
        }

    }


}