<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\Payment;


/**
 * Class Stripe
 *
 * @package App\Libraries\Services\Payment
 */
class Stripe
{
	
	/**
	 * Stripe constructor.
	 */
	public function __construct()
	{
		// set app info (optional)
		\Stripe\Stripe::setAppInfo(APP_NAME, '1', url('/'));
		
		// set credentials
		\Stripe\Stripe::setApiKey(
			config('service.STRIPE.secret_key')
		);
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
			
			return \Stripe\Balance::retrieve();
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Post Customer
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function postCustomer(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'description' => 'required|string',
				'token' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [
				'description' => NULL,
				'token' => NULL
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			return \Stripe\Customer::create([
				"description" => $request['description'],
				"source" => $request['token']
			]);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Get Customer
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function getCustomer(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'token' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [ 'token' => NULL ];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			return \Stripe\Customer::retrieve($request['token']);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Post Card Token
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function postCardToken(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'cc_number' => 'required|numeric|digits:16',
				'exp_month' => 'required|integer|min:1|max:12',
				'exp_year' => 'required|date_format:Y|after:'
					. date('Y', strtotime('last year')),
				'cvc' => 'required|numeric|digits:3',
				'name' => 'string',
				'address_line1' => 'string',
				'address_line2' => 'string',
				'address_city' => 'string',
				'address_state' => 'string',
				'address_zip' => 'string',
				'address_country' => 'string',
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [
				'cc_number' => NULL,
				'exp_month' => NULL,
				'exp_year' => NULL,
				'cvc' => NULL,
				'name' => NULL,
				'address_line1' => NULL,
				'address_line2' => NULL,
				'address_city' => NULL,
				'address_state' => NULL,
				'address_zip' => NULL,
				'address_country' => NULL,
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			
			return \Stripe\Token::create([
				'card' => [
					"number" => $request['cc_number'],
					"exp_month" => $request['exp_month'],
					"exp_year" => $request['exp_year'],
					"cvc" => $request['cvc'],
					"name" => check_val($request['name']),
					"address_line1" => check_val($request['address_line1']),
					"address_line2" => check_val($request['address_line2']),
					"address_city" => check_val($request['address_city']),
					"address_state" => check_val($request['address_state']),
					"address_zip" => check_val($request['address_zip']),
					"address_country" => check_val($request['address_country']),
				]
			]);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Post Bank Token
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function postBankToken(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'account_number' => 'required|string|min:5',
				'country' => 'required|string|min:2|max:3',
				'currency' => 'required|string|min:3|max:3',
				'account_holder_name' => 'string|min:3',
				'account_holder_type' => 'string|in:customer,individual',
				'routing_number' => 'required_if:country,us|numeric|digits:9',
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [
				'account_number' => NULL,
				'country' => NULL,
				'currency' => NULL,
				'account_holder_name' => NULL,
				'account_holder_type' => NULL,
				'routing_number' => NULL,
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			
			return \Stripe\Token::create([
				'bank_account' => [
					"account_number" => $request['account_number'],
					"country" => $request['country'],
					"currency" => $request['currency'],
					"account_holder_name" => check_val($request['account_holder_name']),
					"account_holder_type" => check_val($request['account_holder_type']),
					"routing_number" => check_val($request['routing_number']),
				]
			]);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Get Token
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function getToken(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'token' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [ 'token' => NULL ];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			return \Stripe\Token::retrieve($request['token']);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Post Charge
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function postCharge(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'amount' => 'required|numeric|min:1',
				'currency' => 'required|string|min:3|max:3',
				//'token' => 'required|string|min:5',
				'customer' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [
				'amount' => NULL,
				'currency' => NULL,
				//'token' => NULL,
				'customer' => NULL,
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			// post data
			$post_data = [
				"amount" => ( intval($request['amount']) * 100 ),
				"currency" => $request['currency'],
				//"source" => $request['token'],
				"customer" => $request['customer'],
			];
			
			
			return \Stripe\Charge::create($post_data);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	
	/**
	 * Get Charge
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function getCharge(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'token' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [ 'token' => NULL ];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			return \Stripe\Charge::retrieve($request['token']);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
	/**
	 * Post Reserve
	 *
	 * @param array $request
	 *
	 * @return \Stripe\Customer
	 * @throws \Exception
	 */
	public function postReserve(array $request)
	{
		try {
			
			// validation
			$validation = validator($request, [
				'amount' => 'required|numeric|min:1',
				'currency' => 'required|string|min:3|max:3',
				'customer' => 'required|string|min:5'
			]);
			
			if ( $validation->fails() )
				throw new \Exception($validation->errors()->first());
			
			
			$allowed_params = [
				'amount' => NULL,
				'currency' => NULL,
				'customer' => NULL,
			];
			// find intersecting keys
			$request = array_intersect_key($request, $allowed_params);
			
			// post data
			$post_data = [
				"amount" => ( intval($request['amount']) * 100 ),
				"currency" => $request['currency'],
				"customer" => $request['customer'],
				'capture' => FALSE
			];
			
			
			return \Stripe\Charge::create($post_data);
			
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
	
}