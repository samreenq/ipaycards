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
class OnePrepay
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
		// params
		$input_xml = '<RequestXml>
                <Type>GetBalanceSt</Type>
                <TerminalId>' . config('service.ONE_PREPAY.terminal_id') . '</TerminalId>
                <Password>' . config('service.ONE_PREPAY.password') . '</Password>
                <Language>eng</Language>
        </RequestXml>';
		
		// remove whitespaces between tags
		$input_xml = preg_replace('/\s+/', '', $input_xml);
		
		try {
			
			$this->_curl->create(
				config('service.ONE_PREPAY.endpoint_url')
				. '?RequestXml=' . $input_xml);
			
			$response = $this->_curl->execute();
			$response = json_decode(json_encode(
				simplexml_load_string($response)
			), TRUE);
			
			// if curl error
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			// if service error
			if ( intval($response['StatusCode']) > 0 )
				throw new \Exception($response['StatusDescription']);
			
			// parse through mapping
			$this->_responseMapping($response);
			
			return $response;
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Products
	 *
	 * @return \App\Libraries\Response|mixed
	 * @throws \Exception
	 */
	public function products()
	{
		// params
		$input_xml = '<RequestXml>
                <Type>FileDownload</Type>
                <TerminalId>' . config('service.ONE_PREPAY.terminal_id') . '</TerminalId>
                <Password>' . config('service.ONE_PREPAY.password') . '</Password>
                <Language>eng</Language>
        </RequestXml>';
		
		// remove whitespaces between tags
		$input_xml = preg_replace('/\s+/', '', $input_xml);
		
		try {
			
			$this->_curl->create(
				config('service.ONE_PREPAY.endpoint_url')
				. '?RequestXml=' . $input_xml);
			
			$response = $this->_curl->execute();
			$response = json_decode(json_encode(
				simplexml_load_string($response)
			), TRUE);
			
			// if curl error
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			// if service error
			if ( intval($response['StatusCode']) > 0 )
				throw new \Exception($response['StatusDescription']);
			
			// parse through mapping
			//$this->_responseMapping($response);
			
			return $response;
			
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
		map_keys(
			$response,
			[
				'Balance'    => 'balance',
				'MerchantId' => 'vendor_name'
			]
		);
	}
	
	
}