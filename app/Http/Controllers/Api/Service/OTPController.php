<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Libraries\Services\OTP;
use Illuminate\Http\Request;


class OTPController extends Controller
{
	
	private $_apiData = array();
	
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		parent::__construct($request);
		
		
		// error response by default
		$this->_apiData['kick_user'] = 0;
		$this->_apiData['response'] = "error";
		$this->_apiData['error'] = 1;
		
		// lib
		try {
			$this->_pLib = new OTP(request('vendor', 'authy'));
			
		} catch ( \Exception $e ) {
			//throw new Exception($e->getMessage());
			$this->_apiData['message'] = $e->getMessage();
			return $this->_apiData;
		}
	}
	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return array
	 */
	public function index()
	{
		echo "test";
		
	}
	
	
	/**
	 * Get Balance
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function send(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->send($request->all());
			
			$this->_apiData['response'] = "success";
			$this->_apiData['error'] = 0;
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
	
	/**
	 * Verify
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function verify(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->verify($request->all());
			
			$this->_apiData['response'] = "success";
			$this->_apiData['error'] = 0;
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
}