<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Models\SYSEntityAuth;
use App\Http\Models\SYSTableFlat;
use App\Libraries\Custom\PaymentLib;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\OrderCart;
use App\Libraries\System\Entity;
use App\Libraries\WalletTransaction;
use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use App\Libraries\OrderHelper;
use App\Http\Models\Web\OrderEntity;

class OrderController extends WebController {

	/**
	 * OrderController constructor.
	 * @param Request $request
	 */
	function __construct(Request $request)
	{
		parent::__construct($request);

		$this->_pLib = new Entity();

	}

	public function saveOrder(Request $request)
	{// echo '<pre>'; print_r($request->all()); exit;
        $email = $request->recipient_email ;
        if(isset($request->is_gift_card)){
            if($request->is_gift_card == 1){


                if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return array(
                        'error' => 1,
                        'message' => 'Enter a valid email address'
                    );
                }


                if($request->recipient_name == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient Name is required'
                    );
                }

                if($request->recipient_email == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient Email is required'
                    );
                }
                if($request->recipient_message == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient messsage is required'
                    );
                }

            }
        }

        if($request->auth_platform_type == 'facebook' && empty($request->checkout_mobile)) {

            return array(
                'error' => 1,
                'message' => 'The contact number is required to process order'
            );
        }

        if(($request->auth_platform_type == 'facebook' && !empty($request->checkout_mobile)) && (isset($this->_customer['auth']['mobile_no']) && empty($this->_customer['auth']['mobile_no']))){

            if($this->_customer['entity_auth_id'] > 0){
                $auth_model = new SYSEntityAuth();
                $entity_auth = $auth_model->get($this->_customer['entity_auth_id']);

                $entity_auth->mobile_no = $request->checkout_mobile;
                $auth_model->set($this->_customer['entity_auth_id'],(array)$entity_auth);

                if ($request->session()->has('users')) {
                    $request->session()->forget('users');

                    $user = $this->_customer;
                    $user['auth']['mobile_no'] = $entity_auth->mobile_no;
                    $request->session()->push('users', $user);
                }
            }

        }


		$order_helper = new OrderHelper();
		/*$rules  =   [
            'shipping_address'=>'required_without:checkout_first_name,checkout_last_name'	,
            'day'=>'required'
        ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return array(
                    'error' => 1,
                    'message' => $validator->errors()->first()
                );
            }
            else
            {*/
			
			
			/*$first_name					=	$request->input('checkout_first_name') ;
			$last_name					=	$request->input('checkout_last_name') ;
			$phone						=	$request->input('checkout_phone') ;
			$email						=	$request->input('checkout_email') ;
			$street						=	$request->input('street') ;
			$latitude					=	$request->input('latitude') ;
			$longitude					=	$request->input('longitude') ;
			$same						=	$request->input('same') ;
			$shipping_address			=	$request->input('shipping_address') ;*/
			$order_notes				= 	$request->input('order_notes'); 
			$products 					=   $request->input('data'); 
			/*$day 						=   $request->input('day');
			$time 						=   $request->input('time');*/
			$coupon_code				=	$request->input('coupon_code');
			$token 						= 	$request->session()->token();

			//print_r($request->all()); exit;

           /* $delivery_slot_item_flat = new SYSTableFlat('delivery_slot_item');
             $where_condition = 'entity_id = '.$time;
            $delivery_slot_raw = $delivery_slot_item_flat->getDataByWhere($where_condition,array('start_time','end_time'));*/
            //echo "<pre>"; print_r( $delivery_slot_raw);exit;

         /*   if($delivery_slot_raw && isset($delivery_slot_raw[0])){

                $delivery_slot_item = $delivery_slot_raw[0];
                $delivery_slot_start_time = $delivery_slot_item->start_time;
                $delivery_slot_end_time = $delivery_slot_item->end_time;
            }
            else{
                return array(
                    'error' => 1,
                    'message' => 'The delivery slot is required, Go back to select delivery slot'
                );
            }*/


            $general_setting_lib = new GeneralSetting();
            $general_setting = $general_setting_lib->getSetting();

           // $loyalty_points = $general_setting->loyalty_points;
           // $loyalty_amount = $general_setting->loyalty_amount;
           // $delivery_minimum_order = $general_setting->minimum_order;
           // $delivery_charge  = $general_setting->delivery_charge;
			
			
			/*-------------------------------- product verification from Database --------------------- */
			$entity_id  = array();
			$db_product = array();
			foreach ( $products as $productList ) 
			{
				$entity_id[]	=	$productList["entity_id"];

                $product_flat = new SYSTableFlat('product');
                $where_condition = 'entity_id = '.$productList["entity_id"];
                $product_raw = $product_flat->getDataByWhere($where_condition);

                if($product_raw && isset($product_raw[0])){
                    $db_product[] = (array)$product_raw[0];
                }

			}

			if(count($db_product) == 0){
                return array(
                    'error' => 1,
                    'message' => 'The selected items are not available, Please go back to choose other items'
                );
            }
			
			/*-------------------------------- coupon verification from Database --------------------- */


			if($coupon_code>0) {

                $coupon_flat = new SYSTableFlat('coupon');
                $where_condition = 'entity_id = ' . $coupon_code;
                $coupon_raw = $coupon_flat->getDataByWhere($where_condition);

                if ($coupon_raw && isset($coupon_raw[0])) {
                    $coupon = (array)$coupon_raw[0];
                }
                else{
                    return array(
                        'error' => 1,
                        'message' => 'The coupon code does not exist'
                    );
                }

            }
			/*-------------------------------- product verification from Database --------------------- */	
			
		
			
			/*---------------------------------- User Verification ------------------------------*/
		/*	if ($request->session()->has('users'))
				$user = $request->session()->get('users', 'default');
			else
				if(isset($_SESSION['fbUserProfile']))
				{
					$data = array(
								'entity_type_id'	=> "11",
								'name'				=> $_SESSION['fbUserProfile']['name'],
								'first_name'		=> $_SESSION['fbUserProfile']['first_name'],
								'last_name'			=> $_SESSION['fbUserProfile']['last_name'],
								'platform_type'		=> 'facebook',
								'device_type'		=> 'none',
								'platform_id'		=> $_SESSION['fbUserProfile']['id'],
								'email'				=> $_SESSION['fbUserProfile']['email'],
								'status'			=> 1,
								'mobile_json'		=> 1,
						  ); 

					$response = json_encode(CustomHelper::internalCall($request,"api/entity_auth/social_login", 'POST',$data,false));
					$json = json_decode($response,true); 
					$user[0] =	$json['data']['customer'];
	
				}*/
			/*---------------------------------- User Verification ------------------------------*/
				
				
			
				
				
			/*--------------------------------------- Shipping Address -------------------------------------------- */	
	/*		$data = array();
			$data['entity_type_id']    	=   18;
			$data['customer_id']		=	$this->_customerId;
			$data['first_name']			=	$first_name;
			$data['last_name']			=	$last_name;
			$data['phone']				=	$phone;
			$data['email']				=	$email;
			
			$data['postcode']			=	"" ;
			$data['city']			    =	" " ;
			$data['region']				=	"" ;
			$data['company']			=	"" ;
			$data['country']			=	"" ;
			$data['street']				=	$street ;
			$data['telephone']			=	$phone ;
			$data['latitude']			=	"$latitude";
			$data['longitude']			=	"$longitude";
			$data['mobile_json']		=	1;
            $data['login_entity_id']	=	$this->_customerId;

			if($shipping_address=="0")
			{
				//$response = json_encode(CustomHelper::internalCall($request,"api/system/entities", 'POST',$data,false));
                $response = $this->_pLib->apiPost($data);
              //  echo "<pre>"; print_r( $response);exit;

                $json = json_decode(json_encode($response),true);


                if($json['error'] == 1){
                    return array(
                        'error' => 1,
                        'message' => $json['message']
                    );
                }
				$shipping_address =  $json['data']['shipping_address']['entity_id'];

			}*/

			
			/*-------------------------------- order processing --------------------------------------------------- */
			
			$depend_entity = array(); 
			$p=0;$total_items=0;$subtotal=0; $commission_for_rider = 0;$items_qty=0;
			foreach ( $db_product as $product_list ) 
			{
				$depend_entity[$p]['product_id']		=	$product_list["entity_id"];
				$depend_entity[$p]['product_name']		=	$product_list["title"];
				$depend_entity[$p]['product_code']		=	$product_list["product_code"];
				$depend_entity[$p]['price']		=	$product_list["price"];
                $depend_entity[ $p ]['discount_price'] = "0.00";
                $price = $product_list['price'];
                $depend_entity[$p]['item_type']	=   $product_list["item_type"];

                //$depend_entity[$p]['weight'] = $product_list["weight"];
               // $depend_entity[$p]['serving'] = $product_list["serving"];
                //$depend_entity[$p]['product_type'] = $product_list["product_type"];
               // $depend_entity[$p]['item_unit'] = ($product_list["item_unit"] > 0) ? $product_list["item_unit"] : '';
               // $depend_entity[$p]['category_form'] = ($product_list["category_form"] > 0) ? $product_list["category_form"] : '';

				if(isset($product_list['product_promotion_id']) && $product_list['product_promotion_id']>0)
				{
					    if((isset($product_list['promotion_start_date']) && !empty($product_list['promotion_start_date'])) &&
                            (isset($product_list['promotion_end_date']) && !empty($product_list['promotion_end_date']))) {

                            /*if(isset($product_list['promotion_start_date']))
                                $start_date = date("Y-m-d H:i:s",strtotime($product_list['promotion_start_date']));
                            if(isset($product_list['promotion_end_date']))
                                $end_date = date("Y-m-d H:i:s",strtotime($product_list['promotion_end_date'])); */
                            $current_date = date("Y-m-d H:i:s");

                            if (strtotime($current_date) >= strtotime($product_list['promotion_start_date']) &&
                                strtotime($current_date) <= strtotime($product_list['promotion_end_date'])) {

                                if (isset($product_list['promotion_discount_amount'])) {
                                    $price = $product_list['promotion_discount_amount'];
                                    $depend_entity[ $p ]['discount_price'] = $product_list["promotion_discount_amount"];
                                }
                            }

					    }
				}

				$depend_entity[$p]['price']			=	$price;

				foreach ( $products as $productList ) 
				{
					if($productList["entity_id"]==$product_list["entity_id"])
						$depend_entity[$p]['quantity']	=	$productList["product_quantity"];

				}
		 
				$depend_entity[$p]['entity_type_id']    =   16;
				
				$items_qty	 =	$items_qty +  $depend_entity[$p]['quantity']; 
				$subtotal 	 = 	$subtotal  + ($depend_entity[$p]['price'] * $depend_entity[$p]['quantity']);
				//$product_commission = isset($product_list['commission']) ? $product_list['commission'] : 0;

			//	$commission_for_rider = $commission_for_rider+($product_commission*$depend_entity[$p]['quantity']);
				$p++;	
			}


			$subtotal  = round($subtotal,2); 
			$total_items = $p; 
			$data = array(); 
			$data['entity_type_id']			=       15;
			$data['_token']					=		$token;			
			//$data['grand_total']			=		"$grand_total";
			/*-------------------------------- Discount Calculation ------------------------------*/

            $discount_amount			=		0;
            $coupon_discount			=		0;
            $subtotal_with_discount		=		round($subtotal,2);

			if(isset($coupon['coupon_status']))
			{
				if($coupon['coupon_status']==1)
				{
					/*	if(isset($coupon['start_date']))
							$start_date = date("Y-m-d H:i:s",strtotime($coupon['start_date'])); 
						if(isset($coupon['coupon_expiry']))
							$end_date = date("Y-m-d H:i:s",strtotime($coupon['coupon_expiry'])); */
						
						$current_date = date("Y-m-d H:i:s");


                    if((isset($coupon['start_date']) && !empty($coupon['start_date'])) &&
                        (isset($coupon['coupon_expiry']) && !empty($coupon['coupon_expiry']))) {

							if(strtotime($current_date) >= strtotime($coupon['start_date']) && $current_date <= strtotime($coupon['coupon_expiry']) )
							{
								if($subtotal>=$coupon['minimum_order'])
								{
									
									if($coupon['coupon_type']=="percent")
									{
										$coupon_discount				=	$coupon['coupon_discount'];
										$discount_amount 				= 	round((($coupon_discount*$subtotal)/100),2); 
										$subtotal_with_discount			=	round($subtotal - ( ($coupon_discount*$subtotal) /100  ),2);
									}
									if($coupon['coupon_type']== "flat")
									{
										$coupon_discount				=	$coupon['coupon_discount'];
										$discount_amount				=   $coupon_discount; 
										$subtotal_with_discount			=	round(($subtotal - $coupon_discount),2) ;
									}

								}
							}

						}
				}
			}


			/*-------------------------------- Discount Calculation ------------------------------*/
			

			/*if($coupon_discount >0 )
			{
				//$grand_total = $grand_total - $coupon_discount ; // old before wallet 
				if($subtotal_with_discount>=$loyalty_amount)
					$calculated_loyalty_points	= round(( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points,2) ;
				else
					$calculated_loyalty_points  = 0; 
			}
			else
			{
			
				if($subtotal_with_discount>=$loyalty_amount)
					$calculated_loyalty_points	= round(( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points,2) ;
				else
					$calculated_loyalty_points  = 0; 
			}*/

			/*---------------------------------------Delivery Charges Calculation----------------------------------------------*/
			/*if($subtotal_with_discount < $delivery_minimum_order)
			{
				$grand_total                   = round($subtotal_with_discount + $delivery_charge,2) ;
			}
			else 
			{*/
				$grand_total				   = round($subtotal_with_discount,2);
				$delivery_charge			   = 0; 
		//	}
			/*---------------------------------------Delivery Charges  Calculation----------------------------------------------*/
			
			
			/*---------------------------------------------------wallet Calculation-----------------------------------------------*/


            $wallet = 0;
            $pay_from_wallet = 0;
			
			/*$object = new WalletTransaction();
			$wallet =  $object->getCurrentBalance($user[0]['entity_id']);*/

            $customer_flat = new SYSTableFlat('customer');
            $where_condition = 'entity_id = '.$this->_customerId;
            $customer_raw = $customer_flat->getDataByWhere($where_condition,array('wallet','default_wallet_payment'));

            if($customer_raw && isset($customer_raw[0])){
                $customer = $customer_raw[0];
                $wallet = $customer->wallet;
                $pay_from_wallet = $customer->default_wallet_payment;
            }


        if($pay_from_wallet == 1){

            if($wallet >= $grand_total )
            {

                $wallet = round($grand_total,0);
                $paid_amount = 0;
            }

            if($wallet < $grand_total )
            {
                $paid_amount = $grand_total  - $wallet;
                $paid_amount = round($paid_amount,2);
            }
        }
        else{
            $paid_amount = $grand_total;
            $wallet = 0;
        }
			
			/*--------------------------------------------------------------------------------------------------------------------*/


			$order_helper = new OrderHelper();

			$data['subtotal']				= 		"$subtotal";
			$data['discount_amount']		=		"$discount_amount";
			$data['subtotal_with_discount'] =		"$subtotal_with_discount";
			$data['grand_total'] 			=		"$grand_total";
			$data['paid_amount']			= 		"$paid_amount";
            $data['recipient_name']			    = 	"$request->recipient_name";
            $data['recipient_email']			= 	"$request->recipient_email";
            $data['recipient_message']			= 	"$request->recipient_message";

			//$data['commission_for_rider']	=		"$commission_for_rider";
			//$data['items_qty']				=		"$items_qty";
			//$data['total_items']			=		"$total_items";
			$data['customer_id']			=		$this->_customerId;
			//$data['billing_address']	    =		$shipping_address;
			//$data['shipping_address']		=		$shipping_address;
			$data['order_coupon_id']		=		$coupon_code;
			//$data['order_number']			=		$order_helper->createOrderNumber($this->_customerId);
			//$data['user_delivery_date']	    =		date('Y-m-d',strtotime($day . "+1 days"));
			//$data['user_delivery_date']	    =		$day;
			//$data['user_delivery_time']	    =		"$delivery_slot_start_time";
			//$data['user_delivery_time_end']	=		"$delivery_slot_end_time";
			//$data['delivery_slot_time_id']  = 		$time;
			//$data['loyalty_points']	 		= 		"$calculated_loyalty_points";
			$data['order_notes']			= 		"$order_notes";
			$data['wallet']					= 		"$wallet"; 
			//$data['delivery_charge']		= 		"$delivery_charge";
			$data['depend_entity'] 			= 		$depend_entity;
			$data['_lang'] 					= 		"en";
			$data['created_at'] 			= 		date("Y-m-d H:i:s");
			$data['mobile_json']			=		1;
			//$data['entity_type_id']         = 50;

       //   echo "<pre>"; print_r( $data);exit;

           $lead_params = [
                'entity_type_id' 		 => 50,
                'customer_id'			 => $this->_customerId,
                'order_detail'	 		 => json_encode($data) ,
                'mobile_json'			 => 1
            ];

            $response = json_encode($this->_pLib->apiPost($lead_params));
			$json 	  = json_decode($response,true);

            if($json['error'] == 1){
            return array(
                'error' => 1,
                'message' => $json['message']
            );
        }

            $order	  = isset($json["data"]["lead_order"])? $json["data"]["lead_order"] : null;

			if($order !=null ) 
			{
                $payment_config_flat = new SYSTableFlat('payment_config');
                $where_condition = 'payment_code = "stripe"';
                $payment_config_raw = $payment_config_flat->getDataByWhere($where_condition);

                if($payment_config_raw && isset($payment_config_raw[0])){

                    $payment_config = $payment_config_raw[0];

                    $txn_ref			=	$order['transaction_reference'];
                    $product_id			=	"$payment_config->payment_product_id";
                    $pay_item_id		=	"$payment_config->payment_item_id";
                    $amount				=	round($paid_amount*100,0);
                    $currency			=	"566";
                    $site_redirect_url	=	url('/')."/confirmation?entity_id=".$order['entity_id']."&_token=".$token;
                    $cust_id			=	"$payment_config->payment_user";
                    $site_name			=	"iPayCards";
                    $cust_name			=	isset($this->_customer->auth->attributes->first_name) ? $this->_customer->auth->attributes->first_name : '';
                    $mackey 			=	"$payment_config->client_id";
                    $data 				= 	$txn_ref.$product_id.$pay_item_id.$amount.$site_redirect_url.$mackey;
                    $hash 				=	hash('sha512', $data );


                    $data = array();
                    $data['txn_ref']			=	$txn_ref;
                    $data['entity_id']			=	$order['entity_id'];
                    $data['product_id']			=	$product_id;
                    $data['pay_item_id']		=	$pay_item_id;
                    $data['amount']				=	$amount;
                    $data['currency']			=	$currency;
                    $data['site_redirect_url']	=	$site_redirect_url;
                    $data['cust_id']			=	$this->_customerId;
                    $data['site_name']			=	$site_name;
                    $data['cust_name']			=	$cust_name;
                    $data['mackey']				=	$mackey;
                    $data['hash']				=	$hash;

                    return array(
                        'error' =>0,
                        'message' => 'success',
                        'data' => $data
                    );

                    //return $data;

                }
			}
			else 
			{
                return array(
                    'error' =>0,
                    'message' => 'success',
                    'data' => $json
                );
				//return $json;
			}
		
		
			
		//}
	}


	
	public function confirmation(Request $request)
	{
		$entity_lib = new Entity();
		$order_helper = new OrderHelper();
		$rules  =  array('_token' =>  'required');
		$validator = Validator::make($request->all(),$rules);
		if($validator->fails())
		{
			return '';
		}
		else
		{
                $params = array(
                    'entity_type_id' => 'lead_order',
                    'entity_id' => $request->entity_id,
                    'mobile_json' => 1,
                    'in_detail' => 0
                );

                $response =  $this->_pLib->apiList($params);
                $lead_json 	  = json_decode(json_encode($response),true);
              // echo "<pre>"; print_r( $lead_json);exit;

                if($lead_json['error'] == 0 && isset($lead_json['data']['lead_order'][0])) {

                    $lead_order = json_decode($lead_json['data']['lead_order'][0]['order_detail'], TRUE);

                    $data = [];
                    $data = $lead_order;

                    if($request->payment_method == 'master_card'){

                        $payment_lib = new PaymentLib();
                        $payment_response =  $payment_lib->getPaymentStatus(['order_id'=>$request->entity_id],'order');

                       // echo '<pre>'; print_r($payment_response); exit;

                        if(!isset($payment_response->result)){
                            return array(
                                'error' => 1,
                                'message' => "Unable to process request, Please contact to support team"
                            );
                        }

                        if(strtolower($payment_response->result) == 'error'){
                            return array(
                                'error' => 1,
                                'message' => "Unable to get payment status, Please contact to support team",
                               /* 'debug'  => $response->error->explanation*/
                            );
                        }

                        $card = $payment_response->sourceOfFunds->provided->card;

                       // $data['transaction_response'] = json_encode($payment_response);
                        $data['card_id'] = $card->nameOnCard;
                        $data['card_type'] = $card->scheme;
                        $data['card_last_digit'] = substr($card->number,-4);
                        $data['transaction_id'] = $payment_response->transaction[0]->authorizationResponse->transactionIdentifier;

                    }

                    $data['lead_order_id'] = $request->entity_id;
                    $data['order_status'] = 'payment_received';
                    $data['payment_method_type'] = $request->payment_method;
                    $data['login_entity_id'] = $this->_customerId;
                   // $data['order_coupon_id'] = $request->input('order_coupon_id',0);
                    $data['hook'] = 'order_item';
                // echo "<pre>";print_r($data); exit;

                    $ret = $entity_lib->apiPost($data);
                    $json = json_decode(json_encode($ret), TRUE);
                  //  echo "<pre>";print_r($json); exit;

                    if ($json['error'] == 1) {
                        return [
                            'error' => 1,
                            'message' => $json['message'],
                        ];
                    }

                    $confirmation = $json['data']['order'];
                    $data = [];
                    $data['data'] = $confirmation;

                    //enpty Cart
                    if (isset($this->_customerId) && $this->_customerId > 0) {
                        $order_cart_lib = new OrderCart();
                        $order_cart_lib->saveCart($this->_customerId);
                    }

                    return [
                        'error' => 0,
                        'message' => 'Success',
                        'data' => ['order_id' => $data['data']['entity_id']]
                    ];

                    //return View::make('web/checkout3', $data);
                }
                else{

                    return array(
                        'error' => 1,
                        'message' => $lead_json['message']
                    );

                }

        }
    }


    public function checkoutOrder(Request $request)
    {

        //echo "<pre>"; print_r($request->all()); exit;
        $order_notes				= 	$request->input('order_notes');
        $products 					=   $request->input('data');
        $coupon_code				=	$request->input('coupon_code');
      //  $token 						= 	$request->session()->token();

        if(isset($request->is_gift_card)){
            if($request->is_gift_card == 1){


                if($request->recipient_name == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient Name is required'
                    );
                }

                if($request->recipient_email == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient Email is required'
                    );
                }
                if($request->recipient_message == ''){
                    return array(
                        'error' => 1,
                        'message' => 'Recipient messsage is required'
                    );
                }

            }
        }

        if($request->auth_platform_type == 'facebook' && empty($request->checkout_mobile)) {

            return array(
                'error' => 1,
                'message' => 'The contact number is required to process order'
            );
        }

        if(($request->auth_platform_type == 'facebook' && !empty($request->checkout_mobile)) && (isset($this->_customer['auth']['mobile_no']) && empty($this->_customer['auth']['mobile_no']))){

            if($this->_customer['entity_auth_id'] > 0){
                $auth_model = new SYSEntityAuth();
                $entity_auth = $auth_model->get($this->_customer['entity_auth_id']);

                $entity_auth->mobile_no = $request->checkout_mobile;
                $auth_model->set($this->_customer['entity_auth_id'],(array)$entity_auth);

                if ($request->session()->has('users')) {
                    $request->session()->forget('users');

                    $user = $this->_customer;
                    $user['auth']['mobile_no'] = $entity_auth->mobile_no;
                    $request->session()->push('users', $user);
                }
            }

        }


        /*-------------------------------- product verification from Database --------------------- */
        $entity_id  = array();
        $db_product = array();
        foreach ( $products as $productList )
        {
            $entity_id[]	=	$productList["entity_id"];

            $product_flat = new SYSTableFlat('product');
            $where_condition = 'entity_id = '.$productList["entity_id"];
            $product_raw = $product_flat->getDataByWhere($where_condition);

            if($product_raw && isset($product_raw[0])){
                $db_product[] = (array)$product_raw[0];
            }

        }

        if(count($db_product) == 0){
            return array(
                'error' => 1,
                'message' => 'The selected items are not available, Please go back to choose other items'
            );
        }

        /*-------------------------------- coupon verification from Database --------------------- */


        if($coupon_code>0) {

            $coupon_flat = new SYSTableFlat('coupon');
            $where_condition = 'entity_id = ' . $coupon_code;
            $coupon_raw = $coupon_flat->getDataByWhere($where_condition);

            if ($coupon_raw && isset($coupon_raw[0])) {
                $coupon = (array)$coupon_raw[0];
            }
            else{
                return array(
                    'error' => 1,
                    'message' => 'The coupon code does not exist'
                );
            }

        }

        /*-------------------------------- order processing --------------------------------------------------- */

        $depend_entity = array();
        $p=0;$total_items=0;$subtotal=0; $commission_for_rider = 0;$items_qty=0;
        foreach ( $db_product as $product_list )
        {
            $depend_entity[$p]['product_id']		=	$product_list["entity_id"];
            $depend_entity[$p]['product_name']		=	$product_list["title"];
            $depend_entity[$p]['product_code']		=	$product_list["product_code"];
            $depend_entity[$p]['price']		=	$product_list["price"];
            $depend_entity[ $p ]['discount_price'] = "0.00";
            $price = $product_list['price'];
            $depend_entity[$p]['item_type']	=   $product_list["item_type"];

            //$depend_entity[$p]['weight'] = $product_list["weight"];
            // $depend_entity[$p]['serving'] = $product_list["serving"];
            //$depend_entity[$p]['product_type'] = $product_list["product_type"];
            // $depend_entity[$p]['item_unit'] = ($product_list["item_unit"] > 0) ? $product_list["item_unit"] : '';
            // $depend_entity[$p]['category_form'] = ($product_list["category_form"] > 0) ? $product_list["category_form"] : '';

            if(isset($product_list['product_promotion_id']) && $product_list['product_promotion_id']>0)
            {
                if((isset($product_list['promotion_start_date']) && !empty($product_list['promotion_start_date'])) &&
                    (isset($product_list['promotion_end_date']) && !empty($product_list['promotion_end_date']))) {

                    /*if(isset($product_list['promotion_start_date']))
                        $start_date = date("Y-m-d H:i:s",strtotime($product_list['promotion_start_date']));
                    if(isset($product_list['promotion_end_date']))
                        $end_date = date("Y-m-d H:i:s",strtotime($product_list['promotion_end_date'])); */
                    $current_date = date("Y-m-d H:i:s");

                    if (strtotime($current_date) >= strtotime($product_list['promotion_start_date']) &&
                        strtotime($current_date) <= strtotime($product_list['promotion_end_date'])) {

                        if (isset($product_list['promotion_discount_amount'])) {
                            $price = $product_list['promotion_discount_amount'];
                            $depend_entity[ $p ]['discount_price'] = $product_list["promotion_discount_amount"];
                        }
                    }

                }
            }

            $depend_entity[$p]['price']			=	$price;

            foreach ( $products as $productList )
            {
                if($productList["entity_id"]==$product_list["entity_id"])
                    $depend_entity[$p]['quantity']	=	$productList["product_quantity"];

            }

            $depend_entity[$p]['entity_type_id']    =   16;

            $items_qty	 =	$items_qty +  $depend_entity[$p]['quantity'];
            $subtotal 	 = 	$subtotal  + ($depend_entity[$p]['price'] * $depend_entity[$p]['quantity']);
            //$product_commission = isset($product_list['commission']) ? $product_list['commission'] : 0;

            //	$commission_for_rider = $commission_for_rider+($product_commission*$depend_entity[$p]['quantity']);
            $p++;
        }


        $subtotal  = round($subtotal,2);
        $total_items = $p;
        $data = array();
        $data['entity_type_id']			=       15;
        //$data['_token']					=		$token;
        //$data['grand_total']			=		"$grand_total";
        /*-------------------------------- Discount Calculation ------------------------------*/

        $discount_amount			=		0;
        $coupon_discount			=		0;
        $subtotal_with_discount		=		round($subtotal,2);

        if(isset($coupon['coupon_status']))
        {
            if($coupon['coupon_status']==1)
            {
                /*	if(isset($coupon['start_date']))
                        $start_date = date("Y-m-d H:i:s",strtotime($coupon['start_date']));
                    if(isset($coupon['coupon_expiry']))
                        $end_date = date("Y-m-d H:i:s",strtotime($coupon['coupon_expiry'])); */

                $current_date = date("Y-m-d H:i:s");


                if((isset($coupon['start_date']) && !empty($coupon['start_date'])) &&
                    (isset($coupon['coupon_expiry']) && !empty($coupon['coupon_expiry']))) {

                    if(strtotime($current_date) >= strtotime($coupon['start_date']) && $current_date <= strtotime($coupon['coupon_expiry']) )
                    {
                        if($subtotal>=$coupon['minimum_order'])
                        {

                            if($coupon['coupon_type']=="percent")
                            {
                                $coupon_discount				=	$coupon['coupon_discount'];
                                $discount_amount 				= 	round((($coupon_discount*$subtotal)/100),2);
                                $subtotal_with_discount			=	round($subtotal - ( ($coupon_discount*$subtotal) /100  ),2);
                            }
                            if($coupon['coupon_type']== "flat")
                            {
                                $coupon_discount				=	$coupon['coupon_discount'];
                                $discount_amount				=   $coupon_discount;
                                $subtotal_with_discount			=	round(($subtotal - $coupon_discount),2) ;
                            }

                        }
                    }

                }
            }
        }


        /*-------------------------------- Discount Calculation ------------------------------*/


        /*if($coupon_discount >0 )
        {
            //$grand_total = $grand_total - $coupon_discount ; // old before wallet
            if($subtotal_with_discount>=$loyalty_amount)
                $calculated_loyalty_points	= round(( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points,2) ;
            else
                $calculated_loyalty_points  = 0;
        }
        else
        {

            if($subtotal_with_discount>=$loyalty_amount)
                $calculated_loyalty_points	= round(( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points,2) ;
            else
                $calculated_loyalty_points  = 0;
        }*/

        /*---------------------------------------Delivery Charges Calculation----------------------------------------------*/
        /*if($subtotal_with_discount < $delivery_minimum_order)
        {
            $grand_total                   = round($subtotal_with_discount + $delivery_charge,2) ;
        }
        else
        {*/
        $grand_total				   = round($subtotal_with_discount,2);
        $delivery_charge			   = 0;
        //	}
        /*---------------------------------------Delivery Charges  Calculation----------------------------------------------*/


        /*---------------------------------------------------wallet Calculation-----------------------------------------------*/


        $wallet = 0;
        $pay_from_wallet = 0;

        /*$object = new WalletTransaction();
        $wallet =  $object->getCurrentBalance($user[0]['entity_id']);*/

        $customer_flat = new SYSTableFlat('customer');
        $where_condition = 'entity_id = '.$this->_customerId;
        $customer_raw = $customer_flat->getDataByWhere($where_condition,array('wallet','default_wallet_payment'));

        if($customer_raw && isset($customer_raw[0])){
            $customer = $customer_raw[0];
            $wallet = $customer->wallet;
            $pay_from_wallet = $customer->default_wallet_payment;
        }

        /*  if($pay_from_wallet == 1){

              if($wallet >= $grand_total )
              {

                  $wallet = round($grand_total,0);
                  $paid_amount = 0;
              }

              if($wallet < $grand_total )
              {
                  $paid_amount = $grand_total  - $wallet;
                  $paid_amount = round($paid_amount,2);
              }
          }
          else{
              $paid_amount = $grand_total;
              $wallet = 0;
          }*/

        if($wallet >= $grand_total )
        {

            $wallet = round($grand_total,0);
            $paid_amount = 0;
        }

        if($wallet < $grand_total )
        {
            $paid_amount = $grand_total  - $wallet;
            $paid_amount = round($paid_amount,2);
        }

        /*--------------------------------------------------------------------------------------------------------------------*/


        $order_helper = new OrderHelper();

        $data['subtotal']				= 		"$subtotal";
        $data['discount_amount']		=		"$discount_amount";
        $data['subtotal_with_discount'] =		"$subtotal_with_discount";
        $data['grand_total'] 			=		"$grand_total";
        $data['paid_amount']			= 		"$paid_amount";
        $data['recipient_name']			    = 	"$request->recipient_name";
        $data['recipient_email']			= 	"$request->recipient_email";
        $data['recipient_message']			= 	"$request->recipient_message";

        //$data['commission_for_rider']	=		"$commission_for_rider";
        //$data['items_qty']				=		"$items_qty";
        //$data['total_items']			=		"$total_items";
        $data['customer_id']			=		$this->_customerId;
        //$data['billing_address']	    =		$shipping_address;
        //$data['shipping_address']		=		$shipping_address;
        $data['order_coupon_id']		=		$coupon_code;
        //$data['order_number']			=		$order_helper->createOrderNumber($this->_customerId);
        //$data['user_delivery_date']	    =		date('Y-m-d',strtotime($day . "+1 days"));
        //$data['user_delivery_date']	    =		$day;
        //$data['user_delivery_time']	    =		"$delivery_slot_start_time";
        //$data['user_delivery_time_end']	=		"$delivery_slot_end_time";
        //$data['delivery_slot_time_id']  = 		$time;
        //$data['loyalty_points']	 		= 		"$calculated_loyalty_points";
        $data['order_notes']			= 		"$order_notes";
        $data['wallet']					= 		"$wallet";
        //$data['delivery_charge']		= 		"$delivery_charge";
        $data['depend_entity'] 			= 		$depend_entity;
        $data['order_status'] 			= 		"pending";
       // $data['_lang'] 					= 		"en";
     //   $data['created_at'] 			= 		date("Y-m-d H:i:s");
        $data['mobile_json']			=		1;
        //$data['entity_type_id']         = 50;

        //   echo "<pre>"; print_r( $data);exit;

        /*$lead_params = [
            'entity_type_id' 		 => 50,
            'customer_id'			 => $this->_customerId,
            'order_detail'	 		 => json_encode($data) ,
            'mobile_json'			 => 1
        ];*/

        echo "<pre>"; print_r( $data);
        $response = json_encode($this->_pLib->apiPost($data));
        $json 	  = json_decode($response,true);

        if($json['error'] == 1){
            return array(
                'error' => 1,
                'message' => $json["message"]
            );
        }

        echo "<pre>"; print_r( $json);exit;




    }
}
