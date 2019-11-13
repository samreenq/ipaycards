<?php
 
 /**
 * File Handle all Customer Account related functionality's
 * Created by PhpStorm.
 *
 * PHP version 7.0.8
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @package   App\Http\Controllers\Web
 * @author    Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
 * @version   1.0
 * @copyright Cubix.co
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @Date:     01/18/2017
 * @Time:     02:04 PM
 * 
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Models\Setting;
use App\Http\Models\SYSEntityAuth;
use App\Libraries\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Input;

use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\System\Entity;


use View;
use Validator;


/**
  *
  * AccountController Class Handle all functionality's related to Personal Account of customer.
  *
  * @package  	AccountController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/
class AccountController extends WebController {

	/**
     * Global Private variable of this file.It has object of Entity Library 
     * 
     * @access private
     * @var Object
     */
	private $_object_library_entity;

    /**
     * Global Private variable of this file.It has object of Entity Library
     *
     * @access private
     * @var Object
     */
    private $_object_library_general_setting;

    /**
	 * Sets the $_object_library_entity with Entity Library object
	 *
	 * @internal param Sets $_object_library_entity with Entity Library object
	 * @access public
	 */
	public function __construct(Request $request)
    {
        parent::__construct($request);

		$this->_object_library_entity = new Entity();
        $this->_object_library_general_setting = new GeneralSetting();

	}

	/**
     * Fetch the data of order of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of order Detail page 
	 * @access public
     *
     */ 
	public function getOrderDetail(Request $request) 
	{		
		$validator = Validator::make(
						$request->all(),
						[
							'entity_id'		=>	'required'
						]
					);		
		if($validator->fails())
		{
			
			return trans('web.productError');
		}
		else 
		{
			$entity_id = $request->input('entity_id');

			$params = [
                'entity_type_id'=>'order',
                'mobile_json'=>1,
                'hook'=>'order_item',
                'entity_id'=>$entity_id,
               // 'in_detail' => 1,
                'order_item_detail_key' => 'product_id'
            ];


			$json = json_decode(
						json_encode(
                            $this->_object_library_entity->apiGet($params)
						),
						true
					);

            $data['order_detail'] = $json['data']['order'];
            $order_helper_lib = new OrderHelper();
            $data['order_statuses'] = $order_helper_lib->getOrderDisplayStatus();
            $data['currency'] = $this->_object_library_general_setting->getCurrency();
			return View::make('web/includes/account/order_detail',$data)->__toString();
		}
		
    }
	
	
	
	/**
     * Fetch the data of reviews of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of order review page 
	 * @access public
     *
     */ 
	public function getOrderReview(Request $request) 
	{		

		$validator  =   Validator::make(
							$request->all(),
							[
								'entity_id'	=> 'required'
							]
						);		
		if($validator->fails())
		{
			$validator = Validator::make(
							$request->all(),
							[
								'order_id'		=>	'required'		,
								'review'		=>	'required'		,
								'rating'		=>	'required'
							]
						);		
			if($validator->fails())
			{

				return trans('web.productError');
			}
			else 
			{
				$order_id 		= $request->input('order_id');
				$reviews 		= $request->input('review');
				$star_rating  	= $request->input('rating');
				$customer_id  =   $this->_customerId;

               $a  =  json_decode(
                    json_encode(
                        $this->_object_library_entity->apiUpdate(
                            [
                                'entity_type_id'	=>		15					,
                                'entity_id'			=>		$order_id 			,
                                'star_rating'		=>		$star_rating 		,
                                'reviews'			=>		$reviews			,
                                'mobile_json'		=>		1,
                                'login_entity_id'   => $customer_id
                            ],
                        true
                        )
                    ),
                    true
                );
				//print_r($a); 
			}
		}
		else 
		{
			$json = json_decode(
						json_encode(  $this->_object_library_entity->apiGet(
								[
									'entity_type_id'	=>	'order',
									'mobile_json'		=>	1,
									'hook'				=>	'order_item',
									'entity_id'			=>	$request->input('entity_id')
								],
								true
							)
						),
						true
					);
			$data['order_detail'] = isset($json['data']['order']) ? $json['data']['order'] : null;
		
			return View::make('web/includes/account/review_detail', $data)->__toString();
		}
		
    }
	
	
	
	
	/**
     * Fetch the data of order history of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of order history listing page 
	 * @access public
     *
     */ 
	public function getOrderHistory(Request $request) 
	{		
	
		$validator 	= 	Validator::make(
					$request->all(),
					[
						'entity_type_id'	 =>  'required'		,			
						'offset'			 =>  'required'		,
						'limit'				 =>  'required'
						
					]
				);
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$limit =  $request->input('limit');

						$tmp = [
											'entity_type_id'	=> 'order',
											'customer_id'		=> $this->_customerId,
											'offset'			=> $request->input('offset'),
											'limit'				=> $limit,
											'entity_id'			=> '',
											//'mobile_json'		=> 1,
                                            'in_detail'         => 1
										];

				$json = json_decode(
								json_encode(
									$this->_object_library_entity->apiList(
										$tmp
									)
								),
								true
								
							);


            $data['order'] = isset($json['data']['entity_listing'])? $json['data']['entity_listing'] : null;

          //  echo "<pre>"; print_r($data); exit;
				$data1['order'] = View::make('web/includes/account/order_history_detail',$data)->__toString();
				$data1['items'] = isset($json['data']['page']['total_records'])
                                    ?
                                        ceil($json['data']['page']['total_records']/$limit)
                                    :
                                        null;
				
				return $data1;
		}
    }
	
	
	
	
	
	/**
     * Fetch the data of payment details of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of payment listing page 
	 * @access public
     *
     */ 
	public function getPaymentDetail(Request $request) 
	{
			$json = json_decode(
								json_encode(
									$this->_object_library_entity->apiList(
										[
											'entity_type_id'	=>	11,
											'entity_id'			=>	$this->_customerId,
											'mobile_json'		=>	1,
										]
									)
								),
								true
								
							);
			
			$data['customer'] = isset($json['data']['customer']) ? $json['data']['customer'] : null;
			
			return View::make('web/payment',$data);
		
    }	
	
	
	
	
	/**
     * Fetch the data of address book details of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of address book  page 
	 * @access public
     *
     */ 
	public function getAddressBook(Request $request) 
	{
			$json = json_decode(
						json_encode(
							$this->_object_library_entity->apiList(
								[
									'entity_type_id'	=>	18,
									'customer_id'		=>	$this->_customerId,
									'mobile_json'		=>	1,
									'limit'				=>	1000,
									'entity_id'=> '',
								]
							)
						),
						true
								
					);
					
			$data['address'] = isset($json['data']['shipping_address']) ? $json['data']['shipping_address'] : null;

        $setting_model = new Setting();
        $google_key = $setting_model->getBy('key','google_api_key');
        $data['google_api_key'] = (isset($google_key->value)) ? $google_key->value : "";

			return View::make('web/address_book',$data);
		
    }
	
	
	
	
	
	/**
     * Fetch the data of Account details of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Account detail page 
	 * @access public
     *
     */ 
	public function getAccountDetail(Request $request) 
	{		
		if(isset($this->_customer)){
            $data['user'] = $this->_customer;
        }

			return View::make('web/your_account',$data);
		
    }
	
	
	
	
	/**
     * Change the data of Account details of customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the $data which has updated information Account Details
	 * @access public
     *
     */ 
	public function changeAccountDetail(Request $request) 
	{
            $messages = array(
                'account_mobile_no.required_if' => 'The mobile number field is required.'
            );

            $sys_entity_auth = new SYSEntityAuth();

			$validator = Validator::make(
							$request->all(),
							[
								'first_name'	=>	'required',
								'last_name'		=>	'required',
                                 'account_mobile_no' => 'required_if:platform_type,custom|mobile|unique:' .$sys_entity_auth->table . ',mobile_no,'.$this->_customer['entity_auth_id'].','. $sys_entity_auth->primaryKey .',deleted_at,NULL'
							],$messages
						);

            if($validator->fails())
			{
				$errors = $validator->errors();
                $data['message'] = '';
				if(!empty($errors->first('first_name'))){
                    $data['message'] .= $errors->first('first_name')."<br> ";
                }

                if(!empty($errors->first('last_name'))){
                    $data['message'] .= $errors->first('last_name')."<br> ";
                }

                if(!empty($errors->first('account_mobile_no'))){
                    $data['message'] .= $errors->first('account_mobile_no')."<br> ";
                }


				//$data['message'] = $errors->first('first_name')."<br> ".$errors->first('last_name')."<br> ".$errors->first('account_mobile_no');
				return $data;
			}
			else 
			{
				$first_name = $request->input('first_name');
				$last_name  = $request->input('last_name');
							
				$json = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/entity_auth/edit_profile', 
									'POST', 
									[
										'entity_type_id'	=>	11,
										'entity_id'			=>	$this->_customerId,
										'mobile_json'		=>	1,
										'first_name'		=>	$first_name,
										'last_name'			=>	$last_name,
                                        'login_entity_id'   => $this->_customerId,
                                        'mobile_no'         => $request->input('account_mobile_no')
									],
									true
								)
							),
							true
						);


                $this->_customer['attributes']['first_name'] = 	$first_name;
                $this->_customer['attributes']['last_name']	 =	$last_name;
                $this->_customer['auth']['mobile_no']	 =	$request->input('account_mobile_no');

				if ($request->session()->has('users')) 
				{
					 $request->session()->forget('users');
					 $request->session()->push('users',$this->_customer);
				}
				$data = [];
				$data['customer'] = isset($json['data']['customer']) ?  $json['data']['customer'] : null ;
				$data['message']  = isset($json['message']) ?  $json['message'] : null ;

				return $data;
			}
		
    }
	
	

	
	/**
     * Change the Password of Customer Account using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the $data which has updated Password of Customer Account
	 * @access public
     *
     */ 
	public function changeAccountPassword(Request $request) 
	{		

			$validator  =   Validator::make(
								$request->all(),
								[
									'current_password'			=>	'required'		,
									'new_password'				=>	'required'		,
									'confirm_password'			=>	'required'
								]
							);		
			if($validator->fails())
			{
				$errors = $validator->errors();

				$data['error']   = 1;
				$data['message'] = $errors->first('current_password');

				if(!empty($data['message'])){
                    $data['message'] .='<br>';
                }

                $data['message'] .= $errors->first('new_password');

                if(!empty($data['message'])){
                    $data['message'] .='<br>';
                }

                $data['message'].= $errors->first('confirm_password');

				return $data;
			}
			else 
			{
				$current_password  	= $request->input('current_password');
				$new_password   	= $request->input('new_password');
							
				$json = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/entity_auth/change_password', 
									'POST', 
									[
										'entity_id'			=>	$this->_customerId,
										'current_password'	=>	$current_password,
										'new_password'		=>	$new_password ,
										'mobile_json'		=>	1,
									],
									true
								)
							),
							true
						);
				$data = [];
                $data['customer'] = isset($json['data']['customer']) ? $json['data']['customer'] : null;
                $data['error'] 	  = isset($json['error']) ? $json['error'] : null;
                $data['message']  = isset($json['message']) ?  $json['message'] : null ;

				return $data;
			}
		
    }
	
	
	
	
	/**
     * Change the Payment Method of Customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the $data which has updated Payment Method of Customer 
	 * @access public
     *
     */ 
	public function changePaymentMethodType(Request $request) 
	{		
			$validator =Validator::make(
							$request->all(),
							[
								'payment_method_type'	=>	'required'
							]
						);		
			if($validator->fails())
			{
				return trans('web.productError');
			}
			else 
			{
				$payment_method_type  	= $request->input('payment_method_type');

				$customer_id  =   $this->_customerId;

				if($customer_id){
                    $json=  json_decode(
                        json_encode(
                          $this->_object_library_entity->apiUpdate(
                                [
                                    'entity_id'				=>	$customer_id,
                                    'entity_type_id'		=>	11,
                                    'payment_method_type'	=>	$payment_method_type,
                                    'mobile_json'			=>	1,
                                    'login_entity_id'   => $customer_id,

                                ],
                                true
                            )
                        ),
                        true
                    );
                }

				$data = [];
                $data['customer'] = isset($json['data']['customer']) ? $json['data']['customer'] : null;
                $data['error'] 	  = isset($json['error']) ? $json['error'] : null;
                $data['message']  = isset($json['message']) ?  $json['message'] : null ;

				return $data;
			}
    }
	
	
	
	
	/**
     * Save the Address of Customer using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the $data which has updated List of Customer Address.
	 * @access public
     *
     */ 
	public function saveAddress(Request $request) 
	{
        $error_message = ['formatted_address.required' => 'The Street Address is required'];

        $validator = Validator::make(
							$request->all(),
							[
								'formatted_address'	=>	'required'	,	
								'latitude'			=>	'required'	,	
								'longitude'			=>	'required'	
							],
            $error_message
						);		
			if($validator->fails())
			{
				$errors = $validator->errors();
                $data['error'] = 1;
				$data['message'] = $errors->all();
                $data['message'] = implode('<br>',$data['message']);
				return $data;
			}
			else 
			{
				$formatted_address = $request->input('formatted_address');
				$latitude = $request->input('latitude');
				$longitude = $request->input('longitude');

				$customer_id= $this->_customerId;

					$json1 = json_decode(
								json_encode(
									$this->_object_library_entity->apiPost(
										[
											'entity_type_id'	=>	18,
											'street'			=>	$formatted_address ,
											'email'				=>	$this->_customer['auth']['email'],
											'first_name'		=>	$this->_customer['auth']['name'],
											'last_name'			=>	$this->_customer['auth']['name'],
											'telephone'			=>	$this->_customer['auth']['mobile_no'],
											'latitude'			=>	$latitude ,
											'longitude'			=>	$longitude ,
											'customer_id'		=>	$customer_id,
											'region'			=>	' ',
											'title'				=>	' ',
											'country'			=>	' ',
											'company'			=>	' ',
											'postcode'			=>	' ',
											'city'				=>	' ',
											'mobile_json'		=>	1,
											'entity_id'=> '',
                                            'login_entity_id' => $customer_id,
										]
									)
								),
								true
								
							);
					
					$json = json_decode(
								json_encode(
									$this->_object_library_entity->apiList(
										[
											'entity_type_id'=>18,
											'customer_id'=>	$customer_id,
											'mobile_json'=>1,
											'limit'=>1000,
											'entity_id'=> ''
										]
									)
								),
								true
								
							);
					
					$data['address'] =	isset($json['data']['shipping_address']) ? $json['data']['shipping_address'] : null;

                $setting_model = new Setting();
                $google_key = $setting_model->getBy('key','google_api_key');
                $data['google_api_key'] = (isset($google_key->value)) ? $google_key->value : "";
                $data['error'] = 0;
                return $data;
				//	return View::make('web/address_book',$data);
			}
		
    }

    public function orderHistory(Request $request)
    {
        return View::make('web/order_history');
    }

    /**
     * Change the Payment Method of Customer using internal call ( API )
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the $data which has updated Payment Method of Customer
     * @access public
     *
     */
    public function updateWalletDefault(Request $request)
    {
        $validator =Validator::make(
            $request->all(),
            [
                'default_wallet_payment'	=>	'required'
            ]
        );
        if($validator->fails())
        {
            return trans('web.productError');
        }
        else
        {
            $default_wallet_payment  	= $request->input('default_wallet_payment');

            $customer_id  =   $this->_customerId;

            if($customer_id){
                $json=  json_decode(
                    json_encode(
                        $this->_object_library_entity->apiUpdate(
                            [
                                'entity_id'				=>	$customer_id,
                                'entity_type_id'		=>	11,
                                'default_wallet_payment'	=>	$default_wallet_payment,
                                'mobile_json'			=>	1,
                                'login_entity_id'   => $customer_id,

                            ],
                            true
                        )
                    ),
                    true
                );
            }
            //echo "<pre>"; print_r($json); exit;
            $data = [];
            $data['customer'] = isset($json['data']['customer']) ? $json['data']['customer'] : null;
            $data['error'] 	  = isset($json['error']) ? $json['error'] : null;
            $data['message']  = isset($json['message']) ?  $json['message'] : null ;

            return $data;
        }
    }
	
}
