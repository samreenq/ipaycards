<?php

/**
 * File Handle all About Business related functionality's
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
 * @Date:     12/29/2017
 * @Time:     2:13 PM
 * 
 */
 
 
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Libraries\CustomHelper;

use Illuminate\Http\Request;
use Illuminate\Http\Input;

use View;
use Validator;



/**
  *
  * AboutBusinessController Class Handle all functionality's related to About Business
  *
  * @package  	AboutBusinessController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/

class AboutBusinessController extends WebController
{

    /**
     * AboutBusinessController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
	/**
     * Fetch the data of about business from CMS based entity using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of about_us page 
	 * @access public
     *
     */
	public function aboutBusiness(Request $request) 
	{ 
		if(Validator::make($request->all(),[])->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$json =  json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/listing',
								'GET',
								[
									'entity_type_id'=>38,
									'mobile_json'=>1, 
									'limit'=>10000
								],
								false
								)),
							true
						); 
						
			$data['about_business']= isset($json['data']['about_business']) ? $json['data']['about_business'] : null ;
			$about_business = []; 
			foreach($data['about_business'] as $attributes ) 
			{
				$json   = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing',
									'GET',
									[
										'entity_type_id'=>38,
										'entity_id'=>$attributes['entity_id'],
										'hook'=>'about_business_items',
										'mobile_json'=>1,
										'limit'=>10000
									],
									false
									)),
								true
							);
				$about_business[] = isset($json['data']['about_business'][0]) ? $json['data']['about_business'][0] : null;
			}		
			
			return View::make('web/includes/cms/about_us', ['about_business' => $about_business ])->__toString();
		}
	}
	

}
