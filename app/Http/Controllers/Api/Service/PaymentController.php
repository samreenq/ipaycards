<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Libraries\Services\Payment;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
	
	/**
	 * Api data
	 *
	 * @var array
	 */
	private $_apiData = [];
	
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
		
		// lib
		try {
			$this->_pLib = new Payment(request('vendor', 'stripe'));
			
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
	public function balance(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->balance();
			
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
	
	/**
	 * Post Customer
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function postCustomer(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->postCustomer($request->all());
			
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
	
	/**
	 * Post Card Token
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function postCardToken(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->postCardToken($request->all());
			
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
	
	/**
	 * Post Bank Token
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function postBankToken(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->postBankToken($request->all());
			
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			
		} catch ( \Exception $e ) {
			$this->_apiData['message'] = $e->getMessage();
			$this->_apiData['trace'] = $e->getTraceAsString();
		}
		
		return $this->_apiData;
	}
	
}