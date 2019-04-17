<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:49 PM
 */

namespace App\Libraries\Services\Topup;


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
			
			
			// change keys
			$response = change_keys(
				$response,
				[
					'Balance' => 'balance',
					'MerchantId' => 'vendor_name'
				]);
			
			return $response;
			
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
		
	}
	
	
	/**
	 * Products
	 *
	 * @param array|NULL $request
	 *
	 * @throws \Exception
	 */
	public function products(array $request = NULL)
	{
		// product field
		$pr_field = config('service.ONE_PREPAY.mode') == 'sandbox' ?
			'vp.uat_product_code' : 'vp.live_product_code';
		
		$records = DB::table('vendor_products AS vp')
			->join('vendor_brands AS vb', 'vb.id', '=', 'vp.brand_id')
			->where('vp.transaction_type', '=', 'pinless')
			//->where('vp.brand_id', '=', $request['brand_id'])
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
		
		return $records;
		
		
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
		// set params
		$request['quantity'] = 1;
		
		// validation
		$validation = validator($request, [
			'denomination_id' => 'required',
			'account_no' => 'required|string|min:5',
			'amount' => 'required|numeric|min:5'
		]);
		
		if ( $validation->fails() ) {
			throw new \Exception($validation->errors()->first());
		} else {
			
			try {
				$unique_key = config('service.ONE_PREPAY.trans_prefix') . uniqid();
				
				/**
				 * Pinless request 1
				 */
				
				// params
				$input_xml = '<RequestXml>
					<Type>PinlessRequest</Type>
					<TerminalId>' . config('service.ONE_PREPAY.terminal_id') . '</TerminalId>
					<Password>' . config('service.ONE_PREPAY.password') . '</Password>
					<Language>eng</Language>
					<ProdCode>' . $request['denomination_id'] . '</ProdCode>
					<Amount>' . $request['amount'] . '</Amount>
					<AccountNo>' . $request['account_no'] . '</AccountNo>
					<ReceiptNo>' . $unique_key . '</ReceiptNo>
					<ClerkId>1</ClerkId>
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
				
				/**
				 * Pinless request 2
				 */
				
				// params
				$input_xml = '<RequestXml>
					<Type>PinlessRequest2ndStep</Type>
					<TerminalId>' . config('service.ONE_PREPAY.terminal_id') . '</TerminalId>
					<Password>' . config('service.ONE_PREPAY.password') . '</Password>
					<Language>eng</Language>
					<ProdCode>' . $request['denomination_id'] . '</ProdCode>
					<Amount>' . $request['amount'] . '</Amount>
					<AccountNo>' . $request['account_no'] . '</AccountNo>
					<ReceiptNo>' . $unique_key . '</ReceiptNo>
					<RefNo>' . $unique_key . '</RefNo>
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
				
				
				return $response;
				
				
			} catch ( \Exception $e ) {
				
				throw new \Exception($e->getMessage());
			}
			
		}
	}
	
	
}