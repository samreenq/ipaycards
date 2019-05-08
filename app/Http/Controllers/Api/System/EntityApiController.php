<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Http\Models\City;
use App\Http\Models\Custom\OrderItemFlat;
use App\Http\Models\SYSEntity;
use App\Http\Models\SYSTableFlat;
use App\Libraries\CustomHelper;
use App\Libraries\DeliveryProfessional;
use App\Libraries\Driver;
use App\Libraries\EntityNotification;
use App\Libraries\GeneralSetting;
use App\Libraries\ItemLib;
use App\Libraries\OrderHelper;
use App\Libraries\OrderStatus;
use App\Libraries\System\Entity;
use App\Libraries\Truck;
use App\Libraries\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use View;

Class EntityApiController extends Controller
{
	
	private $_apiData = array();
	private $_mobile_json = FALSE;
	private $_langIdentifier = 'system';
	
	public function __construct(Request $request)
	{
		parent::__construct($request);
		
		$this->_apiData['kick_user'] = 0;
		$this->_apiData['response'] = trans($this->_langIdentifier . ".error");
		$this->_mobile_json = intval($request->input('mobile_json', 0)) > 0 ? TRUE : FALSE;
	}
	
	/**
	 * getNotificationList
	 *
	 * @param {object} $request
	 */
	public function getNotificationList(Request $request)
	{
		$this->_apiData['error'] = 0;
		// validations
		$validator = Validator::make($request->all(), array(
			'entity_id' => "required|integer|exists:sys_entity,entity_id,deleted_at,NULL",
			'entity_type_id' => "required|integer|exists:sys_entity_type,entity_type_id,deleted_at,NULL"
		));
		if ( $validator->fails() ) {
			$this->_apiData['error'] = 1;
			$this->_apiData['message'] = $validator->errors()->first();
		} else {
			$checkEntity = \DB::table('sys_entity')
				->where('entity_type_id', $request->input('entity_type_id'))
				->where('entity_id', $request->input('entity_id'))
				->first();
			if ( count($checkEntity) ) {
				$this->_apiData['message'] = $this->_apiData['response'] = trans($this->_langIdentifier . ".success");
				$request_params = $request->all();
				
				$notification_lib = new EntityNotification();
				$response = $notification_lib->getNotificationList($request->all());
				
				$this->_apiData['error'] = $response['error'];
				$this->_apiData['message'] = $response['message'];
				
				if ( isset($response['data']) ) {
					$this->_apiData['data']['notification_list'] = $response['data']['records'];
					$this->_apiData['data']['page'] = $response['data']['page'];
				}
			} else {
				$this->_apiData['error'] = 1;
				$this->_apiData['message'] = "Invalid entity id";
			}
		}
		return $this->__ApiResponse($request, $this->_apiData);
	}
	
	/**
	 * update notification
	 *
	 * @param {object} $request
	 */
	public function updateNotification(Request $request)
	{
		$this->_apiData['error'] = 0;
		// validations
		$validator = Validator::make($request->all(), array(
			'entity_id' => "integer|exists:sys_entity,entity_id,deleted_at,NULL",
			'entity_type_id' => "integer|exists:sys_entity_type,entity_type_id,deleted_at,NULL",
			'entity_history_id' => "required|integer|exists:sys_entity_history,entity_history_id,deleted_at,NULL",
		));
		if ( $validator->fails() ) {
			$this->_apiData['error'] = 1;
			$this->_apiData['message'] = $validator->errors()->first();
		} else {
			$this->_apiData['error'] = 0;
			$this->_apiData['message'] = "success";
			$this->_apiData['data'] = [];
			//update history notification flag
			\DB::table('sys_entity_history')
				->where('entity_history_id', $request->input('entity_history_id'))
				->update([
					'is_read' => 1
				]);
		}
		return $this->__ApiResponse($request, $this->_apiData);
	}
	
	/**
	 * Get Customer Orders
	 *
	 * @param Request $request
	 *
	 * @return \App\Http\Controllers\Response
	 */
	public function orderSearch(Request $request)
	{
		$this->_apiData['error'] = 0;
		$error_messages = array(
			'end_date.date_greater' => trans('validation.date_greater', array( 'other' => 'start_date' ))
		);
		// validations
		$validator = Validator::make($request->all(), [
			'customer_id' => "required|integer|exists:customer_flat,entity_id,deleted_at,NULL",
			'start_date' => 'date|date_format:Y-m-d',
			'end_date' => 'date_format:Y-m-d|date_greater:start_date,' . $request->start_date,
		], $error_messages);
		
		
		if ( $validator->fails() ) {
			$this->_apiData['error'] = 1;
			$this->_apiData['message'] = $validator->errors()->first();
		} else {
			
			$this->_apiData['error'] = 0;
			$order_helper = new OrderHelper();
			$response = $order_helper->searchOrder($request->all());
			
			$this->_apiData['error'] = $response->error;
			if ( $response->error == 1 ) {
				$this->_apiData['message'] = $response->message;
			} else {
				$this->_apiData['message'] = $response->response;
			}
			
			if ( isset($response->data) ) {
				$this->_apiData['data'] = $response->data;
			}
		}
		
		return $this->__ApiResponse($request, $this->_apiData);
	}
	
	/**
	 * getCustomerGeneralSetting
	 *
	 * @param Request $request
	 *
	 * @return \App\Http\Controllers\Response
	 */
	public function getCustomerGeneralSetting(Request $request)
	{
		$this->_apiData['error'] = 0;
		// validations
		$validator = Validator::make($request->all(), [
			'entity_id' => "required|integer|exists:sys_entity,entity_id,deleted_at,NULL"
		]);
		if ( $validator->fails() ) {
			$this->_apiData['error'] = 1;
			$this->_apiData['message'] = $validator->errors()->first();
		} else {
			
			$entity_model = new SYSEntity();
			$entity = $entity_model->getData($request->entity_id, 11, TRUE);
			
			if ( $entity && ( isset($entity->auth) && $entity->auth->status != 1 ) ) {
				// kick user
				$this->_apiData['kick_user'] = 1;
				// message
				$this->_apiData['message'] = trans('system.your_account_is_baned_removed');
			} else {
				
				$this->_apiData['error'] = 0;
				//pending order count
				$order_helper = new OrderHelper();
				$getPendingOrder = $order_helper->getPendingOrder($request);
				//unread notification
				$notification_lib = new EntityNotification();
				$response = $notification_lib->getNotificationList($request->all(), TRUE);
				//general setting
				$general_setting = new GeneralSetting();
				$getSetting = $general_setting->getSetting();
				
				$this->_apiData['error'] = 0;
				$this->_apiData['message'] = "success";
				$this->_apiData['data']['setting']['general_setting'] = $getSetting;
				$this->_apiData['data']['setting']['pending_orders'] = $getPendingOrder;
				$this->_apiData['data']['setting']['unread_notification'] = $response['totalRecord'];
			}
			
		}
		
		return $this->__ApiResponse($request, $this->_apiData);
	}

	
	/**
	 * @param Request $request
	 *
	 * @return \App\Http\Controllers\Response
	 * @throws \Exception
	 */
	public function redeemGiftCard(Request $request)
	{
		$this->_apiData['error'] = 0;
		// validations
		$validator = Validator::make($request->all(), [
			'customer_id' => "required|integer|exists:customer_flat,entity_id,deleted_at,NULL",
			'product_code' => "required",
		]);
		
		if ( $validator->fails() ) {
			$this->_apiData['error'] = 1;
			$this->_apiData['message'] = $validator->errors()->first();
		} else {
			
			$this->_apiData['error'] = 0;

			$order_item_flat = new OrderItemFlat();
			$validate_gift = $order_item_flat->validateGiftCard($request->product_code);
			// echo "<pre>"; print_r($validate_gift); exit;
			if ( $validate_gift ) {
				
				$credit = ( $validate_gift->discount_price > 0 ) ? $validate_gift->discount_price : $validate_gift->price;
				
				//Add credit in wallet
				$pos_arr = [];
				$pos_arr['entity_type_id'] = 'wallet_transaction';
				$pos_arr['debit'] = "0";
				$pos_arr['credit'] = "$credit";
				$pos_arr['balance'] = '';
				$pos_arr['customer_id'] = $request->customer_id;
				$pos_arr['transaction_type'] = 'credit';
				$pos_arr['wallet_source'] = 'gift_card';
				$pos_arr['order_id'] = '';
				$pos_arr['mobile_json'] = 1;
				$pos_arr['login_entity_id'] = isset($request->customer_id) ? $request->customer_id : "";
				
				$entity_lib = new Entity();
				$wallet_post = $entity_lib->apiPost($pos_arr);
				$wallet_post = json_decode(json_encode($wallet_post),true);
				
				if ( isset($wallet_post['error']) && $wallet_post['error'] == 0) {
					//Update Customer Wallet
					/*$wallet_transaction = new WalletTransaction();
					$current_balance = $wallet_transaction->getCurrentBalance($request->customer_id);
					
					$entity_model = new SYSEntity();
					$entity_model->updateEntityAttrValue($request->customer_id, 'wallet', "$current_balance", 'customer');
					*/
					//Update Order Item
					$params = array(
						'entity_type_id' => 'order_item',
						'entity_id' => $validate_gift->entity_id,
						'is_redeem' => 1
					);
					
					$data = $entity_lib->apiUpdate($params);

                   // echo "<pre>"; print_r($wallet_post); exit;
					$this->_apiData['error'] = 0;
					$this->_apiData['message'] = trans('system.success');
					$this->_apiData['data'] = $wallet_post['data']['wallet_transaction'];
				} else {
					// by SK : response requested by Mehran
					$this->_apiData['error'] = 1;
					$this->_apiData['message'] = $wallet_post['message'];
				}
				
			} else {
				$this->_apiData['error'] = 1;
				$this->_apiData['message'] = trans('system.product_code_redeem');
			}
			
		}
		
		return $this->__ApiResponse($request, $this->_apiData);
		
	}
	
}
