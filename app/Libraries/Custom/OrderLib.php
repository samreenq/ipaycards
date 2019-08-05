<?php
/**
 * Created by PhpStorm.
 * User: Samreen Quyyum
 * Date: 08/02/2019
 * Time: 2:10 PM
 */
namespace App\Libraries\Custom;

use App\Http\Models\SYSTableFlat;
use App\Libraries\EntityHelper;
use App\Libraries\System\Entity;

/**
 * Class OrderLib
 * @package App\Libraries\Custom
 */
Class OrderLib
{

    private $_assignData = array();

    /**
     * @param $request
     * @return array|mixed
     * @throws \Exception
     */

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

            $payment_response = $this->payment($payment_request,'order');
            $payment_response = (object)($payment_response);

        //  $payment_response = json_decode(json_encode($payment_response));
          //echo '<pre>'; print_r($payment_response); exit;

            if(isset($payment_response->error)){
                return $payment_response;
            }
            //Create Order
            return $this->saveOrder($lead_order,$payment_response);

        }
        catch ( \Exception $e ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] =  $e->getMessage();
           // throw new \Exception($e->getMessage());
        }

        return $this->_assignData;
    }

    /**
     * @param $request
     * @return array
     */
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

    /**
     * @param $payment_request
     * @return array|mixed
     */
    public function payment($payment_request,$type)
    {
        try{
            $payment_lib = new PaymentLib();
           $payment_response = $payment_lib->createPayment($payment_request,$type);
          // $payment_response = '{"apiVersion":"49","gatewayResponse":{"3DSecure":{"acsEci":"05","authenticationToken":"gIGCg4SFhoeIiYqLjI2Oj5CRkpM=","paResStatus":"Y","veResEnrolled":"Y","xid":"8a+tihv2OFyFMDsqSEoP3nrmQxA="},"3DSecureId":"dceae03d","authorizationResponse":{"cardLevelIndicator":"88","commercialCard":"888","commercialCardIndicator":"3","marketSpecificData":"8","posData":"1025100006600","posEntryMode":"812","processingCode":"003000","responseCode":"00","returnAci":"8","stan":"62302","transactionIdentifier":"123456789012345","validationCode":"6789"},"gatewayEntryPoint":"WEB_SERVICES_API","merchant":"TEST222204083001","order":{"amount":10,"chargeback":{"amount":0,"currency":"USD"},"creationTime":"2019-08-03T10:36:08.390Z","currency":"USD","fundingStatus":"NOT_SUPPORTED","id":"8717","merchantCategoryCode":"7399","status":"CAPTURED","totalAuthorizedAmount":10,"totalCapturedAmount":10,"totalRefundedAmount":0},"response":{"acquirerCode":"00","acquirerMessage":"Approved","gatewayCode":"APPROVED"},"result":"SUCCESS","sourceOfFunds":{"provided":{"card":{"brand":"VISA","expiry":{"month":"5","year":"21"},"fundingMethod":"CREDIT","nameOnCard":"Joseph","number":"424242xxxxxx4242","scheme":"VISA","storedOnFile":"NOT_STORED"}},"type":"CARD"},"timeOfRecord":"2019-08-03T10:36:08.390Z","transaction":{"acquirer":{"batch":20190803,"date":"0803","id":"BOAS_S2I","merchantId":"222204083001","settlementDate":"2019-08-03","timeZone":"+0200","transactionId":"123456789012345"},"amount":10,"authorizationCode":"062302","currency":"USD","frequency":"SINGLE","funding":{"status":"NOT_SUPPORTED"},"id":"8717","receipt":"921510062302","source":"INTERNET","terminal":"AUDS2I05","type":"PAYMENT"},"version":"49"}}';
            $payment_response = json_decode(json_encode($payment_response));
            //$payment_response = json_decode($payment_response);
            if(isset($payment_response->gatewayResponse->error)){
                $return = array(
                    'error' => 1,
                    'message' => isset($payment_response->gatewayResponse->error->explanation) ?
                        $payment_response->gatewayResponse->error->explanation
                        : "Unable to get response, Please contact to support team"
                );

                return $return;
            }


            return $payment_response;
        }
        catch ( \Exception $ee ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] =  $ee->getMessage();
            // throw new \Exception($e->getMessage());
            return  $this->_assignData;
        }


    }

    /**
     * @param $lead_order
     * @param $payment_response
     * @return array
     */
    public function saveOrder($lead_order,$payment_response)
    {
        try {

            //Get Order Status
            $flat_table = new SYSTableFlat('order_statuses');
            $order_status_raw = $flat_table->getColumnByWhere(' keyword = "payment_received"','entity_id');
            $order_status = $order_status_raw->entity_id;

            //Create Order
            $lead_order_id = $lead_order->data->entity->entity_id;
            $params = json_decode($lead_order->data->entity->attributes->order_detail, true);
            $params['entity_type_id'] = 'order';
            $params['mobile_json'] = 1;
            $params['hook'] = 'order_item';


            $card = $payment_response->gatewayResponse->sourceOfFunds->provided->card;
           //
            // $data['transaction_response'] = json_encode($payment_response);
            $params['card_id'] = $card->nameOnCard;
            $params['card_type'] = $card->scheme;
            $params['card_last_digit'] = substr($card->number,-4);
            $params['transaction_id'] = $payment_response->gatewayResponse->transaction->id;
            $params['lead_order_id'] = "$lead_order_id";
            $params['order_status'] = $order_status;

            unset($params['payment']);
           // echo '<pre>'; print_r($params); exit;
            $entity_lib = new Entity();
            return $entity_lib->apiPost($params);

        }
        catch ( \Exception $ee ) {
            $this->_assignData['error'] = 1;
            $this->_assignData['message'] =  $ee->getMessage();
            $this->_assignData['trace'] = $ee->getTraceAsString();
            // throw new \Exception($e->getMessage());
        }

        return $this->_assignData;

    }


}