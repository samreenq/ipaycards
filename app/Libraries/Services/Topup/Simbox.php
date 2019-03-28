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
			
			$params = [
				'port'    => config('service.SIMBOX_PREPAY.port'),
				'command' => 'send',
				/*'text' => '*139*102*'
					. config('service.SIMBOX_PREPAY.sim_id')
					. '*' . config('service.SIMBOX_PREPAY.pin_id') . '*2#',*/
				'text'    => '*125#',
			];
			
			$this->_curl->post($params);
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = $this->_curl->execute();
			
			var_dump($response);
			exit;
			
			return json_decode($response);
			
			
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