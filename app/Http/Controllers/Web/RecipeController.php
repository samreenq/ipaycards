<?php
namespace App\Http\Controllers\Web;

/**
 * File Handle all Recipe related functionalities 
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
 
 
use App\Http\Controllers\Controller;

use App\Libraries\CustomHelper;
use App\Libraries\Fields;
use App\Libraries\GeneralSetting;
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
  * RecipeController Class Handle all functionalities related to Recipes
  *
  * @package  	WalletController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/
class RecipeController  extends WebController {
	
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
     * Fetch the data of recipe from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of wallet page 
	 * @access public
     *
     */ 
	public function showAllRecipe(Request $request) 
	{
		
		/*$json1= json_decode(
					json_encode(
						CustomHelper::internalCall(
							$request,
							'api/system/entities/listing', 
							'GET',
							[
								'entity_type_id'=>14,
								'product_type'=>2,
								'is_featured'=>1,
								'limit'=>1,
								'status' => 1,
                                'availability' => 1,
								'mobile_json'=>1
							],
							false
						)
					),
					true
				);*/

		//get product
		$params = [
            'entity_type_id'=> 'product',
            'product_type'=>2,
            'is_featured'=>1,
            'limit'=>1,
            'status' => 1,
            'availability' => 1,
            'mobile_json'=>1
        ];

        $entity_lib = new Entity();
        $response = $entity_lib->apiList($params);
        $json1 = json_decode(json_encode($response),true);


/*		$json2= json_decode(
					json_encode(
						$this->_object_library_entity->apiList(
							[
								'entity_type_id'=>42, 
								'mobile_json'=>1, 
								'entity_id'=> ''
							]
						)
					),
					true
				);*/

        //get searchable tags
        $params = [
            'entity_type_id'=> 'recipe_tags',
            'mobile_json'=>1,
            'entity_id'=> ''
        ];

        $tags_response = $entity_lib->apiList($params);
        $json2 = json_decode(json_encode($tags_response),true);
	
		$data1['recipe'] = isset($json1["data"]["product"][0])? $json1["data"]["product"][0] : null;

        //Get image of product
        $gallery = isset($data1['recipe']['gallery'][0]) ? json_decode(json_encode($data1['recipe']['gallery'])) : false;
        $data1['recipe']['image'] = Fields::getGalleryImage($gallery,'product','compressed_file');


		$data1['chef_ids_tags'] = isset($json2['data']['recipe_tags'][0]['chef_ids']) ?  $json2['data']['recipe_tags'][0]['chef_ids'] : null;
		$data1['price'] = isset($json2['data']['recipe_tags'][0]['price']) ?  $json2['data']['recipe_tags'][0]['price'] : 0;
		$data1['searchable_tags'] = isset($json2['data']['recipe_tags'][0]['searchable_tags']) ?  $json2['data']['recipe_tags'][0]['searchable_tags'] : null;
		$data1['recipe_serving_tags'] = isset($json2['data']['recipe_tags'][0]['recipe_serving']) ?  $json2['data']['recipe_tags'][0]['recipe_serving'] : null;

        $general = new GeneralSetting();
        $data1['currency'] = $general->getCurrency();
		return View::make('web/recipe',$data1)->__toString();
	}
	
	
	
	
	
	/**
     * Fetch the data of recipe from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of wallet page 
	 * @access public
     *
     */ 	 
	public function getAllRecipes(Request $request) 
	{
		$validator = 	Validator::make(
							$request->all(),
							[
								'product_type'		 =>  'required'				,	
								'product_detail_url' =>  'required'				,
								'offset'			 =>	 'required'				,
								'limit'			 	 =>	 'required'
							]
						);		
		 
		if($validator->fails())
		{
			
			return trans('web.productError');
		}
		else 
		{	
				
			$product_detail_url = $request->input('product_detail_url');
			$limit = $request->input('limit'); 
			
			$data = [
						'entity_type_id'        => 	14,
						'product_type' 			=> 	$request->input('product_type'),
						'chef'					=>	$request->input('chef_ids_tags'),
						'searchable_tags'		=>	$request->input('searchable_tags'),
						'serving'				=>  $request->input('recipe_serving_tags'),
						'product_detail_url'	=> 	$product_detail_url,
						'range_fields'			=>	'price',
                        'status' => 1,
                        'availability' => 1,
						'offset'				=> 	$request->input('offset'), 
						'limit'					=> 	$request->input('limit')
					];
					
			if(	$request->has('low_price') && $request->has('high_price') )			
				$data['price'] = $request->input('low_price').','.$request->input('high_price');					
				
			
			
		/*	$json   = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing', 
									'GET',
									$data,
									false
								)
							),
							true
						);*/

            $entity_lib = new Entity();
            $response = $entity_lib->apiList($data);
            $json = json_decode(json_encode($response),true);

            $assign_data = [
                'recipe'	=>	 isset($json["data"]["entity_listing"])? $json["data"]["entity_listing"] : null,
                'product_detail_url'	=> $product_detail_url
            ];


			$data= [  
				    'recipe'=>  View::make(
									'web/includes/recipe/recipe_list',
                                    $assign_data
								)->__toString(),
					'items'	=>	isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/$limit) : null,
					'product_detail_url' =>  $product_detail_url
				];
				
			return $data;
		}
	}
	
	
	
}
