<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Libraries\Custom\PaymentLib;
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

    public function getPaymentStatus(Request $request)
    {

    }


}