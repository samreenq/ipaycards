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
			// init request
			$this->_curl->create(
				config('service.SIMBOX_PREPAY.endpoint_url')
				. 'send_ussd'
			);
			
			// basic auth
			$this->_curl->httpLogin(
				config('service.SIMBOX_PREPAY.username'),
				config('service.SIMBOX_PREPAY.password')
			);
			
			// params
			$params = [
				'port'    => "[" . config('service.SIMBOX_PREPAY.port') . "]",
				'command' => 'send',
				'text'    => '*139*102*'
					. config('service.SIMBOX_PREPAY.sim_id')
					. '*' . config('service.SIMBOX_PREPAY.pin_id') . '*2#',
			];
			
			// send ssd
			$this->_curl->post($params);
			
			// query
			$this->_curl->create(config('service.SIMBOX_PREPAY.endpoint_url')
				. 'query_ussd_reply?port=' . config('service.SIMBOX_PREPAY.port')
			);
			
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = json_decode($this->_curl->execute());
			
			preg_match('/([\d]+\.[\d]{2})/', $response->reply[0]->text, $matches);
			
			
			return [
				'balance' => ceil($matches[1])
			];
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Response Key Mapping
	 *
	 * @param array $response
	 */
	private function _responseMapping(array &$response = [])
	{
		// map keys
		/*map_keys(
			$response,
			[
				'Balance'    => 'available_balance',
				'MerchantId' => 'vendor_name'
			]
		);*/
	}
	
	
}