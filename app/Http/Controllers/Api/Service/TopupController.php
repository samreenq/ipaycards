<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Libraries\Services\Topup;
use Illuminate\Http\Request;


class TopupController extends Controller
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
		
		// lib
		try {
			$this->_pLib = new Topup(request('vendor', 'one_prepay'));
			
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
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			// assign to output
			$this->_apiData['data'] = $this->_pLib->balance();
			
		} catch ( \Exception $e ) {
			$this->_apiData['trace'] = $e->getTraceAsString();
			$this->_apiData['message'] = $e->getMessage();
		}
		
		return $this->_apiData;
	}
	
	
	/**
	 * Send
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function send(Request $request)
	{
		
		try {
			// success response
			$this->_apiData['response'] = "success";
			
			// message
			$this->_apiData['message'] = trans('system.success');
			
			// assign to output
			$this->_apiData['data'] = $this->_pLib->send($request->all());
			
		} catch ( \Exception $e ) {
			$this->_apiData['trace'] = $e->getTraceAsString();
			$this->_apiData['message'] = $e->getMessage();
		}
		
		return $this->_apiData;
	}
	
	
}