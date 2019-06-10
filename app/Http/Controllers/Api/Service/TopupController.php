<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Libraries\Services\Topup;
use App\Libraries\System\Entity;
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
		$this->_apiData['error'] = 1;
		
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
			// assign to output
			$this->_apiData['data'] = $this->_pLib->balance();
			
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
	 * Send
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
	 * Products
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function products(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->products($request->all());
			
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
	 * Check
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function check(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->check($request->all());
			
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
	 * Send Verified
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function sendVerified(Request $request)
	{
		
		try {
			// assign to output
			$this->_apiData['data'] = $this->_pLib->sendVerified($request->all());
			
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
	 * Mobile Topup
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function mobileTopup(Request $request)
	{
		// validation
		$validation = validator($request->all(), [
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
                $topup_response = $entity_lib->apiPost($arr);
                $topup_response = json_decode(json_encode($topup_response));

                //  echo "<pre>"; print_r($inventory_response);
                if (isset($topup_response->data->entity->entity_id)) {
                    $param = array(
                        'entity_type_id' => 'topup',
                        'entity_id' => $topup_response->data->entity->entity_id,
                        'topup_no' => 'T'.$topup_response->data->entity->entity_id,
                    );

                    $entity_lib->apiUpdate($param);
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
	
	
	/**
	 * Service Check
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function serviceCheck(Request $request)
	{
		// validation
		$validation = validator($request->all(), [
			'service_type' => 'required|in:fly_dubai,addc',
			'customer_no' => 'required|string|min:5'
		]);
		
		if ( $validation->fails() ) {
			$this->_apiData['message'] = $validation->errors()->first();
		} else {
			
			try {
				
				// load library
				$one_prepay_lib = new Topup('one_prepay');
				
				// init vars
				$params = $request->all();
				$response = NULL;
				
				// get product denomination (product code for one_prepay)
				$products = $one_prepay_lib->products([
					'brand' => $params['service_type']
				]);
				$denomination = $products['denominations'][0]['denomination_id'];
				
				try {
					// send
					$response = $one_prepay_lib->check([
						'account_no' => $params['customer_no'],
						'amount' => 0,
						'denomination_id' => $denomination
					]);
					
				} catch ( \Exception $e ) {
					// if load credit, let it continue to other API
					throw new \Exception($e->getMessage());
				}
				
				// merge params
				if ( $params['service_type'] == 'addc' ) {
					$response = array_merge($response, [
						'amount' => $response['AdditionalInfo']['Item'][0],
						'customer_name' => $response['AdditionalInfo']['Item'][1],
						'info' => $response['ReceiptInfo']['QueryRes'],
					]);
				} else {
					$response = array_merge($response, [
						'amount' => $response['AdditionalInfo']['Item'][3],
						'customer_name' => $response['AdditionalInfo']['Item'][0],
						'info' => $response['ReceiptInfo']['QueryRes'],
					]);
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
	
	
	/**
	 * Service Topup
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function serviceTopup(Request $request)
	{
		// validation
		$validation = validator($request->all(), [
			'service_type' => 'required|in:fly_dubai,addc',
			'customer_no' => 'required|string|min:5',
			'amount' => 'required|numeric|min:1',
			'request_key' => 'required|string|min:5',
		]);
		
		if ( $validation->fails() ) {
			$this->_apiData['message'] = $validation->errors()->first();
		} else {
			
			try {
				
				// load library
				$one_prepay_lib = new Topup('one_prepay');
				
				// init vars
				$params = $request->all();
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
					throw new \Exception($e->getMessage());
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
                $topup_response = $entity_lib->apiPost($arr);
                $topup_response = json_decode(json_encode($topup_response));

                //  echo "<pre>"; print_r($inventory_response);
                if (isset($topup_response->data->entity->entity_id)) {
                    $param = array(
                        'entity_type_id' => 'topup',
                        'entity_id' => $topup_response->data->entity->entity_id,
                        'topup_no' => 'T'.$topup_response->data->entity->entity_id,
                    );

                    $entity_lib->apiUpdate($param);
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