<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Models\FlatTable;
use App\Http\Models\SYSCategory;
use App\Http\Models\SYSTableFlat;
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



class ProductController extends WebController
{
	/**
     * Global Private variable of this file.It has object of Customer wallet Transaction Helper
     * 
     * @access private
     * @var Object
     */
	private $_customer_wallet; 
	
	
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
     * Sets the $_customer_wallet with wallet Transaction Helper object and 
	 * Sets the $_object_library_entity with Entity Library object 
     *
     * @param Sets the $_customer_wallet with wallet Transaction Helper object.
     * @return _customer_wallet and _object_library_entity
	 * @access public

     */ 
	 
	public function __construct(Request $request)
    {
        parent::__construct($request);
		$this->_customer_wallet = new WalletTransaction();
		$this->_object_library_entity = new Entity();
		$this->_object_library_general_setting = new GeneralSetting();
		
	}
	
	public function getAllProducts(Request $request)
	{

		$validator 	= 	Validator::make(
							$request->all(),
							[
								'offset'	=>  'required'	,	
								'limit' =>  'required'
							]
						);
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
							
							
			
			$limit = $request->input('limit'); 
			$product_detail_url = $request->input('product_detail_url');
			
			
			$data = [
								'entity_type_id'	=>	'product',
								//'product_type'		=>	1,
								'category_id'		=>	$request->input('category_id'),
							//	'category_form'		=>	$request->input('category_form'),
								'searchable_tags'	=>	$request->input('searchable_tags'),
                                'brand_id'	=>	$request->input('brand_id'),
								'range_fields'		=>	'price',
                                'status'            => 1,
                               // 'availability' => 1,
								'offset'			=>	$request->input('offset'),
								'limit'				=>	$limit,
                                'order_by'          => 'entity_id',
                                'sorting'           => 'DESC'
							];
		
			if(	($request->has('low_price') && $request->has('high_price')) && ($request->low_price > 0 &&  $request->high_price > 0)) {
                $data['price'] = $request->input('low_price') . ',' . $request->input('high_price');
            }

				
			//print_r($data);
			$json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($data)),true);
        //   echo "<pre>"; print_r($json); exit;
		//	print_r($json); exit;
			$data['products'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			$data['product_detail_url'] = $product_detail_url; 
			$data = [
						'products'	=> View::make('web/includes/product/product_list',$data)->__toString(),
						'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
					];
			return $data;
		}
	}
	
	public function getAllPromotionProducts(Request $request) 
	{
		
		$validator 	= 	Validator::make(
							$request->all(),
							[
								'entity_type_id'			 =>  'required'		,			
								'product_promotion_id'		  =>  'required'
							]
						);
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
		
							
			$data['product_detail_url'] = $request->input('product_detail_url');
			$limit  = 	$request->input('limit'); 
		/*	$json 	= 	json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing', 
									'GET',
									[
										'entity_type_id'		=>		14,
										'product_promotion_id'	=>		$request->input('product_promotion_id')	,
										'offset'				=>		$request->input('offset'),
										'limit'					=>		$limit
									],
									false
								)
							),
							true
						);*/
            $params = [
                'entity_type_id'		=>		'product',
                'product_promotion_id'	=>		$request->input('product_promotion_id')	,
               'status'            => 1,
             //  'availability' => 1,
                'offset'				=>		$request->input('offset'),
                'limit'					=>		$limit,
                'order_by'          => 'entity_id',
                'sorting'           => 'DESC'
            ];

            $json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($params)),true);
			$data['products'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			
			
			$data1 = [
						'products'	=> View::make('web/includes/product/product_list',$data)->__toString(),
						'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
					];
					
			return $data1; 
		}
	}
	
	public function getAllFeatureProducts(Request $request) 
	{
		
		$validator 	= 	Validator::make(
							$request->all(),
							[
								'entity_type_id'	 =>  'required'		,			
								"featured_type"		 =>  'required'	
							]
						);
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
							
			$data['product_detail_url'] = $request->input('product_detail_url');
			$limit = $request->input('limit'); 
			
		/*	$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing', 
								'GET',
								[
									'entity_type_id'		=>		'product',
									'featured_type'			=>		$request->input('featured_type')	,
									//'category_form'			=>		'1'							  	,
									//'perishable'			=>		$request->input('perishable'),
                                    'status'                => 1,
                                    'availability'          => 1,
									'offset'				=>		$request->input('offset')	,
									'limit'					=>		$limit	
								],
								false
							)
						),
						true
					);*/

			$params = 	[
                'entity_type_id'		=>		'product',
                'featured_type'			=>		$request->input('featured_type')	,
                //'category_form'			=>		'1'							  	,
                //'perishable'			=>		$request->input('perishable'),
                'status'                => 1,
              //  'availability'          => 1,
                'offset'				=>		$request->input('offset')	,
                'limit'					=>		$limit,
                'order_by'          => 'entity_id',
                'sorting'           => 'DESC'
            ];
            $json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($params)),true);
			$data['products'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			
			$data1 = [
						'products'	=> View::make('web/includes/product/product_list',$data)->__toString(),
						'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
					];
					
			return $data1;
		}
	}
	
	public function getAllRecipes(Request $request) 
	{
		$rules  =  array(	
							'category_id'		 =>  'required'				,	
							'product_detail_url' =>  'required'				,
							
						); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array("entity_type_id"=>14,"category_id"=>$request->input('category_id')); 
			$data['product_detail_url'] = $request->input('product_detail_url');
			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$json = json_decode($response,true); 
			$data['recipe'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			return View::make('web/includes/recipe/recipe_list',$data)->__toString();
		}
	}
	
	public function getAllProductsByTitle(Request $request) 
	{
		$rules  =  array(	
							'title'		 		 =>  'required'			    ,	
							'product_detail_url' =>  'required'				
							
						); 
		$validator = Validator::make($request->all(),$rules);		
		
		
		if($validator->fails())
		{
			return trans('web.NoRecordError');
		}
		else 
		{	 
			$data = array("entity_type_id"=>14,
                "title"=>$request->input('title')
            );

			$data['product_detail_url'] = $request->input('product_detail_url');
            $limit = $request->input('limit');
            /*	$json = json_decode(
                            json_encode(
                                CustomHelper::internalCall(
                                    $request,
                                    'api/system/entities/listing',
                                    'GET',
                                    [
                                        'entity_type_id'=>14,
                                        'title'=>$request->input('title')
                                    ],
                                    false
                                )
                            ),
                            true
                        );*/

           // $limit = $request->input('limit');
            $params = [
                'entity_type_id'=>14,
                'title'=>$request->input('title'),
                'status'                => 1,
              //  'availability'          => 1,
                'offset'				=>		$request->input('offset')	,
               'limit'					=>		$limit,
                'order_by'          => 'entity_id',
                'sorting'           => 'DESC'
            ];

            $json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($params)),true);
			$data['products'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			//return View::make('web/includes/product/product_list',$data)->__toString();

            $data1 = [
                'products'	=> View::make('web/includes/product/product_list',$data)->__toString(),
                'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
            ];

            return $data1;

        }
	}
	
	public function getProductByCode(Request $request) 
	{		
		$rules  =  array(	
							'entity_type_id'	 =>	 'required'				,	
							'product_code'	     =>	 'required'				
						); 
		$validator = Validator::make($request->all(),$rules);	
		if($validator->fails())
		{
			return View::make('web/product_detail');
		}
		else 
		{	
			$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing', 
								'GET',
								[
									'entity_type_id'=>14,
									'product_code'=>$request->input('product_code')
									
								],
								true
							)
						),
						true
					);
				
					$post_param = $request->all();
					$request->request->remove('product_code');
					$post_param = $request->all();
					$request->replace($post_param);
					
						$json2 = json_decode(
									json_encode(
										CustomHelper::internalCall(
											$request,
											'api/system/category/listing', 
											'GET', 
											['limit'=>1000],
											true
										)
									),
									true
								);
								
					
					  /*---------------------------------- User Verification ------------------------------*/

						/*---------------------------------- User Verification ------------------------------*/
						$data = [];
						$data['wishlist']=0;
					    $data['product'] =  isset($json["data"]['entity_listing'][0]) ? $json["data"]["entity_listing"][0] : null ;
							
						if($this->_customerId!='')
						{
										$data_tmp = array(); 
										$data_tmp['actor_entity_id'] 			= $this->_customerId;
										$data_tmp['target_entity_type_id']		= 14;
										$data_tmp['actor_entity_type_id']		= 11;
										$data_tmp['type']					= "private";
										$data_tmp['mobile_json']	= 1;
										
										$response = json_encode(CustomHelper::internalCall($request,"api/extension/social/package/like/listing", 'GET',$data_tmp,false));
										$json_tmp 	  = json_decode($response,true);
										
										$wishlist = isset($json_tmp['data']['like_listing']) ? $json_tmp['data']['like_listing'] : [] ;
										
										$data1 = array(); 
										$p=0;
							  foreach( $wishlist as $wishlist_attribute  ) 
							  {
								
									
								$data1[$p]['entity_id'] 			= isset($wishlist_attribute['product']['entity_id']) ? $wishlist_attribute['product']['entity_id'] : null;
								$data1[$p]['wishlist_entity_id'] = isset($wishlist_attribute['package_like_id']) ? $wishlist_attribute['package_like_id'] : null;
								$data1[$p]['thumb'] 				= isset($wishlist_attribute['product']['gallery'][0]['thumb'])?  $wishlist_attribute['product']['gallery'][0]['thumb'] : null ;
								$data1[$p]['title'] 				= isset($wishlist_attribute['product']['title']) ? $wishlist_attribute['product']['title'] : null;
								$data1[$p]['product_code'] 		= isset($wishlist_attribute['product']['product_code']) ? $wishlist_attribute['product']['product_code'] : null;
								$data1[$p]['price'] 				= isset($wishlist_attribute['product']['price']) ? $wishlist_attribute['product']['price'] : null;
                                  $data1[$p]['item_type'] 				= isset($wishlist_attribute['product']['item_type']['value']) ? $wishlist_attribute['product']['item_type']['value'] : null;
								/*$data1[$p]['weight'] 			= isset($wishlist_attribute['product']['weight']) ? $wishlist_attribute['product']['weight'] : null;
								$data1[$p]['unit_value'] 		= isset($wishlist_attribute['product']['item_unit']['value']) ? $wishlist_attribute['product']['item_unit']['value'] : null;
								$data1[$p]['unit_option'] 		= isset($wishlist_attribute['product']['item_unit']['option']) ? $wishlist_attribute['product']['item_unit']['option']: null;	 
								*/
								if($data1[$p]['entity_id'] == $data['product']['entity_id'] )
									$data['wishlist'] = 1; 
								
								$p++;
							 }
						}
				
			
			$data['categories_all'] =  isset($json2["data"]['category_listing']) ? $json2["data"]["category_listing"]: null ;
			
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			return View::make('web/product_detail',$data);
		}
    }
	
	public function getAllProduct(Request $request) 
	{
        $data['cat_id'] = isset($request->category_id) ? $request->category_id : '';

        if(isset($request->category_id)){
            $sys_category = new SYSCategory();
            $category_raw =  $sys_category->get($request->category_id);

            if($category_raw->is_parent == 1){
                $categories = $sys_category->getData($request->category_id);
                if(isset($categories->child) && count($categories->child)){
                    $data['cat_id'] = $categories->child[0]->category_id;
                }
            }
            else{
                $categories = $sys_category->getData($category_raw->parent_id);
            }
           // echo "<pre>"; print_r($categories); exit;
        }

        $data['categories'] = isset($categories) ? $categories : [];
        $data['category'] = isset($category_raw) ? $category_raw : false;


		$data['request']['entity_type_id']  = $request["entity_type_id"];
		$data['request']['category_id'] 	= $request["category_id"];

		//Get Promotion Title
        if(isset($request->product_promotion_id)){
            if($request->product_promotion_id > 0){
                $flat_table_model = new SYSTableFlat('promotion_discount');
                $where = ' entity_id = '.$request->product_promotion_id;
                $promotion = $flat_table_model->getDataByWhere($where,['title']);
                $data['list_heading'] = $promotion[0]->title;

            }
        }

		$json1 = json_decode(
					json_encode(
						CustomHelper::internalCall(
							$request,
							'api/system/category/listing', 
							'GET', 
							['limit'=>1000],
							true
						)
					),
					true
				);
		

		$json2 = json_decode(
					json_encode(
						$this->_object_library_entity->apiList(
							[
								'entity_type_id'=>41, 
								'mobile_json'=>1, 
								'limit'=>1000,
								'entity_id'=> ''
							]
						)
					),
					true
				);
		//echo "<pre>"; print_r($json2); exit;

		$post_param = $request->all();
		$request->request->remove('category_id');
		$post_param = $request->all();
		$request->replace($post_param);
		
		$json3 = json_decode(
					json_encode(
						CustomHelper::internalCall(
							$request,
							'api/system/category/listing', 
							'GET', 
							['limit'=>1000],
							true
						)
					),
					true
				);
      // echo "<pre>"; print_r($json3); exit;





       // $data['categories'] = isset($json1['data']['category_listing']) ? $json1['data']['category_listing'] : null;
		$data['category_id'] = isset($json2['data']['product_tags'][0]['category_id']) ?  $json2['data']['product_tags'][0]['category_id'] : null;
		$data['categories_all'] = isset($json3['data']['category_listing_listing']) ? $json3['data']['category_listing_listing'] : null;
		$data['price'] = isset($json2['data']['product_tags'][0]['price']) ?  $json2['data']['product_tags'][0]['price'] : 0;
		$data['searchable_tags'] = isset($json2['data']['product_tags'][0]['searchable_tags']) ?  $json2['data']['product_tags'][0]['searchable_tags'] : null;
		//$data['product_form'] = isset($json2['data']['product_tags'][0]['product_form']) ?  $json2['data']['product_tags'][0]['product_form'] : null;
        $data['brand_ids'] = isset($json2['data']['product_tags'][0]['brand_ids']) ?  $json2['data']['product_tags'][0]['brand_ids'] : null;

        if($data['price'] > 0){
            $data['price'] = round($data['price']);
        }
        $data['currency'] = $this->_object_library_general_setting->getCurrency();

        if(isset($request->brand_id)){
            $flat_table = new SYSTableFlat('brand');
            $raw = $flat_table->getDataByWhere(' entity_id = '.$request->brand_id,array('title'));
            $data['brand'] = $raw[0];
        }
        //echo "<pre>"; print_r($data); exit;
		return View::make('web/product',$data);
       
    }
	
	public function showCart(Request $request) 
	{
		$rules  =  array(	'data' =>  'required'		); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data['products'] = $request->input('data');

            if($data['products'] && count($data['products']) > 0){

                $available_products = array();
                $not_available_products = '';

                foreach($data['products'] as $cart_product){

                    $product_flat = new SYSTableFlat('product');
                    $where_condition = 'entity_id = '.$cart_product['entity_id'];
                    $product_raw = $product_flat->getDataByWhere($where_condition,array('status'));
                   // echo "<pre>"; print_r($product_raw); exit;
                    if($product_raw && isset($product_raw[0])){

                        $product = $product_raw[0];
                        if($product->status == 1){

                            $available_products[] = $cart_product;
                        }
                        else{
                            if($not_available_products != ''){
                                $not_available_products .= ', ';
                            }
                            $not_available_products .= $cart_product['title'];
                        }
                    }

                }
            }

            $data['message'] = '';
            if(count( $data['products']) > count($available_products)){
                $data['message'] = $not_available_products.' currently not available';
            }

            $data['products'] = count($available_products)>0 ? $available_products : array();
			$data['currency'] = $this->_object_library_general_setting->getCurrency();

            $view_file = 'web/includes/product/show_list';
            $view =  view($view_file,$data)->render();

            return array(
                'products' => $available_products,
                'view' => $view,
                'total_count' => count($available_products)
            );

		}
		
    }
	
	public function totalPrice(Request $request) 
	{
		$rules  =  array( 'data'  =>  'required'  ); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return '';
		}
		else
		{
			
			$discount_amount = $request->input('discount'); 
			$product = $request->input('data');
			
			

		   /*---------------------------------- User Verification ------------------------------*/

			/*---------------------------------- User Verification ------------------------------*/
			
			
			$subtotal=0;$total_cart_products=0; $order_cart = array();
			if(isset($product))
				foreach ( $product  as $productAtrributes ) 
				{
                    if(isset($productAtrributes['price']))
                    $subtotal = $subtotal + ($productAtrributes['product_quantity'] * $productAtrributes['price'] );
					$total_cart_products++;

                    $order_cart[] = array(
                        'product_id' => $productAtrributes['entity_id'],
                        'quantity' => $productAtrributes['product_quantity'],
                    );
				}

				//Save Cart
           if (isset($this->_customerId) && $this->_customerId > 0){
			    $order_cart_lib = new OrderCart();
                $order_cart_lib->saveCart($this->_customerId,json_encode($order_cart));
            }
			

				/*--------------------------------- Total After Subtraction of Delivery Charges  ------------------------------------*/
		/*	$data = array();
			$data['entity_type_id'] = 25;
			$data['mobile_json']	= 1;
			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$json 	  = json_decode($response,true);*/

            $general_setting_lib = new GeneralSetting();
            $general_setting = $general_setting_lib->getSetting();

			//$loyalty_points = $general_setting->loyalty_points;
			//$loyalty_amount = $general_setting->loyalty_amount;
			//$delivery_minimum_order = $general_setting->minimum_order;
			//$delivery_charge  = $general_setting->delivery_charge;
            $delivery_charge = 0;
			
			
			
			/*--------------------------------- Initial Product Price total ------------------------------------*/
			$subtotal = round($subtotal,2); 
			
			
			/*--------------------------------- Total after subtraction of coupons discount ------------------------------------*/
			$subtotal_with_discount 		= round($subtotal- $discount_amount,2);
			
			
			
			
			
			/*--------------------------------- Loyalty point calculation ------------------------------------*/
			

			/*if($subtotal_with_discount>=$loyalty_amount)
			{
				$calculated_loyalty_points = ( $subtotal_with_discount / $loyalty_amount ) * $loyalty_points; 
				$calculated_loyalty_points	= round($calculated_loyalty_points,2) ;
			}
			else
			{*/
				$calculated_loyalty_points  = 0; 
			//}

			
			/*if(  $subtotal_with_discount >= $delivery_minimum_order )
			{
				$grand_total = round(($subtotal_with_discount+$delivery_charge),2);
			}
			else 
			{*/
				$delivery_charge = 0; 
				$grand_total= round($subtotal_with_discount,2); 
				
		//	}
			
			
			
			/*--------------------------------- Total After Subtraction of Delivery Charges  ------------------------------------*/
			
			
			/*---------------------------------------------------wallet Calculation-----------------------------------------------*/

            $customer_wallet = 0;
            $pay_from_wallet = 0;

            if(isset($this->_customerId))
			{
				/*$object = new WalletTransaction();
				$customer_wallet =  $object->getCurrentBalance($user[0]['entity_id']);*/

                $customer_flat = new SYSTableFlat('customer');
                $where_condition = 'entity_id = '.$this->_customerId;
                $customer_raw = $customer_flat->getDataByWhere($where_condition,array('wallet','default_wallet_payment'));

                if($customer_raw && isset($customer_raw[0])){
                    $customer = $customer_raw[0];
                    $customer_wallet = $customer->wallet;
                    $pay_from_wallet = $customer->default_wallet_payment;
                }

			}


			if($pay_from_wallet == 1){

                if($customer_wallet >= $grand_total )
                {
                    $paid_amount = 0;
                    $customer_wallet = $grand_total;
                }
                if($grand_total > $customer_wallet )
                {
                    $paid_amount = $grand_total  - $customer_wallet;
                    $paid_amount = round($paid_amount,2);
                }

            }
            else{
                $paid_amount = $grand_total;
                $customer_wallet = 0;
            }

			
			
			//$paid_amount = round(floatval( ($grand_total -  $customer_wallet)),2);
			
			/*---------------------------------------------------wallet Calculation-----------------------------------------------*/

			
			
			$data1['total_cart_products'] = $total_cart_products;
			
			$data1['subtotal'] = $subtotal; 
			$data1['discount_amount'] = $discount_amount; 
			$data1['subtotal_with_discount'] = $subtotal_with_discount;
			$data1['delivery_charge'] = $delivery_charge; 
			$data1['grand_total'] = $grand_total;
			$data1['customer_wallet'] = ($customer_wallet > 0) ? $customer_wallet : '0.00';
			$data1['calculated_loyalty_points']	 = $calculated_loyalty_points;
			$data1['paid_amount'] = $paid_amount;
			$data1['currency'] = $this->_object_library_general_setting->getCurrency();

			return $data1;
		}
		
       
    }

	public function saveOrder(Request $request) 
	{
		$depend_entity = array(); 	
		$rules  =  array(	'data' =>  'required'		); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return '';
		}
		else 
		{		
			$sum=0;$p=0;$grand_total=0;$total_items=0;
			foreach ( $request->input('data') as $productList ) 
			{
				$product_quantity = $productList["product_quantity"]; 
				$depend_entity[$p]['order_id']		=	'1';
				$depend_entity[$p]['row_total']		=	(int)$productList["price"] * $productList["product_quantity"] ; 
				$depend_entity[$p]['customer_id']	=	'45';
				$depend_entity[$p]['product_id']	=	$productList["product_id"];
				$depend_entity[$p]['product_code']	=	$productList["product_code"];
				$depend_entity[$p]['title']			=	$productList["title"];
				$depend_entity[$p]['price']	= $productList["price"];
                $depend_entity[$p]['item_type']	=	$productList["item_type"];
				$grand_total  = $grand_total + $depend_entity[$p]['row_total'];
				$total_items  = $total_items + $product_quantity;
				$p++;	
			}

			$data = array();
			$data['entity_type_id']			=       15;
			$data['_token']					=		$request->session()->token();
			$data['grand_total']			=		"$grand_total";
			$data['discount_amount'] 		=		"0";
			$data['subtotal_with_discount'] =		"0";
			$data['tax_amount']				=		"0";
			$data['items_qty']				=		"$p";
			$data['total_items']			=	    "$total_items";
			$data['customer_id']			=		"1";
			$data['depend_entity'] 			= 		$depend_entity;
			
			
			
			
			//print_r($data); 
			 
			
			$response = CustomHelper::internalCall($request,"api/system/entities", 'POST', $data,false);
			//print_r($response);
		}
		
    }
	
	public function addToCart(Request $request) 
	{
		$rules  =  array(	'data' =>  'required'		); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return '';
		}
		else 
		{		
			$data['products'] = $request->input('data'); 	
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			return  View::make('web/includes/product/cart_list',$data)->__toString();
		}  
    }
    public function _addToCart(Request $request)
    {
        $rules  =  array(	'data' =>  'required'		);
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return '';
        }
        else
        {
            $order_cart = [];
            $requested_products = [];
            $final_cart = [];
            $product = $request->input('data');


            if (isset($product)){

                foreach($product as $p){
                    $entity_ids[] = $p['entity_id'];
                    $requested_products[$p['entity_id']] = $p['product_quantity'];

                }

                $product_ids = implode(',',$entity_ids);

                $params = array(
                    'entity_type_id' => 'product',
                    'entity_id' => $product_ids,
                    'mobile_json' => 1,
                    'in_detail' => 1,
                    'limit' => -1
                );

                $response = $this->_object_library_entity->apiList($params);
                $response = json_decode(json_encode($response));

                // echo "<pre>"; print_r($response); exit;
                if($response->error == 0 && isset($response->data->product)){

                    foreach($response->data->product as $productAtrributes){

                        if ($productAtrributes->status->value == 1) {

                            if(!empty($productAtrributes->promotion_discount_amount)){
                                $price = $productAtrributes->promotion_discount_amount;
                            }else{
                                $price = $productAtrributes->price;
                            }

                            $quantity = $requested_products[$productAtrributes->entity_id];

                            //  $subtotal = $subtotal + ($quantity * $price);
                            // $total_cart_products++;

                            $order_cart[] = [
                                'product_id' => $productAtrributes->entity_id,
                                'quantity' =>$quantity,
                            ];

                            $gallery = isset($productAtrributes->gallery[0]) ? $productAtrributes->gallery : false;
                            $image = Fields::getGalleryImage($gallery,'product','thumb');

                            $final_cart[] = array(
                                'entity_id' => $productAtrributes->entity_id,
                                'product_code' => $productAtrributes->product_code,
                                'title' => $productAtrributes->product_code,
                                'thumb' => $image,
                                'price' => $price,
                                'product_quantity' => $quantity,
                                'item_type' => $productAtrributes->item_type->value,
                            );

                        }
                    }

                }
            }

            //Save Cart
            if (isset($this->_customerId) && $this->_customerId > 0){
                $order_cart_lib = new OrderCart();
                $order_cart_lib->saveCart($this->_customerId,json_encode($order_cart));
            }

            $data['products'] = $final_cart;
            $data['currency'] = $this->_object_library_general_setting->getCurrency();
            return  View::make('web/includes/product/cart_list',$data)->__toString();
        }
    }

    public function addToWishlist(Request $request)
    {

        $users=array();
        if ($request->session()->has('users'))
        {
            $users = $request->session()->get('users');
        }
        else
        {
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

                /**-------- Cubix panel Internal call Problem solver------- */
                $post_param = $request->all();
                $request->replace($post_param);
                $post_param = $request->all();
                /**-------- Cubix panel Internal call Problem solver------- */

                $response = json_encode(CustomHelper::internalCall($request,"api/entity_auth/social_login", 'POST',$data,false));
                $json = json_decode($response,true);
                $users[0]['entity_id'] =	$json['data']['customer']['entity_id'];


                /**-------- Cubix panel Internal call Problem solver------- */
                $request->replace($post_param);
                /**-------- Cubix panel Internal call Problem solver------- */
            }
        }

        if(isset($users[0]['entity_id']))
        {
            $rules  =  array( 	'product_id' =>  'required'	);
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $data = array();
                $data['actor_entity_id'] 			= $users[0]['entity_id'];
                $data['target_entity_type_id']		= 14;
                $data['actor_entity_type_id']		= 11;
                $data['type']					= "private";
                $data['mobile_json']	= 1;

                $response = json_encode(CustomHelper::internalCall($request,"api/extension/social/package/like/listing", 'GET',$data,false));
                $json 	  = json_decode($response,true);

                $wishlist = isset($json['data']['like_listing']) ? $json['data']['like_listing'] : [] ;

                $data = array();
                $p=0;

                foreach( $wishlist as $wishlist_attribute  )
                {


                    $data[$p]['entity_id'] 			= isset($wishlist_attribute['product']['entity_id']) ? $wishlist_attribute['product']['entity_id'] : null;
                    $data[$p]['wishlist_entity_id'] = isset($wishlist_attribute['package_like_id']) ? $wishlist_attribute['package_like_id'] : null;
                    $data[$p]['thumb'] 				= isset($wishlist_attribute['product']['gallery'][0]['thumb'])?  $wishlist_attribute['product']['gallery'][0]['thumb'] : null ;
                    $data[$p]['title'] 				= isset($wishlist_attribute['product']['title']) ? $wishlist_attribute['product']['title'] : null;
                    $data[$p]['product_code'] 		= isset($wishlist_attribute['product']['product_code']) ? $wishlist_attribute['product']['product_code'] : null;
                    $data[$p]['price'] 				= isset($wishlist_attribute['product']['price']) ? $wishlist_attribute['product']['price'] : null;
                    $data[$p]['item_type'] 			= isset($wishlist_attribute['product']['item_type']) ? $wishlist_attribute['product']['item_type'] : null;
                    /*$data[$p]['weight'] 			= isset($wishlist_attribute['product']['weight']) ? $wishlist_attribute['product']['weight'] : null;
                    $data[$p]['unit_value'] 		= isset($wishlist_attribute['product']['item_unit']['value']) ? $wishlist_attribute['product']['item_unit']['value'] : null;
                    $data[$p]['unit_option'] 		= isset($wishlist_attribute['product']['item_unit']['option']) ? $wishlist_attribute['product']['item_unit']['option']: null;
                    */$p++;
                }
                $data['wishlist'] = $data;

                $general = new GeneralSetting();
                $data['currency'] = $general->getCurrency();
                return  View::make('web/includes/product/wish_list',$data)->__toString();

            }
            else
            {

                $data = array();
                $data['actor_entity_id'] 		= $users[0]['entity_id'];
                $data['target_entity_id'] 		= $request->input('product_id');
                $data['target_entity_type_id']	= 14;
                $data['actor_entity_type_id']	= 11;
                $data['switch']					= 1;
                $data['type']					= "private";
                $data['mobile_json']			= 1;

                $response = json_encode(CustomHelper::appCall($request,"api/extension/social/package/like", 'POST',$data,false));
                $json 	  = json_decode($response,true);


                $data = array();
                $data['actor_entity_id'] 			= $users[0]['entity_id'];
                $data['target_entity_type_id']		= 14;
                $data['actor_entity_type_id']		= 11;
                $data['type']					= "private";
                $data['mobile_json']	= 1;

                $response = json_encode(CustomHelper::internalCall($request,"api/extension/social/package/like/listing", 'GET',$data,false));
                $json 	  = json_decode($response,true);


                $wishlist = $json['data']['like_listing'];

                $data = array();
                $p=0;

                foreach( $wishlist as $wishlist_attribute  )
                {
                    $data[$p]['entity_id'] 			= isset($wishlist_attribute['product']['entity_id']) ? $wishlist_attribute['product']['entity_id'] : null;
                    $data[$p]['wishlist_entity_id'] = isset($wishlist_attribute['package_like_id']) ? $wishlist_attribute['package_like_id'] : null;
                    $data[$p]['thumb'] 				= isset($wishlist_attribute['product']['gallery'][0]['thumb'])?  $wishlist_attribute['product']['gallery'][0]['thumb'] : null ;
                    $data[$p]['title'] 				= isset($wishlist_attribute['product']['title']) ? $wishlist_attribute['product']['title'] : null;
                    $data[$p]['product_code'] 		= isset($wishlist_attribute['product']['product_code']) ? $wishlist_attribute['product']['product_code'] : null;
                    $data[$p]['price'] 				= isset($wishlist_attribute['product']['price']) ? $wishlist_attribute['product']['price'] : null;
                    $data[$p]['item_type'] 				= isset($wishlist_attribute['product']['item_type']) ? $wishlist_attribute['product']['item_type'] : null;
                    /*$data[$p]['weight'] 			= isset($wishlist_attribute['product']['weight']) ? $wishlist_attribute['product']['weight'] : null;
                    $data[$p]['unit_value'] 		= isset($wishlist_attribute['product']['item_unit']['value']) ? $wishlist_attribute['product']['item_unit']['value'] : null;
                    $data[$p]['unit_option'] 		= isset($wishlist_attribute['product']['item_unit']['option']) ? $wishlist_attribute['product']['item_unit']['option']: null;
                    */$p++;

                }

                return $data;
            }

        }
        else
        {
            return "<div class='wishlist_empty nav nav-tabs' style='padding-top: 50%;'><div class='nav-link' style='padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;'  >Wishlist is empty</div><div style='padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;'> Please Sign In to add Items in Wishlist</div></div>";;
        }




    }

	public function deleteToWishlist(Request $request) 
	{
		$rules  	=  array( 	'entity_id' =>  'required'	); 
		$validator  =  Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return '';	
		}
		else
		{	
			
			$users=array();
			if ($request->session()->has('users')) 
			{
					$users = $request->session()->get('users');
			}
			else
			{
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
							$users[0]['entity_id'] =	$json['data']['customer']['entity_id'];
				}
			}
		
			
			$data = array(); 
			$data['actor_entity_id'] 		= $users[0]['entity_id'];
			$data['target_entity_id'] 		= $request->input('entity_id');
			$data['target_entity_type_id']	= 14;
			$data['actor_entity_type_id']	= 11; 
			$data['switch']					= 0;
			$data['type']					= "private";
			$data['mobile_json']			= 1;
			$response = json_encode(CustomHelper::appCall($request,"api/extension/social/package/like", 'POST',$data,false));
			$json 	  = json_decode($response,true);
			
			
			
			
			$data = array(); 
			$data['actor_entity_id'] 			= $users[0]['entity_id'];
			$data['target_entity_type_id']		= 14;
			$data['actor_entity_type_id']		= 11;
			$data['type']					= "private";
			$data['mobile_json']	= 1;
			
			$response = json_encode(CustomHelper::appCall($request,"api/extension/social/package/like/listing", 'GET',$data,false));
			$json 	  = json_decode($response,true);
			$wishlist = $json['data']['like_listing'];
			
			$data = array(); 
			$p=0;
			foreach( $wishlist as $wishlist_attribute  ) 
			{
						 
				$data[$p]['entity_id'] 			= isset($wishlist_attribute['product']['entity_id']) ? $wishlist_attribute['product']['entity_id'] : null;
				$data[$p]['wishlist_entity_id'] = isset($wishlist_attribute['package_like_id']) ? $wishlist_attribute['package_like_id'] : null;
				$data[$p]['thumb'] 				= isset($wishlist_attribute['product']['gallery'][0]['thumb'])?  $wishlist_attribute['product']['gallery'][0]['thumb'] : null ;
				$data[$p]['title'] 				= isset($wishlist_attribute['product']['title']) ? $wishlist_attribute['product']['title'] : null;
				$data[$p]['product_code'] 		= isset($wishlist_attribute['product']['product_code']) ? $wishlist_attribute['product']['product_code'] : null;
				$data[$p]['price'] 				= isset($wishlist_attribute['product']['price']) ? $wishlist_attribute['product']['price'] : null;
                $data[$p]['item_type'] 				= isset($wishlist_attribute['product']['item_type']) ? $wishlist_attribute['product']['item_type'] : null;
                /*$data[$p]['weight'] 			= isset($wishlist_attribute['product']['weight']) ? $wishlist_attribute['product']['weight'] : null;
                $data[$p]['unit_value'] 		= isset($wishlist_attribute['product']['item_unit']['value']) ? $wishlist_attribute['product']['item_unit']['value'] : null;
                $data[$p]['unit_option'] 		= isset($wishlist_attribute['product']['item_unit']['option']) ? $wishlist_attribute['product']['item_unit']['option']: null;
                */$p++;
						
			}
			$data['wishlist'] = $data; 
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			return  View::make('web/includes/product/wish_list',$data)->__toString();
			
		}
	}

	
	public function menus(Request $request)
	{
        $params = ['level'=>1, 'status' => 1,'limit'=>1000];

		$response = json_encode(CustomHelper::internalCall($request,"api/system/category/listing", 'GET',$params,false));
		$json 	  = json_decode($response,true);
      // echo "<pre>"; print_r( $json);exit;

        $data['menus'] = $json["data"]["category_listing"];
		$data['category_id']= isset($_REQUEST['category_id']) ?  $_REQUEST['category_id'] : null ;
		return View::make('web/includes/menus/menus',$data)->__toString();
	}	
	
	public function categories(Request $request)
	{
		$category_id	= $request->input('category_id');

        $params = ['limit'=>1000,'category_id'=>$category_id,'level'=>1];

        $response = json_encode(CustomHelper::internalCall($request,"api/system/category/listing", 'GET',$params,false));
        $json 	  = json_decode($response,true);
        $data['categories'] = $json["data"]["category_listing"];

		$data['category_id']= $category_id;
		//echo "<pre>"; print_r($data); exit;
		return View::make('web/includes/menus/categories',$data)->__toString();
	}

    /**
     * @param Request $request
     * @return mixed
     */
	public function popularCategories(Request $request)
	{

	  $params = ['is_featured'=>1,
          'limit'=>8,
          'status' => 1];
        $response = CustomHelper::internalCall($request,"api/system/category/listing", 'GET',$params,false);
        $json = json_decode(json_encode($response),true);
		$data['popularCategories'] = $json["data"]["category_listing"];
		return View::make('web/includes/main/popular_categories',$data)->__toString();
	}

    /**
     * @param Request $request
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
	public function todayTodayEssentials(Request $request) 
	{
		$rules  =  array(	
							'featured_type'		 =>  'required'				,	
							'product_detail_url' =>  'required'				
						); 
		$validator = Validator::make($request->all(),$rules);
		 
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array(
			    "entity_type_id"=> 'product',
                "featured_type"=>$request->input('featured_type'),
                'status' => 1,
               // 'availability' => 1,
                'limit'=>4
            );
			$data['product_detail_url'] = $request->input('product_detail_url');
            //$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$entity_lib = new Entity();
            $response = $entity_lib->apiList($data);
			$json = json_decode(json_encode($response),true);
			$data['essentials'] = isset($json["data"]['entity_listing'])? $json["data"]["entity_listing"] : null;
			
			$data['currency'] = $this->_object_library_general_setting->getCurrency();

          // echo "<pre>"; print_r($data); exit;
			return View::make('web/includes/main/essentials',$data)->__toString();
		}
	}

    /**
     * @param Request $request
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
	public function newsAndPeakSeasons(Request $request)
	{
		$rules  =  array(	
							'featured_type'		 =>  'required'				,
							'product_detail_url' =>  'required'				
						); 
		$validator = Validator::make($request->all(),$rules);
		 
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array("entity_type_id"=>'product',
                "featured_type"=>$request->input('featured_type'),
                'status' => 1,
               // 'availability' => 1,
                'limit'=>4);

			$data['product_detail_url'] = $request->input('product_detail_url');
			//$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			//$json = json_decode($response,true);
            $entity_lib = new Entity();
            $response = $entity_lib->apiList($data);
            $json = json_decode(json_encode($response),true);
			$data['newsAndPeakSeasons'] = isset($json["data"]['entity_listing'])? $json["data"]["entity_listing"] : null;
			
			$data['currency'] = $this->_object_library_general_setting->getCurrency();
			return View::make('web/includes/main/news_and_peak_seasons',$data)->__toString();
		}
	}

    public function getBrands(Request $request)
    {
        $data = array("entity_type_id"=>'brand',
            'status' => 1,
            'limit'=>10);

        $data['product_detail_url'] = '';
        //$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
        //$json = json_decode($response,true);
        $entity_lib = new Entity();
        $response = $entity_lib->apiList($data);
        $json = json_decode(json_encode($response),true);
        $data['brands'] = isset($json["data"]['entity_listing'])? $json["data"]["entity_listing"] : null;
        //echo "<pre>"; print_r( $data['brands']); exit;
        $data['currency'] = $this->_object_library_general_setting->getCurrency();
        return View::make('web/includes/main/brands',$data)->__toString();
    }

    public function getBrandProducts(Request $request)
    {
        $validator 	= 	Validator::make(
            $request->all(),
            [
                'entity_type_id'	 =>  'required'		,
                "brand_id"		 =>  'required'
            ]
        );
        if($validator->fails())
        {
            return trans('web.productError');
        }
        else
        {

            $data['product_detail_url'] = $request->input('product_detail_url');
            $limit = $request->input('limit');

            $params = 	[
                'entity_type_id'		=>		'product',
                'brand_id'			=>		$request->input('brand_id')	,
                'status'                => 1,
                'offset'				=>		$request->input('offset')	,
                'limit'					=>		$limit,
                'order_by'          => 'entity_id',
                'sorting'           => 'DESC'
            ];
            $json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($params)),true);
            $data['products'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
            $data['currency'] = $this->_object_library_general_setting->getCurrency();

            $data1 = [
                'products'	=> View::make('web/includes/product/product_list',$data)->__toString(),
                'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
            ];

            return $data1;
        }
    }

    public function getMainCategory(Request $request)
    {
        $params = ['level'=>1,
            'limit'=>8,
            'status' => 1];

        $data = [];
        $response = CustomHelper::internalCall($request,"api/system/category/listing", 'GET',$params,false);
        $categories = json_decode(json_encode($response));
        if($categories->error == 0){
            $data['categories'] = $categories->data->category_listing;
        }
        else{
            $data['categories'] = [];
        }


        return View::make('web/includes/main/category',$data)->__toString();
       // echo "<pre>"; print_r($categories); exit;
    }

    public function topCategotyProducts(Request $request)
    {
        $params = [
           // 'level' => 1,
            'top_category' => 1,
            'limit' => 1,
            'status' => 1
        ];

        $data = [];
        $response = CustomHelper::internalCall($request,"api/system/category/listing", 'GET',$params,false);
        $categories = json_decode(json_encode($response));
       // echo "<pre>"; print_r( $categories); exit;

        $data['products'] = [];

        if($categories->error == 0){
            $category = $categories->data->category_listing[0];


            $category_id = $category->category_id;

            if($category->is_gift_card == 0){
                $category_model = new SYSCategory();
                $category_ids = $category_model->getChildCategories($category_id);
            }else{
                $category_ids = $category_id;
            }
            //echo '<pre>'; print_r($category_ids); exit;

            if($category_ids){

                $where_condition = '';
                foreach(explode(',',$category_ids) as $cat_id){

                    if(!empty($where_condition)){
                        $where_condition .= ' OR ';
                    }

                    $where_condition .= ' FIND_IN_SET("'.$cat_id.'",category_id)';
                }

               // echo $where_condition; exit;
                $params = array(
                    'entity_type_id' =>  'product',
                    'where_condition' => "AND ".$where_condition,
                    'status' => 1,
                );

                $entity_lib = new Entity();

                $products_list = $entity_lib->apiList($params);
                $products_list = json_decode(json_encode($products_list),true);
              //  echo "<pre>"; print_r( $products_list); exit;
                if ($products_list['error'] == 0 && isset($products_list['data']['entity_listing'])) {
                    if($products_list['data']['entity_listing'])
                        $data['products']  = $products_list['data']['entity_listing'];
                    else
                        $data['products']  = [];
                } else {
                    $data['products']  = [];
                }
            }

        }

       // echo '<pre>'; print_r($data); exit;
        $data['category'] = $category;
        $data['currency'] = $this->_object_library_general_setting->getCurrency();
       // echo "<pre>"; print_r( $products_list); exit;
        return View::make('web/includes/main/top_category',$data)->__toString();

    }

    public function getAllBrands(Request $request)
    {
        $data = [];
        return View::make('web/brand',$data);
    }

    public function getBrandsAll(Request $request)
    {
        $data['product_detail_url'] = $request->input('product_detail_url');
        $limit = $request->input('limit');

        $params = 	[
            'entity_type_id'		=>		'brand',
            'status'                => 1,
            'offset'				=>		$request->input('offset')	,
            'limit'					=>		1000,
            'order_by'          => 'entity_id',
            'sorting'           => 'DESC'
        ];
        $json 	= 	json_decode(json_encode($this->_object_library_entity->apiList($params)),true);
        $data['brands'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
        $data['currency'] = $this->_object_library_general_setting->getCurrency();

        $data1 = [
            'products'	=> View::make('web/includes//main/all_brands',$data)->__toString(),
            'items'		=> isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null
        ];

        return $data1;
    }

}
