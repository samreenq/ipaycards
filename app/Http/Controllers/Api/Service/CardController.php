<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Libraries\Services\Cards;
use Illuminate\Http\Request;


class CardController extends Controller
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
			
			$this->_pLib = new Cards(request('vendor', 'mint_route'));
			
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
	 * Categories
	 *
	 * @return array
	 */
	public function categories(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->categories();
			
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
	 * Orders
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function brands(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->brands($request->all());
			
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
	 * Orders
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function denominations(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->denominations($request->all());
			
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
	 * Orders
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
	 * Orders
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function orders(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->orders($request->all())->data;
			
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
	 * Check Availability
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function checkAvailability(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->checkAvailability($request->all());
			
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
	 * Reserve
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function reserve(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->reserve($request->all());
			
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
	 * Purchase
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function purchase(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->purchase($request->all());
			
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
	 * Get Order
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function getOrder(Request $request)
	{
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->getOrder($request->all());
			
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