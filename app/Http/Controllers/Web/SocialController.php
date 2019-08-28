<?php

namespace App\Http\Controllers\Web;

use App\Libraries\CustomHelper;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use View;
use Validator;


class SocialController extends WebController
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
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
       // echo '<pre>'; print_r($user); exit;

        if(isset($user->id)){

            $username = explode(' ',$user->name);
            $first_name = $username[0];
            $last_name = isset($username[1]) ? $username[1] : '';


            $json = json_decode(
                json_encode(
                    CustomHelper::internalCall(
                        $request,
                        'api/entity_auth/social_login',
                        'POST',
                        [
                            'entity_type_id' => 11,
                            'name' => $user->name,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'platform_type' => 'facebook',
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


            }
        }

        return redirect()->back();

    }
}