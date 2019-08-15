<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Models\SYSTableFlat;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\OrderCart;
use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;
use App\Libraries\EntityCustomer;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;



class AuthenticationController extends WebController {


	/**
     * Global Private variable of this file.It has object of Entity Library 
     * 
     * @access private
     * @var Object
     */
	private $_object_entity_customer;


    /**
	 * Sets the $_object_library_entity with Entity Library object
	 *
	 * @internal param Sets $_object_library_entity with Entity Library object
	 * @access public
	 */
	public function __construct(Request $request)
    {
        parent::__construct($request);
		$this->_object_entity_customer = new EntityCustomer();
		
	}
	
	
	public function facebookSignup (Request $request)
	{
		return View::make('web/main');
	}

	public function facebookSignOut()
	{
		unset($_SESSION['facebook_access_token']);
		unset($_SESSION['fbUserProfile']);
		unset($_SESSION['logoutURL']);
		
		return View::make('web/main');
	}


	public function signin_step1(Request $request) 
	{
		$rules  =  array(	
							'entity_type_id'	=>	'required'		,
							'email' 			=>  'required'		,
							'password' 			=>  'required'		
						); 
		
		$response = $this->_object_entity_customer->validateBasicAuth($request->all());
		$validator = Validator::make($request->all(),$rules);		
		if($response['error']==1)
		{
			return  $response; 
			
		}  
		else 
		{
			return  $response; 
		}
    }


    /**
     * @param Request $request
     * @return array|mixed
     */
    public function signin(Request $request)
    {

        $rules  =  array(	'login_id' 	=>  'required|email',
            'password' 	=>  'required'
        );

       $error_messages = array(
            'login_id.required' => 'The Email field is required',
           'login_id.email' => 'The Email must be a valid email address',
        );

        $validator = Validator::make($request->all(),$rules,$error_messages);
        if($validator->fails())
        {
            return array(
                'error' =>1,
                'message'=> $validator->errors()->first());
        }else{
            $data = array(
                "entity_type_id"	=>	11								,
                "login_id"			=>	$request->input('login_id')		,
                "password"			=>	$request->input('password')		,
                "device_type"		=>	"none"

            );
            $response = json_encode(CustomHelper::internalCall($request,"api/entity_auth/signin", 'POST', $data,true));
            $json = json_decode($response,true);
            $cart_item = !empty($request->cart_item) ? json_decode($request->cart_item) : false;


          //  echo "<pre>"; print_r( $cart_item); exit;

            $url = $request->input('url');
            $json1 = $json;
            //print_r($json);
            if(isset($json['data']['entity_auth']))
            {
                session_unset();
                $json = $json['data']['entity_auth'];
                $data['entity_auth'] = $json;


                if ($request->session()->has('users'))
                {
                    $request->session()->forget('users');
                    $request->session()->push('users',$json);
                }
                else
                {
                    $request->session()->push('users',$json);
                }


                //Get customer cart
                $order_cart_lib = new OrderCart();
               return $order_cart_lib->mergeWebCart($json1['data']['entity_auth']['entity_id'],$cart_item);

            }
            else
            {
                session_unset();
                return $json1;


            }
        }

    }
	
