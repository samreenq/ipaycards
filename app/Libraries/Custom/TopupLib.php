<?php
/**
 * Created by PhpStorm.
 * User: Samreen Quyyum
 * Date: 5/29/2019
 * Time: 2:10 PM
 */
namespace App\Libraries\Custom;

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

                // get product denomination (product code for one_prepay)
                $products = $one_prepay_lib->products([
                    'brand' => $params['service_type']
                ]);
                $denomination = $products['denominations'][0]['denomination_id'];

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


                //Save Topup History
                $arr = array(
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

              //  echo "<pre>"; print_r($arr);
                $entity_lib = new Entity();
                $resp = $entity_lib->apiPost($arr);
               // echo "<pre>"; print_r($resp);

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
                $arr = array(
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
                $entity_lib->apiPost($arr);

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



}