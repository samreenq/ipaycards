<?php

namespace App\Http\Controllers\Web;

use App\Libraries\System\Entity;

use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;

Class TopupsController extends WebController
{
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
     * @internal param the $Sets $__customer_wallet with wallet Transaction Helper object.
     * @access public
     */

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->_object_library_entity = new Entity();

    }

    public function du(Request $request)
    {
        $data = [];
        return View::make('web/includes/topup/du',$data);
    }

    public function etisalat(Request $request)
    {
        $data = [];
        return View::make('web/includes/topup/etisalat',$data);
    }

    public function flyDubai(Request $request)
    {
        $data = [];
        return View::make('web/includes/topup/fly_dubai',$data);
    }

    public function addc(Request $request)
    {
        $data = [];
        return View::make('web/includes/topup/addc',$data);
    }

    public function otpSend(Request $request)
    {

    }



}