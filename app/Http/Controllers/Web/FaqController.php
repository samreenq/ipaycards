<?php
/**
 * File Handle  Frequently asked questions and term and conditions related functionality's
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

use App\Http\Models\SYSAttributeOption;
use App\Http\Models\SYSTableFlat;
use App\Libraries\CustomHelper;

use App\Libraries\System\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Input;

use View;
use Validator;



/**
 *
 * FaqController Class Handle all functionality's related to Frequently asked questions and term and conditions .
 *
 * @package  	FaqController
 * @subpackage  Web
 * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
 * @version  	1.0
 * @access   	public
 * @see      	http://www.example.com/pear
 */
class FaqController extends WebController
{
    /**
     * Global Private variable of this file.It has object of Entity Library
     *
     * @access private
     * @var Object
     */
    private $_object_library_entity;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->_object_library_entity = new Entity();

    }

	/**
	 * Fetch the data of terms and condition from cms entity  using internal call ( API )
	 *
	 * @param Request $request the string to get the data from GET and POST Method
	 * @return the view of term and condition  page
	 * @access public
	 *
	 */

	public function index(Request $request)
    {
        return View::make('web/faq');
    }

	public function termAndCondition(Request $request) 
	{

		if(Validator::make($request->all(),[])->fails())
		{
			return trans('web.productError');
		}
		else 
		{
			$json	 = json_decode(
							json_encode(
								CustomHelper::internalCall(
									$request,
									'api/system/entities/listing',
									'GET',
									[
										'entity_type_id'=>24,
										'limit'=>1000
									],
									false
								)
							),
							true
						);
			$data['termAndCondition'] = isset($json['data']['entity_listing'])? $json['data']['entity_listing'] : null;
			
			
			return View::make('web/includes/termandcondition/term_and_condition',$data)->__toString();
		}
	}


	/**
	 * Fetch the data of Frequently asked Questions from cms entity  using internal call ( API )
	 *
	 * @param Request $request the string to get the data from GET and POST Method
	 * @return the view of Frequently asked Questions page
	 * @access public
	 *
	 */
	public function frequentAskedQuestions(Request $request)
	{

		if (Validator::make($request->all(),[])->fails())
		{

			return trans('web.productError');
		} else
		{
			$json1 = json_decode(
						json_encode(
							$this->_object_library_entity->apiList(
								[
									'entity_type_id' => 28,
									'limit' => -1
								],
								false
							)
						),
						true
					);

		/*	$json2 = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/attribute_option/listing',
								'GET',
								[
									'attribute_code' => 'type'
								],
								false
							)
						),
						true
					);*/

            $sys_attribute_option_model = new SYSAttributeOption();
            $attribute_options =  $sys_attribute_option_model->getDataByAttributeCode('type');
			$data['frequentAskedQuestions'] = isset($json1['data']['entity_listing']) ? $json1['data']['entity_listing'] : null;
			$data['type'] = $attribute_options;
            //echo "<pre>"; print_r($data['frequentAskedQuestions']);exit;


			return View::make('web/includes/faq/faq', $data);
		}
	}

    /**
     * @param Request $request
     * @param $slug
     * @return mixed
     */
	public function cms(Request $request,$slug)
    {
        $data = array();
        $cms_flat = new SYSTableFlat('cms');
        $where_condition = " status = 1 AND slug = '".$slug."'";
        $cms_raw = $cms_flat->getDataByWhere($where_condition);

     //  echo "<pre>"; print_r( $cms_raw);exit;

        if($cms_raw && isset($cms_raw[0])){
            $data['cms'] = $cms_raw;
            $data['page_slug'] = $slug;
        }

        return View::make('web/includes/cms/cms', $data)->__toString();

    }

    public function mobileApp(Request $request)
    {
        return View::make('web/mobileapp');
    }
}
