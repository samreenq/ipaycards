<?php
/**
 * Payment bridge between React Native and WebPay payment gateway
 * Created by PhpStorm.
 * User: Muhammad Zeeshan.Tahir
 * Date: 12/29/2017
 * Time: 2:13 PM
 */


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Models\Web\OrderEntity;
use Illuminate\Http\Input;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use View;
use Validator;


/**
  * Description by  open
  * @property $magic
  * @return view
*/
class PaymentController extends WebController
{

    /**
     * PaymentController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Description by  open
     * @property $magic
     * @return view
     */
    public function bridgepage(Request $request)
    {
        return View::make('web/includes/payment/webpay');
    }
	
	/**
     * Description by  open
     * @property $magic
     * @return view
     */
    public function processPaymentData(Request $request)
    {
		$validator = Validator::make(
										$request->all(),
										[
											'txt_ref'	=>	'required'	,
											'amount'	=>	'required'	,
											'cust_name'	=>	'required'
										]
									);
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$token 		= 	$request->session()->token();
			$txn_ref	=	$request->input('txt_ref');
			$cust_name	=	$request->input('cust_name').' ';
			$amount		=	round($request->input('amount')*100,0);
			
			$data =[
						'entity_type_id'	=>	"48"	,
						'mobile_json'		=>	1	
					]; 		
			$response= json_encode(
										CustomHelper::internalCall
																	(
																		$request,
																		'api/system/entities/listing', 
																		'GET',
																		$data,
																		false
																	));
			$json = json_decode(
									$response,
									true
								);
			$data = $json['data']['payment_config'][0];	
			
			 
			$product_id			=	$data['payment_product_id'];
			$pay_item_id		=	$data['payment_item_id'];
			
			$currency			=	"566";
			$site_redirect_url	=	url('/')."/webpay/response?&_token=".$token;;
			$cust_id			=	$data['payment_user']	 ;
			$site_name			=	"TodayToday";
			
			$mackey 			=	$data['client_id'];
			$data 				= 	$txn_ref.$product_id.$pay_item_id.$amount.$site_redirect_url.$mackey; 
			$hash 				=	hash('sha512', $data );
			
			$data = [
						'txn_ref'			=>	$txn_ref			,
						'entity_id'			=>	"977"				,
						'txn_ref'			=>	$txn_ref			,
						'product_id'		=>	$product_id			,
						'pay_item_id'		=>	$pay_item_id		,
						'amount'			=>	$amount				,
						'currency'			=>	$currency			,
						'site_redirect_url' =>	$site_redirect_url	,
						'cust_id'			=>	'319'				,
						'site_name'			=>	$site_name			,
						'cust_name'			=>	$cust_name			,
						'mackey'			=>	$mackey				,
						'hash'				=>	$hash				
						
					]; 	
		
			$data = json_encode($data);
			
			return $data;	
		}
    }
	
	
	/**
     * Description by open
     * @property $magic
     * @return view
    */
	public function webpayResponse(Request $request)
    {
		$validator = Validator::make(
										$request->all(), 
										['_token' => 'required']
									);
		if($validator->fails())
		{
			return '';
		}
		else
		{
			$data['data'] =  json_encode($request->all()); 
			return View::make('web/includes/payment/webpay', $data);
		}
	}	


}