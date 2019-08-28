<?php
 
 /**
 * File Handle all Checkout related functionalities 
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
use App\Http\Models\SYSTableFlat;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\OrderCart;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use View;
use Validator;


/**
  *
  * CheckOutController Class Handle all functionalities related to Checkout .
  *
  * @package  	AccountController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/
class CheckOutController extends WebController {
	
	
	/**
     * Global Private variable of this file.It has object of Entity Library 
     * 
     * @access private
     * @var Object
     */
	private $_object_library_entity;
	
	/**
     * Global Private variable of this file.It has object of Custom Helper 
     * 
     * @access private
     * @var Object
     */
	private $_object_helper_customer;

    /**
     * Sets the $_object_library_entity with Entity Library object 
     *
     * @param Sets the $_object_library_entity with Entity Library object.
     * @return _object_library_entity 
	 * @access public
	 * 
     */ 
	public function __construct(Request $request)
    {
        parent::__construct($request);

		$this->_object_library_entity = new Entity();
		$this->_object_helper_customer = new GeneralSetting();

	}	
	
	
	/**
     * Fetch the data of delivery slots of using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Delivery Slots page 
	 * @access public
     *
     */ 
	public function getAllTimeSlots(Request $request) 
	{
		$validator 	= 	Validator::make(
							$request->all(),
							[
								'day'	=>  'required'			    
							]
						);		
		if($validator->fails())
		{
			return 'NA';
		}
		else 
		{

		    $params = [
                'entity_type_id'=>'delivery_slot',
                'day'=>$request->input('day'),
                'hook'=>'delivery_slot_item',
                'mobile_json'=>1
            ];
            $response = $this->_object_library_entity->apiList($params);
            $json = json_decode(json_encode($response),true);

			/*$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing', 
								'GET',
								[
									'entity_type_id'=>34,
									'day'=>$request->input('day'),
									'hook'=>'delivery_slot_item',
									'mobile_json'=>1
								],
								false
							)
						),
						true
					);*/
			$data['slots'] = isset($json["data"]["delivery_slot"][0]['delivery_slot_item'])
								? 
									$json["data"]["delivery_slot"][0]['delivery_slot_item'] 
								: 
									null; 
			$data['general'] = $this->_object_helper_customer->getCurrency();
			return View::make('web/includes/checkout/delivery_slot',$data)->__toString();
		}
	}
	
	
	/**
     * Discount Calculation of Coupon code  
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Discount Calculated Data page 
	 * @access public
     *
     */
	public function discountCalculation(Request $request) 
	{
		$validator  = 	Validator::make(
							$request->all(),
							[
								'data'		 	=>  'required'		,
								'coupon_code'	=>	'required'
							]
						);		
		if($validator->fails())
		{
			$data = []; 
			$data['message'] = "Please enter coupon code.";
			
			return $data; 
		}
		else 
		{	
	
			$subtotal=0;$total_cart_products=0;
			foreach ( $request->input('data') as $products ) 
			{
				$subtotal = $subtotal + ($products['product_quantity'] * $products['price'] );
				$total_cart_products++;
			}
			
			$data = array("entity_type_id"=>23,"coupon_code"=>$request->input('coupon_code')); 
		
			$json   = 	json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing', 
									'GET',
									[
										'entity_type_id'	=> 23,
										'coupon_code'		=> $request->input('coupon_code')
									],
									false
								)
							),
							true
						);
		
			$data['coupon'] = isset($json["data"]["entity_listing"]) ? $json["data"]["entity_listing"] : null;
			
			if(isset($data['coupon'][0]))
			{
				$data['coupon'] = $data['coupon'][0];
				$coupon_id = $data['coupon']['entity_id'];
				if($data['coupon']['attributes']['coupon_status']['value']==1)
				{
						if(isset($data['coupon']['attributes']['start_date']))
							$start_date = $data['coupon']['attributes']['start_date'];
						if(isset($data['coupon']['attributes']['coupon_expiry']))
							$end_date = $data['coupon']['attributes']['coupon_expiry'];
						
						$current_date = date("Y-m-d H:i:s"); 
						//$discount_amount = 0; 
						
						if(isset($start_date) && isset($end_date))
						{
							if(strtotime($current_date) >= strtotime($start_date) && strtotime($current_date) <= strtotime($end_date) )
							{
								if($subtotal>=$data['coupon']['attributes']['minimum_order'])
								{
									
									if($data['coupon']['attributes']['coupon_type']['value']=="percent")
									{
										if(isset($data['coupon']['attributes']['coupon_discount']))
										{
											
											$discount_amount 	  =  $data['coupon']['attributes']['coupon_discount'];
											$discount_amount	  =  ( $discount_amount * $subtotal ) / 100 ;
										}
										else 
										{
											$data1 = []; 
											$data1['message'] = "Coupon discount amount is not defined!";
											$data1['currency'] = $this->_object_helper_customer->getCurrency();
											
											return $data1; 
										}
									}
									if($data['coupon']['attributes']['coupon_type']['value']== "flat")
									{
										if(isset($data['coupon']['attributes']['coupon_discount']))
										{
											$discount_amount 	  = $data['coupon']['attributes']['coupon_discount'];
											
										}
										else 
										{
											$data1 = []; 
											$data1['message'] = "Coupon discount amount is not defined!";
											$data1['currency'] = $this->_object_helper_customer->getCurrency();
											
											return $data1; 
										}
									}
									$data1 = array(); 
									$data1['subtotal']	  = $subtotal; 
									$data1['total_cart_products'] = $total_cart_products; 
									$subtotal_with_discount = $subtotal - $discount_amount;
									$data1['subtotal_with_discount'] = round($subtotal_with_discount,2);
									$data1['discount_amount']	= $discount_amount; 
									$data1['coupon_id']= $coupon_id;
									
									$json = json_decode(
													json_encode(
														CustomHelper::internalCall(
																$request,
																"api/system/entities/listing", 
																'GET',
																[
																	'entity_type_id'	=> 25 ,
																	'mobile_json'		=> 1
																],
														false
													)),
												true);
								
									//$loyalty_points = $json['data']['general_setting'][0]['loyalty_points'];
									//$loyalty_amount = $json['data']['general_setting'][0]['loyalty_amount'];
									
									/*if($subtotal_with_discount>=$loyalty_amount)
										$calculated_loyalty_points	= round(( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points,2) ;
									else
										$calculated_loyalty_points  = 0; 
									
									$data1['calculated_loyalty_points']	 = $calculated_loyalty_points;*/
									$data1['currency'] =$this->_object_helper_customer->getCurrency();
									
									return $data1; 
									
								}
								else
								{
									$data1 = array(); 
									$data1['message'] = "Minimum order amount to apply this coupon is ".$data['coupon']['attributes']['minimum_order'];
									$data1['currency'] =$this->_object_helper_customer->getCurrency();
									
									return $data1; 
								}
							}
							else
							{
								$data1 = array(); 
								$data1['message'] = "Coupon code is expired.";
								$data1['currency'] = $this->_object_helper_customer->getCurrency();
								
								return $data1; 
							}
						}
						else
						{
							$data1 = array(); 
							$data1['message'] = "Coupon code is expired.";
							$data1['currency'] = $this->_object_helper_customer->getCurrency();
							
							return $data1; 
						}
				}
				else
				{
					$data1 = array(); 
					$data1['message'] = "Coupon code no longer exists";
					$data1['currency'] = $this->_object_helper_customer->getCurrency();
					
					return $data1; 
				}
				
			}
			else
			{
				$data1 = array(); 
				$data1['message'] = "Coupon code no longer exists";
				$data1['currency'] = $this->_object_helper_customer->getCurrency();
				
				return $data1; 
			}
			
		}
	}

	/**
     * Check Out function do calculation of products data and add data of products in cart
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Discount Calculated Data page 
	 * @access public
     *
     */
	public function checkout(Request $request)
	{
		$rules  =  array('data' =>  'required',	);
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			
			return array(
			    'error' => 0,
                'message' => 'No items are found in cart'
            );
		}
		else 
		{
			$products 	 = $request->input('data'); 
			$coupon_code = $request->input('coupon_code');
			$token  = $request->session()->token();
            $response = array();
			
/*			$p=0;
			foreach ( $products as $productList ) 
			{
				$depend_entity[$p]['product_id']		=	$productList["entity_id"];
				$depend_entity[$p]['quantity']			=	$productList["product_quantity"];
				$depend_entity[$p]['price']				=	"5";
		 
				$depend_entity[$p]['entity_type_id']    =   20;
				$p++;	
			}
	 
			$response = CustomHelper::internalCall(
							$request,
							'api/system/entities', 
							'POST',
							[
								'entity_type_id'		=>  19,
								'_token'				=>	$token,
								'user_requested_coupon'	=>	$coupon_code,
								'customer_id'			=>	$this->_customerId,
								'title'					=>	"cart-".$this->_customerId.'-'.rand(rand(1,1000),rand(2000,10000)),
								'depend_entity' 		=> 	$depend_entity,
								'_lang' 				=> 	"en",
								'created_at' 			=>	date("Y-m-d H:i:s")
							
							],
							false
						);*/
						
			return ['data'=> isset($response) ? $response : null,'error'=>0];
		}  
    }
	
	/**
     * CheckOut1 function get delivery slots from internal call ( API ) function 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Delivery slots Data page 
	 * @access public
     *
     */
	public function checkout1(Request $request)
	{
						  
			/*$json 	= 	json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing', 
									'GET', 
									[
										'entity_type_id'	=>	34						,
										'hook'				=>	'delivery_slot_item'	,
										'mobile_json'		=>	1
									],
									true
								)
							),
							true
						); 
			$data = []; 
			
			
			$data['delivery_slot'] = isset($json["data"]["delivery_slot"])? $json["data"]["delivery_slot"] : null;
	
		
			foreach ( $data['delivery_slot'] as $delivery_slot_attributes ) 
			{
				if($delivery_slot_attributes['day']['value']==7) 
					$days[0] = 0;
				else 
					$days[$delivery_slot_attributes['day']['value']] = $delivery_slot_attributes['day']['value'];
			
			}
			asort($days); 
			$data['days'] = $days;*/
			
			return View::make('web/checkout1',array());
		
	}
	
	/**
     * CheckOut2 function get Customer Addresses using apiList function of Entity Library 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Delivery Addresses Data page 
	 * @access public
     *
     */
	 
	public function checkout2(Request $request)
	{
			/*$data = array("entity_type_id"=>18,"customer_id"=>	$this->_customerId);
			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET', $data,true));
			
			$json = json_decode(
						json_encode(
							$this->_object_library_entity->apiList(
								[
									'entity_type_id'=>18,
									'customer_id'=>	$this->_customerId,
									'mobile_json'=>1,
									'limit'=>1000,
									'entity_id'=> ''
								]
							)
						),
						true
					);*/
        $data = [];
        $data['address'] =  null;
        $data['currency'] = $this->_object_helper_customer->getCurrency();
		return View::make('web/checkout2',$data);
	}

    /**
     * @param Request $request
     * @return array|bool
     */
	public function updateCart(Request $request)
    {
      //  echo 'Hiiiii';
       //echo "<pre>"; print_r($request->products);exit;
	    if(isset($request->products) || empty($request->products)){

           // echo "<pre>"; print_r($request->products);exit;
            //Save Cart
            if (isset($this->_customerId) && $this->_customerId > 1){
                $order_cart_lib = new OrderCart();
               return $order_cart_lib->saveCart($this->_customerId);
            }
        }
    }

    public function checkoutCart(Request $request)
    {
        $order_number = '';
       /* if($id != ''){
            $flat_table_model = new SYSTableFlat('order');
            $where = ' entity_id ='.$id;
            $data = $flat_table_model->getColumnByWhere($where,'order_number');

            $order_number = $data->order_number;
        }*/

       // $data = ['order_number' => $order_number];
        $data['social_media_url']	= $request->fullUrl();
        $data['meta_description'] = 'I have purchased Vouchers from this amazing website. Check it out.';
        $data['meta_image'] =  url('/').'/public/images/logo.png';

        return View::make('web/checkout3',$data);
    }

    public function checkoutOrder(Request $request)
    {
        return View::make('web/checkout4');
    }
}
