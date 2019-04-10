<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\Topup;


use App\Libraries\Curl;

/**
 * Class MintRoute
 *
 * @package App\Libraries\Services\Cards
 */
class Simbox
{
	
	/**
	 * Curl
	 *
	 * @var Curl
	 */
	private $_curl;
	
	/**
	 * MintRoute constructor.
	 */
	public function __construct()
	{
		$this->_curl = new Curl();
		
	}
	
	
	/**
	 * Balance
	 *
	 * @return \App\Libraries\Response|mixed
	 * @throws \Exception
	 */
	public function balance()
	{
		try {
			// params
			$params = [
				'port' => [ config('service.SIMBOX.port') ],
				'command' => 'send',
				'text' => '*139*102*'
					. config('service.SIMBOX.sim_id')
					. '*' . config('service.SIMBOX.pin_id') . '*2#',
			];
			
			// init request
			$this->_curl->create(config('service.SIMBOX.endpoint_url') . 'send_ussd');
			
			// login
			$this->_curl->httpLogin(
				config('service.SIMBOX.username'),
				config('service.SIMBOX.password')
			);
			
			// headers
			$this->_curl->httpHeader('Content-Type', 'application/json');
			
			// options
			$this->_curl->options([
				CURLOPT_POSTFIELDS => json_encode($params),
				CURLOPT_POST => 1
			]);
			
			// execute
			$this->_curl->execute();
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			else {
				// create delay
				sleep(4);
				
				// query
				$this->_curl->create(config('service.SIMBOX.endpoint_url')
					. 'query_ussd_reply?port=' . config('service.SIMBOX.port')
				);
				
				// login
				$this->_curl->httpLogin(
					config('service.SIMBOX.username'),
					config('service.SIMBOX.password')
				);
				
				// headers
				$this->_curl->httpHeader('Content-Type', 'application/json');
				
				
				$response = json_decode($this->_curl->execute());
				
				
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				preg_match('/([\d]+\.[\d]{2})/', $response->reply[0]->text, $matches);
				
				return [
					'balance' => isset($matches[1]) ? ceil($matches[1]) : 0
				];
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Send
	 *
	 * @param array $request
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function send(array $request)
	{
		// validation
		$validation = validator($request, [
			'account_no' => 'required|string|min:5',
			'amount' => 'required|numeric|min:5'
		]);
		
		if ( $validation->fails() )
			throw new \Exception($validation->errors()->first());
		
		
		try {
			// allowed filters
			$allowed_params = [
				'account_no' => NULL,
				'amount' => NULL
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			
			// params
			$params = [
				'port' => [ config('service.SIMBOX.port') ],
				'command' => 'send',
				'text' => '*139*100'
					. '*' . config('service.SIMBOX.sim_id')
					. '*' . config('service.SIMBOX.pin_id')
					. '*5'
					. '*' . $request['amount']
					. '*' . $request['account_no']
					. '*' . $request['account_no']
					. '#',
			];
			
			// init request
			$this->_curl->create(config('service.SIMBOX.endpoint_url') . 'send_ussd');
			
			// login
			$this->_curl->httpLogin(
				config('service.SIMBOX.username'),
				config('service.SIMBOX.password')
			);
			
			// headers
			$this->_curl->httpHeader('Content-Type', 'application/json');
			
			// options
			$this->_curl->options([
				CURLOPT_POSTFIELDS => json_encode($params),
				CURLOPT_POST => 1
			]);
			
			// execute
			$this->_curl->execute();
			
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			else {
				// create delay
				sleep(4);
				
				// query
				$this->_curl->create(config('service.SIMBOX.endpoint_url')
					. 'query_ussd_reply?port=' . config('service.SIMBOX.port')
				);
				
				// login
				$this->_curl->httpLogin(
					config('service.SIMBOX.username'),
					config('service.SIMBOX.password')
				);
				
				// headers
				$this->_curl->httpHeader('Content-Type', 'application/json');
				
				
				$response = json_decode($this->_curl->execute());
				
				
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				preg_match('/^(\(Error )/', $response->reply[0]->text, $matches);
				
				// if error
				if ( isset($matches[0]) )
					throw new \Exception($response->reply[0]->text);
				
				return [
					//'balance' => isset($matches[1]) ? ceil($matches[1]) : 0
				];
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
}