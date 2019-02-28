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

use App\Http\Models\Web\WebEntity;
use App\Http\Controllers\Controller;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
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
  * ReferAFriendController Class Handle all functionality's related to Refer a Friend
  *
  * @package  	AboutBusinessController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/

class ReferAFriendController extends WebController
{

    /**
     * ReferAFriendController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
	/**
     * Fetch the data of referal code  from CMS based entity using internal call ( API )
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of about_us page 
	 * @access public
     *
     */ 
	public function referAFriend(Request $request) 
	{ 
		if(Validator::make($request->all(),['entity_id'=>'required','email'=>'required'])->fails())
		{
			$entity_id	 = $request->input('entity_id');
			$email	= $request->input('email');
			
			$json =  json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/send_refer_code',
								'POST',
								[
									'entity_id'=>$entity_id,
									'email'=>$email,
									'mobile_json'=>1, 
								],
								false
								)),
							true
						); 
						
			$data= isset($json) ? $json : null ;

			return $data; 
		}
		else 
		{	
			$entity_id	 = $request->input('entity_id');
			$email	= $request->input('email');
			
			$json =  json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								'api/system/entities/send_refer_code',
								'POST',
								[
									'entity_id'=>$entity_id,
									'email'=>$email,
									'mobile_json'=>1, 
								],
								false
								)),
							true
						); 
					
			$data= isset($json) ? $json : null ;

			return $data; 
		}
	}
	

}
