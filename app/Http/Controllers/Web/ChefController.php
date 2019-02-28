<?php
/**
 * File Handle all About Business related functionalities 
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
 * @Date:     01/11/2017
 * @Time:     7:04 PM
 * 
 */
 
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\System\Entity;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;

use Facebook\Facebook;
use Illuminate\Cookie\CookieJar;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use View;
use Validator;
use Cookie;
/**
  *
  * ChefController Class Handle all functionalities related to Chef
  *
  * @package  	WalletController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/

class ChefController extends WebController {
	
	
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
		$this->_object_library_entity = new Entity();
		
	}
	
	/**
     * Save Review of Customer from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the data of review 
	 * @access public
     *
     */ 
	public function saveReview(Request $request) 
	{
		$validator = Validator::make(
						$request->all(),
						[
							'review'		 =>  'required'				,	
							'rating' 		 =>  'required'				,	
							'product_id' 	 =>	 'required'	
						]
					);		
		 
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
	
			$product_id = $request->input('product_id'); 
			$rating 	= $request->input('rating'); 
			$review 	= $request->input('review');

			$json	  = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									\URL::to(DIR_API).'/extension/social/package/rate',
									'POST',
									[
										'target_entity_type_id'		=>	14,
										'actor_entity_type_id'		=>	11,
										'target_entity_id'		=>	$product_id,
										'actor_entity_id'			=>	$this->_customerId,
										'rating'					=>	$rating,
										'review'					=>	$review,
										'mobile_json'				=>	1,
                                        //'login_entity_id'           => $this->_customerId,
									],
									false
								)
							),
							true
						);

			$reviews  = isset($json["data"]["rate_listing"]) ? $json["data"]["rate_listing"] : null;

			return ['reviews'=> $json ,'message'=>$reviews['message']];
		}
	}
	
	/**
     * Fetch data of Guest Chef Deals from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of Guest Chef Deal 
	 * @access public
     *
     */ 
	public function getGuestChefDeals(Request $request) 
	{
		$rules  =  array(	
							'product_detail_url' =>  'required'				,
							'entity_id'			 =>	 'required'
						); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			/*$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing', 
								'GET',
								[
									'entity_type_id'=>'product',
									'product_type'=>2,
                                    'availability' => 1,
									'status' =>1,
									'product_detail_url'=> $request->input('product_detail_url'),
									'limit'=>2,
									'mobile_json'=>1
								],
								false
							)
						),
						true
					);*/

			$params = [
                'entity_type_id'=>'product',
                'product_type'=>2,
                'availability' => 1,
                'status' =>1,
                'product_detail_url'=> $request->input('product_detail_url'),
                'limit'=>2,
                'mobile_json'=>1
            ];
            $entity_lib = new Entity();
            $json = json_decode(json_encode($entity_lib->apiList($params)),true);
		
			$data['deal'] = isset($json["data"]["product"])? $json["data"]["product"] : null;
			return View::make('web/includes/main/guest_chef_deal_detail',$data)->__toString();
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
										'product_type'=>2,
										'chef'=>$request->input('entity_id'),
										'product_detail_url'=> $request->input('product_detail_url'),
										'mobile_json'=>1
									],
									false
								)
							),
							true
						);
			
			$data['deal'] = isset($json["data"]["product"])? $json["data"]["product"] : null;
			return View::make('web/includes/recipe/chef_recipe_list',$data)->__toString();
		}
	}
	
	
	/**
     * Fetch data of Guest Chef Deals by chef from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of Guest Chef Deal 
	 * @access public
     *
     */ 
	public function getGuestChefDealsByChef(Request $request) 
	{
		$rules  =  array(	
							'product_detail_url' =>  'required'				,
							'entity_id'			 =>	 'required'
							
						); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array("entity_type_id"=>14,"product_type"=>2,'chef'=>$request->input('entity_id'),"mobile_json"=>1); 
			$data['product_detail_url'] = $request->input('product_detail_url');
			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$json = json_decode($response,true); 

			$data['deal'] = isset($json["data"]["product"])? $json["data"]["product"] : null;
			return View::make('web/includes/main/guest_chef_deal_detail',$data)->__toString();
		}
	}
	
	
	
	/**
     * Fetch data of Top Chef Deals by chef from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of Top Chef Deal 
	 * @access public
     *
     */ 
	public function getTopChefDeals(Request $request) 
	{
		$validator = Validator::make($request->all(),[]);		
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array("entity_type_id"=>'product',
                'status' => 1,
                'availability' => 1,
                "product_type"=>2,"limit"=>3,"mobile_json"=>1);

            $entity_lib = new Entity();
            $response = $entity_lib->apiList($data);
            $json = json_decode(json_encode($response),true);

			//$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			//$json = json_decode($response,true);

			$data['deal'] = isset($json["data"]["product"])? $json["data"]["product"] : null;
			return View::make('web/includes/recipe/recipie_chef_fegs_detail',$data)->__toString();
		}
	}
	
	
	/**
     * Fetch data of All Recipes from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of Recipe
	 * @access public
     *
     */ 
	public function getAllRecipes(Request $request) 
	{
		
		$rules  =  array(	
							'product_type'		 =>  'required'				,	
							'product_detail_url' =>  'required'				,
							'chef_name'			 =>  'required'				
						); 
		$validator = Validator::make($request->all(),$rules);		
		 
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$data = array("entity_type_id"=>14,"product_type"=>$request->input('product_type')); 
			$data['product_detail_url'] = $request->input('product_detail_url');
			$data['chef_name']= $request->input('chef_name');

			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$json = json_decode($response,true); 
			$data['recipe'] = isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null;
			return View::make('web/includes/recipe/recipe_list',$data)->__toString();
		}
	}
	
	/**
     * Fetch data of Recipes by Chef from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of chef
	 * @access public
     *
     */
	public function getRecipeBychef(Request $request) 
	{
		$rules  =  array(	
							'entity_id'	=>	'required'
						); 
		$validator = Validator::make($request->all(),$rules);		
		if($validator->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
						
			$data = ["entity_type_id"=>22,'entity_id'=>$request->input('entity_id'),"mobile_json"=>1]; 
			$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET',$data,false));
			$json = json_decode($response,true); 
			$data['chef'] = isset($json["data"]["chef"][0])? $json["data"]["chef"][0] : null;
			
			return View::make('web/chef',$data);
		}
	}
	
	
	/**
     * Fetch data of Recipes by code from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the View of Recipe detail
	 * @access public
     *
     */
	public function getRecipeByCode(Request $request) 
	{
		$rules  =  array(	
							'entity_type_id'	 =>	 'required'				,	
							'product_code'	     =>	 'required'				
						); 
		$validator = Validator::make($request->all(),$rules);	
		if($validator->fails())
		{
			return View::make('web/recipe_detail');
		}
		else 
		{	
			$general = new GeneralSetting();
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$product_code =	$request->input('product_code');

			$data = array("entity_type_id"=>'product',
                "product_type"=>2,
                "product_code"=>$request->input('product_code'),
                'status' => 1,
                'availability' => 1,
                'mobile_json'=>1);

            $response = $this->_object_library_entity->apiList($data);
            $product_json = json_decode(json_encode($response),true);

			/*$response = json_encode(CustomHelper::internalCall($request,"api/system/entities/listing", 'GET', $data,true));
			$json0 = json_decode($response,true); */
			$data['recipe'] = $product_json["data"]["product"][0];
			
			$data1 = array(); 
			$data1['target_entity_type_id']		= 14;
			$data1['actor_entity_type_id']		= 11;
			$data1['target_entity_id']			= $data['recipe']['entity_id'];
			$data1['mobile_json']	= 1;
					
			$response = json_encode(CustomHelper::internalCall($request,"api/extension/social/package/rate/listing", 'GET',$data1,false));
			$json2 	  = json_decode($response,true);
			$reviews  = isset($json2["data"]["rate_listing"]) ? $json2["data"]["rate_listing"] : null;
			
			
			
			
			
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
					    $data00['product'] =  isset($product_json["data"]["product"][0]) ? $product_json["data"]["product"][0] : null ;
							
						if($this->_customerId!=null)
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
								$data1[$p]['weight'] 			= isset($wishlist_attribute['product']['weight']) ? $wishlist_attribute['product']['weight'] : null;
								$data1[$p]['unit_value'] 		= isset($wishlist_attribute['product']['item_unit']['value']) ? $wishlist_attribute['product']['item_unit']['value'] : null;
								$data1[$p]['unit_option'] 		= isset($wishlist_attribute['product']['item_unit']['option']) ? $wishlist_attribute['product']['item_unit']['option']: null;	 
								
								if($data1[$p]['entity_id'] == $data00['product']['entity_id'] )
									$data['wishlist'] = 1; 
								
								$p++;
							 }
						}
				
			
			$data['categories_all'] =  isset($json2["data"]['category_listing']) ? $json2["data"]["category_listing"]: null ;
			
			$data['recipe'] = $product_json["data"]["product"][0];
			
			$data['reviews'] = $reviews; 
			$data['redirect_url']	= url('/').'/recipe_detail?entity_type_id=14&product_code='.$product_code;
			$data['social_media_url']	= $url; 
			$data['currency'] = $general->getCurrency();
			return View::make('web/recipe_detail',$data);
		}
    }
	
}