	public function signout(Request $request) 
	{			
		 $request->session()->forget('users');
		 
		 if(isset($_SESSION['fbUserProfile']))
		 {
			if (session_status() == PHP_SESSION_NONE) 
				session_start();

			session_destroy();
		 }
		 $url = url('/'); 
		 return redirect($url);
	}
	
	
	public function signup(Request $request) 
	{
		
		
		$rules  =  array(
		    'first_name' => 'required',
		    'email' =>  'required',
            'mobile_no' => 'required|mobile',
            'term_condition' => 'required',
            );

		$msgs = [
		    'term_condition.required' => 'Please tick the checkbox if you want to proceed.'
        ];
		$validator = Validator::make($request->all(),$rules,$msgs);
		if($validator->fails())
		{
            return array(
                'error' =>1,
                'message'=> $validator->errors()->first());
        }
		else 
		{		
			$data = array(
								"entity_type_id"			=>	11																,
								"is_auth_exists"			=>	0																,
								"role_id"					=>	8																,
								"email"						=>	$request->input('email')										,
								"password"					=>	$request->input('password')										,
								"first_name"				=>	$request->input('first_name')									,
								"last_name"					=>	$request->input('last_name')									,
								"user_status"				=>	2																,
								'special'					=>	'0'																,
							//	'loyalty_points'			=>	'1'																,
								'payment_method_type'		=>	'cod'															,
								'wallet'					=>	'0'																,
								'full_name'					=>	$request->input('first_name').' '.$request->input('last_name')	,
								"mobile_no"					=>	$request->input('mobile_no')									,
								//'refer_friend_code_applied' =>	$request->input('refer_friend_code_applied')
								
						 ); 
			$url = $request->input('url');			
			$response = json_encode(CustomHelper::internalCall($request,"api/entity_auth", 'POST', $data,true));
			$json = json_decode($response,true);
           // echo "<pre>"; print_r( $json);exit;

			if(isset($json['error']) && $json['error'] == 1){
                return array(
                    'error' =>1,
                    'message'=>$json['message']);
            }else{
                if(isset($json['data']['entity_auth']))
                {
                    $json = $json['data']['entity_auth'];
                    $data['entity_auth'] = $json;

                   // print_r( $request->session()->get('users') ) ; exit;
                    ///print_r(session()::get('users'));

                    //exit;
                    return $json;

                }
            }
           // echo "<pre>"; print_r( $json);exit;

         /*   if(isset($json['data']['entity_auth']))
			{
				$json = $json['data']['entity_auth'];
				$data['entity_auth'] = $json;
				if ($request->session()->has('users')) 
				{
					 $request->session()->forget('users');
					 $request->session()->push('users',$json);
				}
				else
				{
					 $request->session()->push('users',$json);
				}
				//print_r( $request->session()->get('users') ) ;
				///print_r(session()::get('users')); 
				
				//exit;

				return $json;
			}
			else
			{
				if ($request->session()->has('message1')) 
				{
					 $request->session()->forget('meesage1');
					 $request->session()->flush();
					 $request->session()->push('message1',$json['message']);
					 
					 return array("message"=>$json['message'] ); 
				}
				else
				{
					$request->session()->push('message1',$json['message']);
					return array("message"=>$json['message'] ); 
				}
			}*/
		}
    }

