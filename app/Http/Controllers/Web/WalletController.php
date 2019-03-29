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
 * @Date:     01/11/2017
 * @Time:     7:04 PM
 * 
 */
 
 
namespace App\Http\Controllers\Web;

use App\Http\Models\Custom\OrderItemFlat;
use App\Http\Models\SYSEntity;
use App\Http\Models\Web\WebEntity;

use App\Http\Controllers\Controller;

use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use App\Libraries\System\Entity;
use App\Libraries\WalletTransaction;

use Illuminate\Http\Request;
use Illuminate\Http\Input;

use Illuminate\Foundation\Http\FormRequest;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use View;
use Validator;


/**
  *
  * WalletController Class Handle all functionality's related to Customer Wallet
  *
  * @package  	WalletController
  * @subpackage Web
  * @author   	Muhammad Zeeshan Tahir <muhammaad.zeeshan@cubixlabs.com>
  * @version  	1.0
  * @access   	public
  * @see      	http://www.example.com/pear
*/

class WalletController extends WebController
{
	
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
	 * @internal param the $Sets $__customer_wallet with wallet Transaction Helper object.
	 * @access public
	 */
	 
	public function __construct(Request $request)
    {
        parent::__construct($request);
		$this->_customer_wallet = new WalletTransaction();
		$this->_object_library_entity = new Entity();
		
	}
	

	 /**
     * Fetch the data of Customer from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of wallet page 
	 * @access public
     *
     */ 
	public function ShowWallet(Request $request) 
	{ 
	
		
		if(Validator::make($request->all(),[])->fails())
		{
			return trans('web.productError');
		}
		else 
		{	

			// User Verification
			
			$general_setting = new GeneralSetting();

			$customer_balance =  $this->_customer_wallet->getCurrentBalance($this->_customerId);
            $customer_balance = $general_setting->getPrettyPrice($customer_balance);
			return View::make('web/wallet',['customer_balance' 	=> 	$customer_balance]);
		}
	}
	
	
	
	
	/**
     * Fetch the data of Customer from using internal call ( API ) 
     *
     * @param Request $request the string to get the data from GET and POST Method
     * @return the view of wallet page 
	 * @access public
     *
     */ 
	public function getAllCustomerTransactions(Request $request) 
	{ 
	
		
		if(Validator::make($request->all(),[])->fails())
		{

			return trans('web.productError');
		}
		else
		{
		 
			$offset = $request->input('offset');
			$limit = $request->input('limit');
			//  User Verification

			 //	Get all transaction of customers
			$json = json_decode(
								json_encode(
									$this->_object_library_entity->apiList(
										[
											'entity_type_id'=> 'wallet_transaction',
											'limit'=>$limit,
											'offset'=>$offset,
											 'entity_id'=> '',
                                            'order_by' => 'entity_id',
                                            'sorting' => 'DESC',
                                            'customer_id' => $this->_customerId,
                                           // 'in_detail' => 0,
                                            'mobile_json' => 1
										]
									)
								),
								true
							);
           // echo "<pre>"; print_r( $json);exit;

            $customer_wallet  = isset($json['data']['wallet_transaction']) ? $json['data']['wallet_transaction'] : array() ;


			$customer_balance =  $this->_customer_wallet->getCurrentBalance($this->_customerId);

            $general_setting = new GeneralSetting();
            $customer_balance = $general_setting->getPrettyPrice($customer_balance);
		
			$data = [		
						'customer_wallet'	=>	$customer_wallet,
						'customer_balance' 	=> 	$customer_balance 
					]; 
					
			$data1['wallet'] = View::make('web/includes/account/wallet_history_detail', $data)->__toString();
			$data1['items'] = isset($json['data']['page']['total_records']) ? ceil($json['data']['page']['total_records']/10) : null;
            $data1['customer_balance'] = $customer_balance;
				
			return $data1;
		}
	}

	public function redeemGift(Request $request)
    {
        return View::make('web/gift_card',[]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function redeemCard(Request $request)
    {
        $rules  =  array(
            'gift_code' 	=>  'required'
        );

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return array(
                'error' =>1,
                'message'=> $validator->errors()->first());
        }else{
            $order_item_flat = new OrderItemFlat();
            $validate_gift =  $order_item_flat->validateGiftCard($request->gift_code);

            if($validate_gift){

                $credit = ($validate_gift->discount_price > 0) ? $validate_gift->discount_price : $validate_gift->price;

                //Add credit in wallet
                $pos_arr = [];
                $pos_arr['entity_type_id'] = 'wallet_transaction';
                $pos_arr['debit'] = "0";
                $pos_arr['credit'] = "$credit";
                $pos_arr['balance'] = '';
                $pos_arr['customer_id'] = $this->_customerId;
                $pos_arr['transaction_type'] = 'credit';
                $pos_arr['order_id'] = '';
                $pos_arr['mobile_json'] = 1;
                $pos_arr['login_entity_id'] = isset($this->_customerId) ? $this->_customerId : "";

                $entity_lib = new Entity();
                $data = $entity_lib->apiPost($pos_arr);

                if (isset($data)) {
                    //Update Customer Wallet
                    $wallet_transaction = new WalletTransaction();
                    $current_balance = $wallet_transaction->getCurrentBalance($this->_customerId);

                    $entity_model = new SYSEntity();
                    $entity_model->updateEntityAttrValue($this->_customerId, 'wallet', "$current_balance", 'customer');

                    //Update Order Item
                    $params = array(
                        'entity_type_id' => 'order_item',
                        'entity_id' => $validate_gift->entity_id,
                        'is_redeem' => 1
                    );

                    $entity_lib->apiUpdate($params);

                    return array(
                        'error' => 0,
                        'message'=> 'Gift code redeem successfully, Please check your wallet'
                    );
                }

            }
            else{
                return array(
                    'error' =>1,
                    'message'=> trans('system.product_code_redeem'));
            }
        }
    }
	

}


