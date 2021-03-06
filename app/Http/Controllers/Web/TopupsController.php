<?php

namespace App\Http\Controllers\Web;

use App\Libraries\Custom\TopupLib;
use App\Libraries\GeneralSetting;
use App\Libraries\System\Entity;

use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;

Class TopupsController extends WebController
{
    /**
     * Global Private variable of this file.It has object of Entity Library
     *
     * @access private
     * @var Object
     */
    private $_object_library_entity;

    private $_apiData = array();
    private $_object_helper_customer;


    /**
     * Sets the $_customer_wallet with wallet Transaction Helper object and
     * Sets the $_object_library_entity with Entity Library object
     *
     * @internal param the $Sets $__customer_wallet with wallet Transaction Helper object.
     * @access public
     */

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->_object_library_entity = new Entity();
        $this->_object_helper_customer = new GeneralSetting();
        $this->currency_conversion = $this->_object_helper_customer->getConversionRate();

    }

    public function du(Request $request)
    {
        $data = [];
        $data['currency_conversion'] = $this->currency_conversion;
        return View::make('web/includes/topup/du',$data);

    }

    public function etisalat(Request $request)
    {
        $data = [];
        $data['currency_conversion'] = $this->currency_conversion;
        return View::make('web/includes/topup/etisalat',$data);
    }

    public function flyDubai(Request $request)
    {
        $data = [];
        $data['currency_conversion'] = $this->currency_conversion;
        return View::make('web/includes/topup/fly_dubai',$data);
    }

    public function addc(Request $request)
    {
        $data = [];
        $data['currency_conversion'] = $this->currency_conversion;
        return View::make('web/includes/topup/addc',$data);
    }

    /**
     * @param Request $request
     */
    public function sendTopup(Request $request)
    {
        try {
            // assign to output

            //process Payment

            //Send Topup
            $params = $request->all();
            $params['customer_no'] = "+971589802894";
           // $params['customer_no'] = "+".$request->customer_no;

            $params['reference_id'] = ($params['source'] == 'web') ? $request->getClientIp(true) : '';
           // echo "<pre>"; print_r($params); exit;

            $topup_lib = new TopupLib();
            $return =  $topup_lib->mobileTopup($params);
           // echo "<pre>"; print_r($return); exit;
            if(isset($return['data'])){
                $this->_apiData['data'] = $return['data'];
            }
            if(isset($return['response'])){
                $this->_apiData['response'] = $return['response'];
            }

            if(isset($return['error'])){
                $this->_apiData['error'] = $return['error'];
            }

            // message
            $this->_apiData['message'] = $return['message'];

        } catch ( \Exception $e ) {
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }
    public function sendServiceTopup(Request $request)
    {
        try {
            // assign to output

            //process Payment

            //Send Topup
            $params = $request->all();
            $params['reference_id'] = ($params['source'] == 'web') ? $request->getClientIp(true) : '';

            $topup_lib = new TopupLib();
            $return =  $topup_lib->serviceTopup($params);
            // echo "<pre>"; print_r($return); exit;
            if(isset($return['data'])){
                $this->_apiData['data'] = $return['data'];
            }
            if(isset($return['response'])){
                $this->_apiData['response'] = $return['response'];
            }

            $this->_apiData['error'] = $return['error'];

            // message
            $this->_apiData['message'] = $return['message'];

        } catch ( \Exception $e ) {
            $this->_apiData['message'] = $e->getMessage();
            $this->_apiData['trace'] = $e->getTraceAsString();
        }

        return $this->_apiData;

    }

    public function checkout(Request $request)
    {
        $data = [];
        return View::make('web/includes/topup/checkout',$data);
    }


}