<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\Cards;


use App\Libraries\Curl;
use Illuminate\Support\Facades\DB;

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
	 * Brands
	 *
	 * @param array|NULL $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function brands(array $request = NULL)
	{
		// fetch brands
		$records = DB::table('vendor_brands AS vp')
			->get();
		
		// change keys
		$records = change_keys(
			json_decode(json_encode($records), TRUE),
			[
				'id' => 'brand_id',
				'brand' => 'brand_name'
			]);
		
		return $this->_responseMapping($records);
		
		
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
		// validation
		$validation = validator($request, [
			'brand_id' => 'required'
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			// product field
			$pr_field = config('service.ONE_PREPAY.mode') == 'sandbox' ?
				'vp.uat_product_code' : 'vp.live_product_code';
			
			$records = DB::table('vendor_products AS vp')
				->join('vendor_brands AS vb', 'vb.id', '=', 'vp.brand_id')
				->where('vp.transaction_type', '=', 'pin')
				->where('vp.brand_id', '=', $request['brand_id'])
				->select('*', $pr_field . ' AS product_code')
				->get();
			
			// change keys
			$records = change_keys(
				[
					'denominations' => json_decode(json_encode($records), TRUE)
				],
				[
					//'id' => 'denomination_id',
					'product_code' => 'denomination_id',
					'value' => 'denomination_value'
				]);
			
			return $this->_responseMapping($records);
			
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
		
		// set params
		$request['quantity'] = 1;
		
		// validation
		$validation = validator($request, [
			'denomination_id' => 'required',
			'quantity' => 'required|integer',
			'orderid' => 'required|string'
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			try {
				// params
				$input_xml = '<RequestXml>
					<Type>PinRequest</Type>
					<TerminalId>' . config('service.ONE_PREPAY.terminal_id') . '</TerminalId>
					<Password>' . config('service.ONE_PREPAY.password') . '</Password>
					<Language>eng</Language>
					<ReceiptNo>501327588</ReceiptNo>
					<ValueCode>25</ValueCode>
					<ClerkId>1</ClerkId>
					<RefNo>123456</RefNo>
					<ProdCode>' . $request['denomination_id'] . '</ProdCode>
				</RequestXml>';
				
				// remove whitespaces between tags
				$input_xml = preg_replace('/\s+/', '', $input_xml);
				
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
	}
	
	
	/**
	 * Response Key Mapping
	 *
	 * @param array $response
	 */
	private function _responseMapping(array &$response = [])
	{
		return $response;
	}
	
	
}