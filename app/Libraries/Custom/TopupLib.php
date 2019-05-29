<?php
/**
 * Created by PhpStorm.
 * User: Samreen Quyyum
 * Date: 5/29/2019
 * Time: 2:10 PM
 */
namespace App\Libraries\Custom;

use App\Libraries\Services\Topup;
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
            $this->_apiData['message'] = $validation->errors()->first();
        } else {

            try {

                // load library
                $simbox_lib = new Topup('simbox');
                $one_prepay_lib = new Topup('one_prepay');

                // init vars
                $params = $request->all();
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
                                throw new \Exception($e->getMessage());
                            }
                        } else
                            throw new \Exception($e->getMessage());

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
                        throw new \Exception($e->getMessage());
                    }

                }


                // assign to output
                $this->_apiData['data'] = $response;
                $this->_apiData['response'] = "success";
                $this->_apiData['error'] = 0;

                // message
                $this->_apiData['message'] = trans('system.success');


            } catch ( \Exception $e ) {
                $this->_apiData['message'] = $e->getMessage();
                $this->_apiData['trace'] = $e->getTraceAsString();
            }

        }


        return $this->_apiData;
    }



}