    /**
     * @param Request $request
     * @return array
     */
	public function phoneVerfication(Request $request) 
	{
		$validator = Validator::make(
						$request->all(),
						[
							"mobile_no"=>'required',
							"verification_token"=>'required',
							"verification_mode"=>'required',
							"entity_type_id"=>'required',
							"authy_code"=>'required'
						]
						
						);		
		if($validator->fails())
		{
            return array(
                'error' =>1,
                'message'=> $validator->errors()->first());
		}
		else 
		{		
						
			$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								"api/entity_auth/verify_phone", 
								'POST', 
								[
									"mobile_no"=>$request->input('mobile_no'),
									"verification_token"=>$request->input('verification_token'),
									"verification_mode"=>$request->input('verification_mode'),
									"entity_type_id"=>$request->input('entity_type_id'),
									"authy_code"=>$request->input('authy_code')
								],
								true
							)
						),
						true
					);
            //echo "<pre>"; print_r( $json);exit;
            if(isset($json['error']) && $json['error'] == 1){
                return array(
                    'error' =>1,
                    'message'=>$json['message']);
            }else{

                $user = $json['data']['customer'];

                if ($request->session()->has('users'))
                {
                    $request->session()->forget('users');
                    $request->session()->push('users',$user);
                }
                else
                {
                    $request->session()->push('users',$user);
                }

                return array(
                    'error' =>0,
                    'message'=>$json['message']);
            }

		}  
    }
	
	public function socialPhoneVerfication(Request $request) 
	{
		
		
		$rules  =  array(	'mobile_no' =>  'required'		); 
		$validator = Validator::make(
						$request->all(),
						[
							"mobile_no"=>'required',
							"verification_token"=>'required',
							"verification_mode"=>'required',
							"entity_type_id"=>'required',
							"authy_code"=>'required'
						]
						
						);		
		if($validator->fails())
		{
			return '';
		}
		else 
		{		
						
			$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								"api/entity_auth/verify_phone", 
								'POST', 
								[
									"mobile_no"=>$request->input('mobile_no'),
									'is_mobile_verified'=>1,
									"verification_token"=>$request->input('verification_token'),
									"verification_mode"=>$request->input('verification_mode'),
									"entity_type_id"=>$request->input('entity_type_id'),
									"authy_code"=>$request->input('authy_code')
								],
								true
							)
						),
						true
					);
			return $json; 
			
		}  
    }
	
	public function resendCode(Request $request) 
	{
		
		$validator = Validator::make(
						$request->all(),
						[
							"entity_type_id"=>'required',
							"entity_id"=>'required',
							"mode"=>'required',
							"mobile_no"=>'required',
							"new_login_id"=>'required',
						]
						
						);		
		if($validator->fails())
		{
			return '';
		}
		else 
		{		
						
			$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								"api/entity_auth/resend_code", 
								'POST', 
								[
									"entity_type_id"=>$request->input('entity_type_id'),
									"entity_id"=>$request->input('entity_id'),
									"mode"=>$request->input('mode'),
									"mobile_no"=>$request->input('mobile_no'),
									"new_login_id"=>$request->input('new_login_id'),
									"mobile_json"=>1
								],
								true
							)
						),
						true
					);
			return $json; 
			
		}  
    }
	
	
	
	public function sendCode(Request $request) 
	{
		
		$validator = Validator::make(
						$request->all(),
						[
							"new_login_id"=>'required',
						]
						
						);		
		if($validator->fails())
		{
			return '';
		}
		else 
		{		
			$new_login_id = $request->input('new_login_id'); 

			$json = json_decode(
						json_encode(
							CustomHelper::internalCall(
								$request,
								"api/entity_auth/change_id_request", 
								'POST', 
								[
									"new_login_id"=>$new_login_id,
									"entity_id"=>$this->_customerId,
									"mobile_json"=>1
								],
								true
							)
						),
						true
					);
					
			return isset($json) ? $json : null; 
			
		}  
    }
	
	public function main(Request $request)
    {
        $data['users'] = $this->_customer;
        return View::make('web/main',$data);
    }

    public function validateBasicAuth(Request $request)
    {
        $entity_customer = new EntityCustomer();
        return $entity_customer->validateBasicAuth($request->all());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function facebookLogin(Request $request)
    {
        if((isset($request->platform) && $request->platform == 'facebook')
            && isset($request->data['id'])) {

            $cart_item = !empty($request->cart_item) ? json_decode($request->cart_item) : false;

            $user = (object)$request->data;

            $json = json_decode(
                json_encode(
                    CustomHelper::internalCall(
                        $request,
                        'api/entity_auth/social_login',
                        'POST',
                        [
                            'entity_type_id' => 11,
                            'name' => $user->name,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'platform_type' => $request->platform,
                            'device_type' => 'none',
                            'platform_id' => $user->id,
                            'email' => $user->email,
                            'status' => 1,
                            //'mobile_json' => 1,
                        ],
                        FALSE
                    )
                ),
                TRUE
            );
            // echo "<pre>"; print_r( $json);exit;

            $json_auth = $json;
            if (isset($json['data']['entity_auth'])) {
                session_unset();
                $json = $json['data']['entity_auth'];
                $data['entity_auth'] = $json;


                if ($request->session()->has('users')) {
                    $request->session()->forget('users');
                    $request->session()->push('users', $json);
                } else {
                    $request->session()->push('users', $json);
                }

                //Get customer cart
                $order_cart_lib = new OrderCart();
                return $order_cart_lib->mergeWebCart($json_auth['data']['entity_auth']['entity_id'],$cart_item);

            }
            return $json_auth;
        }

        return array(
          'error' => 1,
          'message' => 'Platform and facebook id is required'
        );

    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "current_email" => 'required|email',
            ], ['current_email.required' => 'The Email address is required', 'current_email.email' => 'The Email address is not valid']

        );
        if ($validator->fails()) {
            return [
                'error' => 1,
                'message' => $validator->errors()->first()
            ];
        } else {
            $json = json_decode(
                json_encode(
                    CustomHelper::internalCall(
                        $request,
                        'api/entity_auth/forgot_request',
                        'POST',
                        [
                            'entity_type_id' => 11,
                            'login_id' => $request->current_email,
                        ],
                        FALSE
                    )
                ),
                TRUE
            );

            return $json;

        }
    }

}
