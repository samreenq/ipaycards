<?php
/**
 * Description: Base Controller for web to pass dynamic data to all
 * Author: Samreen <samreen.quyyum@cubixlabs.com>
 * Date: 17-April-2018
 * Time: 02:00 PM
 * Copyright: CubixLabs
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Models\Conf;
use App\Http\Models\Setting;
use App\Libraries\GeneralSetting;
use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;

class WebController extends Controller
{
    /**
     * To hold session user id
     * @var private
     */
    protected $_customerId;

    /**
     * To hold session user information
     * @var private
     */
    protected $_customer;


    /**
     *check user session if exist then add local variables
     * WebController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        if ($request->session()->has('users')) {
            $user = $request->session()->get('users', 'default');

            if (isset($user[0])) {
                $this->_customer = $user[0];
                $this->_customerId = $user[0]['entity_id'];
            }
        }

       // echo "<pre>"; print_r($this->_customer); exit;

        $conf_model = new Conf();
        $fb_raw = $conf_model->getBy("key","facebook");
        $fb_config = json_decode($fb_raw->value);

        $setting_model = new Setting();
        $google_key = $setting_model->getBy('key','google_client_key');
        $google_client_key = (isset($google_key->value)) ? $google_key->value : "";


        $general_setting_lib = new GeneralSetting();
        $general_setting_raw = $general_setting_lib->getSetting();

        View::share('customerId',  $this->_customerId);
        View::share('login_customer',  json_decode(json_encode($this->_customer)));
        View::share('fb_config', $fb_config);
        View::share('general_setting_raw', $general_setting_raw);
        View::share('google_client_key', $google_client_key);

    }
}