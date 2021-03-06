<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\Cards;


use App\Libraries\Curl;
use App\Libraries\Services\Cards\MintRoute\AesCtr;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class MintRoute
 *
 * @package App\Libraries\Services\Cards
 */
class MintRoute
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
		$this->_client = new Client();
		
	}
	
	/**
	 * Categories
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function xcategories()
	{
		try {
			// init request
			$this->_curl->create(
				config('service.MINT_ROUTE.endpoint_url')
				. 'category'
			);
			
			$params = json_encode([
				'username' => config('service.MINT_ROUTE.username'),
				'password' => config('service.MINT_ROUTE.password'),
			]);
			
			$this->_curl->post([
				'token' => config('service.MINT_ROUTE.pub_key'),
				'postedinfo' => AesCtr::encrypt(
					$params,
					config('service.MINT_ROUTE.pvt_key'),
					config('service.MINT_ROUTE.enc_bits')
				)
			]);
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = $this->_curl->execute();
			
			return json_decode($response);
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Categories
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function categories()
	{
		// init params
		$params = [];
		
		// collect params
		$params = json_encode([
			'username' => config('service.MINT_ROUTE.username'),
			'password' => config('service.MINT_ROUTE.password'),
			'data' => count($params) > 0 ? [ $params ] : []
		]);
		
		
		try {
			
			$call = $this->_client->post(
				config('service.MINT_ROUTE.endpoint_url')
				. 'category',
				[ 'headers' => [
					'Content-Type' => 'application/json'
				],
					'form_params' => [
						'token' => config('service.MINT_ROUTE.pub_key'),
						'postedinfo' => AesCtr::encrypt(
							$params,
							config('service.MINT_ROUTE.pvt_key'),
							config('service.MINT_ROUTE.enc_bits')
						)
					]
				]
			);
			
			$response = $call->getBody()->getContents();
			
			return json_decode($response);
			
			
		} catch ( BadResponseException $e ) {
			//$response = json_decode($e->getResponse()->getBody()->getContents());
			$response = $e->getResponse()->getBody()->getContents();
			$response = strip_tags($response, "<p>");
			throw new \Exception($response);
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
		
		
	}
	
	
	/**
	 * Brands
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function brands(array $request = NULL)
	{
		try {
			// init requdenominationsest
			$this->_curl->create(
				config('service.MINT_ROUTE.endpoint_url')
				. 'brand'
			);
			
			// allowed filters
			$allowed_params = [ 'category_id' => NULL ];
			// find intersecting keys
			$params = array_intersect_key($request, $allowed_params);
			
			// collect params
			$params = json_encode([
				'username' => config('service.MINT_ROUTE.username'),
				'password' => config('service.MINT_ROUTE.password'),
				'data' => count($params) > 0 ? [ $params ] : []
			]);
			
			
			$this->_curl->post([
				'token' => config('service.MINT_ROUTE.pub_key'),
				'postedinfo' => AesCtr::encrypt(
					$params,
					config('service.MINT_ROUTE.pvt_key'),
					config('service.MINT_ROUTE.enc_bits')
				)
			]);
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = $this->_curl->execute();
			
			return json_decode($response)->{$request['category_id']};
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Denominations
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function denominations(array $request = NULL)
	{
		try {
			// validation
			$validation = validator($request, [
				'brand_id' => 'required'
			]);
			
			if ( $validation->fails() ) {
				throw new \Exception($validation->errors()->first());
			} else {
				
				// init request
				$this->_curl->create(
					config('service.MINT_ROUTE.endpoint_url')
					. 'denomination'
				);
				
				// allowed filters
				$allowed_params = [ 'brand_id' => NULL ];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				// collect params
				$params = json_encode([
					'username' => config('service.MINT_ROUTE.username'),
					'password' => config('service.MINT_ROUTE.password'),
					'data' => count($params) > 0 ? [ $params ] : []
				]);
				
				
				$this->_curl->post([
					'token' => config('service.MINT_ROUTE.pub_key'),
					'postedinfo' => AesCtr::encrypt(
						$params,
						config('service.MINT_ROUTE.pvt_key'),
						config('service.MINT_ROUTE.enc_bits')
					)
				]);
				
				// if error
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				$response = json_decode($this->_curl->execute(), TRUE);
				$key = array_key_first($response);
				
				return $response[ $key ][ $request['brand_id'] ];
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Balance
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function balance(array $request = NULL)
	{
		try {
			// init request
			$this->_curl->create(
				config('service.MINT_ROUTE.endpoint_url')
				. 'get_current_balance'
			);
			
			$params = json_encode([
				'username' => config('service.MINT_ROUTE.username'),
				'password' => config('service.MINT_ROUTE.password'),
			]);
			
			$this->_curl->post([
				'token' => config('service.MINT_ROUTE.pub_key'),
				'postedinfo' => AesCtr::encrypt(
					$params,
					config('service.MINT_ROUTE.pvt_key'),
					config('service.MINT_ROUTE.enc_bits')
				)
			]);
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = $this->_curl->execute();
			
			return json_decode($response);
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Orders
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function orders(array $request = NULL)
	{
		try {
			// init requdenominationsest
			$this->_curl->create(
				config('service.MINT_ROUTE.endpoint_url')
				. 'get_all_orders'
			);
			
			// allowed filters
			$allowed_params = [ 'category_id' => NULL ];
			// find intersecting keys
			$params = array_intersect_key($request, $allowed_params);
			
			// collect params
			$params = json_encode([
				'username' => config('service.MINT_ROUTE.username'),
				'password' => config('service.MINT_ROUTE.password'),
				'data' => count($params) > 0 ? [ $params ] : []
			]);
			
			
			$this->_curl->post([
				'token' => config('service.MINT_ROUTE.pub_key'),
				'postedinfo' => AesCtr::encrypt(
					$params,
					config('service.MINT_ROUTE.pvt_key'),
					config('service.MINT_ROUTE.enc_bits')
				)
			]);
			
			if ( $this->_curl->error_code )
				throw new \Exception($this->_curl->error_string);
			
			$response = $this->_curl->execute();
			
			return json_decode($response);
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Check Availability
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function checkAvailability(array $request = NULL)
	{
		try {
			// validation
			$validation = validator($request, [
				'denomination_id' => 'required'
			]);
			
			if ( $validation->fails() ) {
				throw new \Exception($validation->errors()->first());
			} else {
				
				// init request
				$this->_curl->create(
					config('service.MINT_ROUTE.endpoint_url')
					. 'stock'
				);
				
				// allowed filters
				$allowed_params = [ 'denomination_id' => NULL ];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				// collect params
				$params = json_encode([
					'username' => config('service.MINT_ROUTE.username'),
					'password' => config('service.MINT_ROUTE.password'),
					'data' => count($params) > 0 ? [ $params ] : []
				]);
				
				
				$this->_curl->post([
					'token' => config('service.MINT_ROUTE.pub_key'),
					'postedinfo' => AesCtr::encrypt(
						$params,
						config('service.MINT_ROUTE.pvt_key'),
						config('service.MINT_ROUTE.enc_bits')
					)
				]);
				
				// if error
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				$response = $this->_curl->execute();
				
				return json_decode($response);
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Reserve
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function reserve(array $request = NULL)
	{
		
		// validation
		$validation = validator($request, [
			'denomination_id' => 'required',
			//'quantity' => 'required|integer',
			'orderid' => 'required|string'
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			// init request
			/*$this->_curl->create(
				config('service.MINT_ROUTE.endpoint_url')
				. 'voucher'
			);*/
			
			// allowed filters
			$allowed_params = [
				'denomination_id' => NULL,
				//'quantity' => NULL,
				'orderid' => NULL
			];
			// find intersecting keys
			$params = array_intersect_key($request, $allowed_params);
			
			// add default values
			$params = array_merge($params, [
				'reserve' => TRUE,
				'short' => TRUE,
				'location' => config('service.MINT_ROUTE.pos_identification'),
				'quantity' => 1
			]);
			
			// collect params
			$params = json_encode([
				'username' => config('service.MINT_ROUTE.username'),
				'password' => config('service.MINT_ROUTE.password'),
				'data' => count($params) > 0 ? [ $params ] : []
			]);
			
			
			try {
				
				$call = $this->_client->post(
					config('service.MINT_ROUTE.endpoint_url')
					. 'voucher',
					[ 'headers' => [
						'Content-Type' => 'application/json'
					],
						'form_params' => [
							'token' => config('service.MINT_ROUTE.pub_key'),
							'postedinfo' => AesCtr::encrypt(
								$params,
								config('service.MINT_ROUTE.pvt_key'),
								config('service.MINT_ROUTE.enc_bits')
							)
						]
					]
				);
				
				$response = $call->getBody()->getContents();
				
				return json_decode($response);
				
				
			} catch ( BadResponseException $e ) {
				$response = json_decode($e->getResponse()->getBody()->getContents());
				throw new \Exception($response->error);
			} catch ( \Exception $e ) {
				
				throw new \Exception($e->getMessage());
			}
			
		}
		
		
	}
	
	
	/**
	 * Post Order
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function postOrder(array $request = NULL)
	{
		try {
			// validation
			$validation = validator($request, [
				'orderid' => 'required|string',
				'denomination_id' => 'required',
				//'quantity' => 'required|integer'
			]);
			
			if ( $validation->fails() ) {
				throw new \Exception($validation->errors()->first());
			} else {
				
				// init request
				$this->_curl->create(
					config('service.MINT_ROUTE.endpoint_url')
					. 'voucher'
				);
				
				// allowed filters
				$allowed_params = [
					'orderid' => NULL,
					'denomination_id' => NULL,
					//'quantity' => NULL
				];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				// add default values
				$params = array_merge($params, [
					'short' => TRUE,
					'reserve' => FALSE,
					'location' => config('service.MINT_ROUTE.pos_identification'),
					'quantity' => 1
				]);
				
				// collect params
				$params = json_encode([
					'username' => config('service.MINT_ROUTE.username'),
					'password' => config('service.MINT_ROUTE.password'),
					'data' => count($params) > 0 ? [ $params ] : []
				]);
				
				
				$this->_curl->post([
					'token' => config('service.MINT_ROUTE.pub_key'),
					'postedinfo' => AesCtr::encrypt(
						$params,
						config('service.MINT_ROUTE.pvt_key'),
						config('service.MINT_ROUTE.enc_bits')
					)
				]);
				
				// if error
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				$response = $this->_curl->execute();
				
				return json_decode($response);
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Purchase
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function purchase(array $request = NULL)
	{
		$unique_key = config('service.MINT_ROUTE.trans_prefix') . uniqid();
		
		try {
			// validation
			$validation = validator($request, [
				//'orderid' => 'required|string',
				'denomination_id' => 'required'
			]);
			
			if ( $validation->fails() ) {
				throw new \Exception($validation->errors()->first());
			} else {
				
				// merge in request
				$request['orderid'] = $unique_key;
				
				// reserve
				try {
					$this->reserve($request);
				} catch ( \Exception $e ) {
					throw new \Exception($e->getMessage());
				}
				
				// purchase and return data
				try {
					return $this->postOrder($request);
				} catch ( \Exception $e ) {
					throw new \Exception($e->getMessage());
				}
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Get Order
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getOrder(array $request = NULL)
	{
		try {
			// validation
			$validation = validator($request, [
				'orderid' => 'required|string'
			]);
			
			if ( $validation->fails() ) {
				throw new \Exception($validation->errors()->first());
			} else {
				
				// init request
				$this->_curl->create(
					config('service.MINT_ROUTE.endpoint_url')
					. 'order_details'
				);
				
				// allowed filters
				$allowed_params = [ 'orderid' => NULL ];
				// find intersecting keys
				$params = array_intersect_key($request, $allowed_params);
				
				// collect params
				$params = json_encode([
					'username' => config('service.MINT_ROUTE.username'),
					'password' => config('service.MINT_ROUTE.password'),
					'data' => count($params) > 0 ? [ $params ] : []
				]);
				
				
				$this->_curl->post([
					'token' => config('service.MINT_ROUTE.pub_key'),
					'postedinfo' => AesCtr::encrypt(
						$params,
						config('service.MINT_ROUTE.pvt_key'),
						config('service.MINT_ROUTE.enc_bits')
					)
				]);
				
				// if error
				if ( $this->_curl->error_code )
					throw new \Exception($this->_curl->error_string);
				
				$response = $this->_curl->execute();
				
				return json_decode($response);
				
			}
			
			
		} catch ( \Exception $e ) {
			
			throw new \Exception($e->getMessage());
		}
		
	}
	
}