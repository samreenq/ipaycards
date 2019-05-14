<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\OTP;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class MintRoute
 *
 * @package App\Libraries\Services\Cards
 */
class Authy
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
		$this->_client = new Client();
		
	}
	
	
	/**
	 * Send
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function send(array $request = NULL)
	{
		// validation
		$validation = validator($request, [
			'country_code' => 'required|min:1|max:3',
			'phone_number' => 'required|string|min:7|max:11',
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			try {
				// allowed filters
				$allowed_params = [
					'country_code' => NULL,
					'phone_number' => NULL,
					'via' => NULL,
					'locale' => NULL
				];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				// add default values
				$params = array_merge($params, [
					'via' => check_val($params['via'], 'sms'),
					'locale' => check_val($params['locale'], 'en')
				]);
				
				
				$call = $this->_client->post(
					config('service.AUTHY.endpoint_url')
					. 'phones/verification/start',
					[ 'headers' => [
						'X-Authy-API-Key' => config('service.AUTHY.api_key')
					],
						'form_params' => $params
					]
				);
				
				$response = $call->getBody()->getContents();
				
				return json_decode($response);
				
				
			} catch ( BadResponseException $e ) {
				$response = json_decode($e->getResponse()->getBody()->getContents());
				throw new \Exception($response->message);
			} catch ( \Exception $e ) {
				
				throw new \Exception($e->getMessage());
			}
			
		}
	}
	
	
	/**
	 * Send Verified
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function verify(array $request = NULL)
	{
		// validation
		$validation = validator($request, [
			'country_code' => 'required|min:1|max:3',
			'phone_number' => 'required|string|min:7|max:11',
			'verification_code' => 'required|string|min:4|max:12',
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			try {
				// allowed filters
				$allowed_params = [
					'country_code' => NULL,
					'phone_number' => NULL,
					'verification_code' => NULL
				];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				
				$call = $this->_client->get(
					config('service.AUTHY.endpoint_url')
					. 'phones/verification/check',
					[ 'headers' => [
						'X-Authy-API-Key' => config('service.AUTHY.api_key')
					],
						'query' => $params
					]
				);
				
				$response = $call->getBody()->getContents();
				
				return json_decode($response);
				
				
			} catch ( BadResponseException $e ) {
				$response = json_decode($e->getResponse()->getBody()->getContents());
				throw new \Exception($response->message);
			} catch ( \Exception $e ) {
				
				throw new \Exception($e->getMessage());
			}
			
		}
	}
	
	
}