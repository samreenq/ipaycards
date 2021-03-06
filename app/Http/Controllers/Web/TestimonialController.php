<?php
 /**
 * File Handle all Testimonial related functionality's
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
use App\Libraries\GeneralSetting;

use Illuminate\Http\Request;
use Illuminate\Http\Input;

use View;
use Validator;


/**
  *
  * TestimonialController Class Handle all functionality's related to Testimonial
  *
  * @package  	TestimonialController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/
class TestimonialController extends WebController
{

    /**
     * TestimonialController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
	
	/**
     * Fetch the data of Testimonial  using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of Testimonial Detail page 
	 * @access public
     *
     */
	public function getTestimonial(Request $request) 
	{
		if(Validator::make($request->all(),[])->fails())
		{
			return trans('web.productError');
		}
		else 
		{	
			$json	 =  json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing',
									'GET',
									[
										'entity_type_id'	=> 35,
										'mobile_json'		=> 1
									],
									false
								)
							),
							true
						);
			$data	=	[];
			$data['testimonials'] = isset($json['data']['testimonials'])? $json['data']['testimonials'] : null;
			
			return View::make('web/includes/main/testimonial_detail',$data)->__toString();
		}
	}
}
