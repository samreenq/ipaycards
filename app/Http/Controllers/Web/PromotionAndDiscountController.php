<?php

/**
 * File Handle all Products Promotion and discount related functionality's
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

use App\Libraries\CustomHelper;

use App\Libraries\ProductHelper;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Input;

use View;
use Validator;


/**
 *
 * PromotionAndDiscountController Class Handle all functionality's related to Products Promotion and discount .
 *
 * @package  	PromotionAndDiscountController
 * @subpackage  Web
 * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
 * @version  	1.0
 * @access   	public
 * @see      	http://www.example.com/pear
 */
class PromotionAndDiscountController extends WebController
{

    /**
     * PromotionAndDiscountController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
	/**
	 * Fetch the data of promotion and discounts of products  using internal call ( API )
	 *
	 * @param Request $request the string to get the data from GET and POST Method
	 * @return the view of promotion and discount page
	 * @access public
	 *
	 */
	public function getPromotionAndDiscount(Request $request)
	{
		if(Validator::make($request->all(),[])->fails())
		{
			return trans('web.productError');
		}
		else 
		{
            $date = date('Y-m-d');

			/*$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing',
								'GET',
								[
									'entity_type_id'=> 'promotion_discount',
									'mobile_json'=>1,
                                    'availability' => 1,
                                    'where_condition' => " AND start_date <= '$date' AND end_date >= '$date'",
                                    'limit' => 4
								],
								false
							)
						),
						true
					);*/

			$params = [
                'entity_type_id'=> 'promotion_discount',
                'mobile_json'=>1,
                'availability' => 1,
                'where_condition' => " AND start_date <= '$date' AND end_date >= '$date'",
                'limit' => 4
            ];

			$entity_lib = new Entity();
			$json = $entity_lib->apiList($params);
			$json = json_decode(json_encode($json),true);

			$data = [];
			//$data['promotion_discount'] = isset($json['data']['promotion_discount'])? $json['data']['promotion_discount'] : null;

            //echo '<pre>'; print_r($json['data']['promotion_discount']); exit;
            $promotions = array();
            if(isset($json['data']['promotion_discount'])){

                $product_helper = new ProductHelper();

                if(count($json['data']['promotion_discount'])>0){
                    foreach($json['data']['promotion_discount'] as $promotion){

                        //check if promotion id exist in product table id yes
                        $products_exist =  $product_helper->checkPromotionExist($promotion['entity_id']);
                       if($products_exist > 0)
                            $promotions[] = $promotion;
                    }
                }
            }

            $data['promotion_discount'] = $promotions;
			return array(
			    'count' => isset($json['data']['promotion_discount'])? count($json['data']['promotion_discount']) : 0,
                    'html' => View::make('web/includes/main/promotion_and_discount',$data)->render());
		}
	}
}
