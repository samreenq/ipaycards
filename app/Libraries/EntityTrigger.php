<?php namespace App\Libraries;

use App\Http\Models\Custom\OrderFlat;
use App\Http\Models\FlatTable;
use App\Http\Models\Notification;
use App\Http\Models\SYSEntity;
use App\Http\Models\SYSEntityAuth;
use App\Http\Models\SYSEntityHistory;
use App\Http\Models\SYSTableFlat;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Class CustomHelper
 */
Class EntityTrigger
{
	public $entityRequest = [];
	public $_entityData = [];
	private $_apiUrl = '';
	private $_apiUrlListing = '';
	private $_apiUrlUpdate = '';
	private $_tempData = [];
	private $_isUpdateAuth = 0;
	private $_entityLib;
	
	/**
	 * Constructor
	 *
	 * @param string $url URL
	 */
	public function __construct()
	{
		$this->_apiUrl = config("system.API_SYSTEM_ENTITIES");
		$this->_apiUrlListing = $this->_apiUrl . 'listing';
		$this->_apiUrlUpdate = $this->_apiUrl . 'update';
		$this->_entityLib = new Entity();
	}
	
	/**
	 * @param Request $request
	 */
	public function customNotificationAddTrigger($request, $response_post = FALSE)
	{
		return;
		$request = is_array($request) ? (object) $request : $request;
		$entity_model = new Entity();
		$notification_model = new Notification;
		$notification_wildcards = new NotificationWildcard();
		
		if ( isset($request->customer_ids) ) {
			
			$customer_ids = explode(',', $request->customer_ids);
			
			if ( count($customer_ids) > 0 ) {
				
				foreach ( $customer_ids as $customer_id ) {
					$entity = $entity_model->getData($customer_id);
					$entity = json_decode(json_encode($entity));
					
					if ( isset($entity->auth) ) {
						if ( isset($entity->auth->device_type) && isset($entity->auth->device_token) ) {
							
							if ( in_array($entity->auth->device_type, [ 'android', 'ios' ]) ) {
								
								if ( isset($entity->attributes->is_notify->value) && $entity->attributes->is_notify->value == 1 ) {
									
									//Set Customer data to replace wildcards
									$replace = new \StdClass();
									$replace->user_name = isset($entity->attributes->first_name) ? $entity->attributes->first_name : "";
									
									if ( isset($entity->attributes->last_name) && !empty($entity->attributes->last_name) ) {
										$replace->user_name .= " ";
										$replace->user_name .= isset($entity->attributes->last_name) ? $entity->attributes->last_name : "";
									}
									
									$replace->email = isset($entity->auth->email) ? $entity->auth->email : "";
									$replace->mobile_no = isset($entity->auth->mobile_no) ? $entity->auth->mobile_no : "";
									
									//Replace WildCards
									$subject = $notification_wildcards->replaceNotifyText($replace, $request->subject);
									$message = $notification_wildcards->replaceNotifyText($replace, $request->message);
									
									// prepare notification data
									$notification_data = [
										"title" => $subject,
										"body" => $message,
										"key_code" => '',
										"sound" => "",
										"badge" => "",
										//"user" => $user ? $user : array(),
										//"target_user" => $target_user ? $target_user : array(),
										// "user_id" => $actor_entity->entity_id,
										// "target_user_id" => isset($target_entity->entity_id) ? $target_entity->entity_id : "",
										// "user_name" => isset($actor->first_name) ? $actor->first_name : "",
										//  "target_user_name" => "",
										"my_custom_data" => [
											'entity_id' => $customer_id,
											"user_name" => $replace->user_name,
											'identifier' => 'custom_notification'
										]
									];
									
									// send
									//if ($entity->auth->device_type == "android") {
									// echo "<pre>"; print_r($notification_data);
									$ret = $notification_model->pn_android($entity->auth->device_token, $notification_data);
									// echo "<pre>"; print_r($ret); exit;
									// } else {
									//   $notification_model->pn_ios($entity->auth->device_token, $notification_data);
									// }
									
								}
							}
							
						}
					}
					
				}
			}
		}
		
		return;
	}
	
	/**
	 * Before post order
	 *
	 * @param Request $request
	 *
	 * @return array|bool
	 */
	public function orderBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		//echo "<pre>"; print_r($request); exit;
		$order_helper = new OrderHelper();
		
		if ( isset($request->order_status) ) {
			
			if ( !is_numeric($request->order_status) ) {
				
				if ( empty($request->order_status) ) {
					$status_key = 'pending';
				} else {
					$status_key = $request->order_status;
				}
				
				$status_data = $order_helper->getOrderStatusData($status_key);
				if ( $status_data ) {
					// $request->request->add(['order_status' => $status_data->entity_id]) ;
					$return = [ 'order_status' => $status_data->entity_id ];
				}
			}
		}
		
		
		// echo "<pre>"; print_r($return); exit;
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	/**
	 * Update order trigger before save
	 *
	 * @param Request $request
	 *
	 * @return array|bool
	 */
	public function orderBeforeSaveTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		$post_param = (array) $request;
		$order_helper = new OrderHelper();
		
		if ( isset($request->order_status) ) {
			
			if ( !is_numeric($request->order_status) ) {
				
				if ( !empty($request->order_status) ) {
					$status_key = $request->order_status;
					
					$status_data = $order_helper->getOrderStatusData($status_key);
					if ( $status_data ) {
						$return['order_status'] = $status_data->entity_id;
						// $request->request->add(['order_status' => $status_data->entity_id]);
					}
				}
			}
		}
		
		
		if ( isset($request->entity_id) ) {
			
			//Update Order Number
			if ( isset($request->order_number) && empty($request->order_number) ) {
				$return['order_number'] = config('constants.ORDER_SERIES') . $request->entity_id;
			}
			
			//Save Previous Order in temp
			$pos_arr = [];
			$pos_arr['entity_type_id'] = $request->entity_type_id;
			$pos_arr['entity_id'] = $request->entity_id;
			$pos_arr['hook'] = "order_item";
			$pos_arr['inner_response'] = 1;
			//$pos_arr['mobile_json'] = 1;
			// $pos_arr['in_detail'] = 0;
			$data = (object) $this->_entityLib->apiGet($pos_arr);
			$data = json_decode(json_encode($data));
			//$data = CustomHelper::internalCall($request, $this->_apiUrl, 'GET', $pos_arr, FALSE);
			if ( isset($data->error) && $data->error == 0 ) {
				
				if ( isset($this->_tempData['previous_order']) ) {
					unset($this->_tempData['previous_order']);
				}
				$this->_tempData['previous_order'] = $data->data->entity;
			}
			//  $request->replace($post_param);
			
		}
		
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	
	/**
	 * Customer before post
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function customerBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		//set Full Name
		$return['full_name'] = CustomHelper::setFullName($request);
		$return['refer_friend_code'] = str_random(8);
		return $return;
	}
	
	/**
	 * Customer before update
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function customerBeforeSaveTrigger($request)
	{
		$return = array();
		$request = is_array($request) ? (object) $request : $request;
		
		//set Full Name
		if ( isset($request->first_name) && isset($request->last_name) ) {
			$return['full_name'] = CustomHelper::setFullName($request);
		}
		
		if ( !isset($request->refer_friend_code) ) {
			$return = [ 'refer_friend_code' => str_random(8) ];
		}
		
		//Update auth status for customer entity
		//if  requested status is different from the status that has saved
		if ( isset($request->entity_id) && isset($request->user_status) ) {
			$this->_checkIfUpdateUserStatus($request);
		}
		
		if ( count($return) > 0 )
			return $return;
	}
	
	/**
	 * Customer post trigger
	 *
	 * @param Request $request
	 */
	
	public function customerAddTrigger($request, $entity_id = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->refer_friend_code_applied) ) {
			
			if ( !empty($request->refer_friend_code_applied) ) {
				//check refer code and get entity id and update loyalty points
				$flat_model = new SYSTableFlat('customer');
				$friend_id = $flat_model->columnValueByWhere('refer_friend_code', $request->refer_friend_code_applied, 'entity_id');
				
				if ( $friend_id ) {
					
					// $entity_model = new SYSEntity();
					//$entity =  $entity_model->getData($entity_id);
					
					//Get General setting
					$flat_model = new SYSTableFlat('general_setting');
					$setting_raw = $flat_model->getAll();
					
					if ( isset($setting_raw[0]) ) {
						
						$general_setting = $setting_raw[0];
						
						$refer_friend_credit = isset($general_setting->refer_friend_credit) ? $general_setting->refer_friend_credit : 0;
						if ( $refer_friend_credit > 0 ) {
							
							$params = array(
								'entity_type_id' => 51,
								'customer_id' => $entity_id,
								'credit' => "$refer_friend_credit",
								'debit' => "0",
								'wallet_source' => 'refer_friend',
								'transaction_type' => 'credit'
							);
							
							$entity_lib = new Entity();
							$entity_lib->apiPost($params);
							// echo "<pre>"; print_r($item); exit;
						}
						
						
						/*   if ($number_of_refer_friend > 0) {
  
							  $loyalty_points_refer_friend = isset($general_setting->loyalty_points_refer_friend) ? $general_setting->loyalty_points_refer_friend : 1;
  
							  //Add loyalty points for refer friend
							  $refer_friend_points = round($loyalty_points_refer_friend / $number_of_refer_friend, 2);
  
							  if ($refer_friend_points > 0) {
								  $field = 'loyalty_points';
								  $value = $refer_friend_points;
								  $entity_model->updateEntityAttributeValue($entity_id, $field, $value, '+', 'customer');
							  }
						  }*/
						
						
					}
					
				} //end of entity id
				
			}
		}
	}
	
	/**
	 * lead order before post trigger
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function leadOrderBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		if ( isset($request->customer_id) ) {
			
			if ( !empty($request->customer_id) ) {
				$transaction_reference = $request->customer_id . '-' . time();
				
				return [ 'transaction_reference' => $transaction_reference ];
			}
			
		}
		
	}
	
	/**
	 * Customer verify trigger
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function customerVerifyTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		$response['error'] = 0;
		
		return $response;
	}
	
	/**
	 * @param $request
	 * @param bool $entity_id
	 *
	 * @throws \Exception
	 */
	public function orderAddTrigger($request, $entity_id = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		$entity_lib = new Entity();
		//echo "<pre>"; print_r($request); exit;
		//Update Order Number
		$order_series = config('constants.ORDER_SERIES') . $entity_id;
		$params = [];
		$params['entity_type_id'] = 15;
		$params['entity_id'] = $entity_id;
		$params['order_number'] = "$order_series";
		
		/* $subtotal = 0;
		 if(isset($request->depend_entity) && count($request->depend_entity) > 0){
 
			 foreach($request->depend_entity as $depend_entity){
 
				 if( $depend_entity['discount_price'] > 0){
					 $subtotal += $depend_entity['discount_price']*$depend_entity['quantity'];
				 }else{
					 $subtotal += $depend_entity['price']*$depend_entity['quantity'];
				 }
			 }
		 }*/
		
		// $grand_total = $subtotal;
		//$params['subtotal'] = "$subtotal";
		// $params['grand_total'] = "$grand_total";
		$response = $entity_lib->apiUpdate($params);
		
		//Save Order History
		$post_arr = [];
		$post_arr['entity_type_id'] = 68;
		$post_arr['order_id'] = $entity_id;
		$post_arr['order_status'] = $request->order_status;
		$entity_lib->doPost($post_arr);
		unset($post_arr);
		
		
		$entity_model = new SYSEntity();
		
		//Insert wallet Transaction
		if ( isset($request->wallet) && isset($request->customer_id) ) {
			
			if ( !empty($request->wallet) && !empty($request->customer_id) ) {
				
				$pos_arr = [];
				$pos_arr['entity_type_id'] = 51;
				$pos_arr['credit'] = "0";
				$pos_arr['debit'] = "$request->wallet";
				$pos_arr['balance'] = '';
				$pos_arr['customer_id'] = $request->customer_id;
				$pos_arr['transaction_type'] = 'debit';
				$pos_arr['wallet_source'] = 'order';
				$pos_arr['order_id'] = $entity_id;
				$pos_arr['mobile_json'] = $request->mobile_json;
				$pos_arr['login_entity_id'] = isset($request->login_entity_id) ? $request->login_entity_id : "";
				$data = $entity_lib->doPost($pos_arr);
				
				if ( isset($data) ) {
					//Update Customer Wallet
					$wallet_transaction = new WalletTransaction();
					$current_balance = $wallet_transaction->getCurrentBalance($request->customer_id);
					$entity_model->updateEntityAttrValue($request->customer_id, 'wallet', "$current_balance", 'customer');
				}
				
				
			}
		}
		
		
	}
	
	/**
	 * @param $request
	 * @param $depend_entity_raw
	 *
	 * @return array
	 */
	public function orderItemBeforePostTrigger($request, $depend_entity_raw = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		$depend_entity_raw = is_array($depend_entity_raw) ? (object) $depend_entity_raw : $depend_entity_raw;
		
		if ( $depend_entity_raw ) {
			
			if ( $depend_entity_raw->product_id > 0 && $depend_entity_raw->product_name == '' )
				$return['product_name'] = ItemLib::getItemName($depend_entity_raw->product_id);
			
		} else {
			
			if ( isset($request->product_id) ) {
				if ( $request->product_id > 0 && $request->product_name == '' )
					$return['product_name'] = ItemLib::getItemName($request->product_id);
			}
			
			// echo "<pre>"; print_r($return); exit;
		}
		
		$return['is_redeem'] = 0;
		return isset($return) ? $return : array();
	}
	
	/**
	 * @param $request
	 * @param $depend_entity
	 *
	 * @throws \Exception
	 */
	public function orderUpdateTrigger($request, $depend_entity)
	{
		$request = is_array($request) ? (object) $request : $request;
		$post_param = (array) $request;
		
		$previous_order = $this->_tempData['previous_order'];
		
		if ( isset($request->truck_id) && isset($previous_order->attributes->truck_id->id) ) {
			
			if ( trim($request->truck_id) != trim($previous_order->attributes->truck_id->id) ) {
				$get_arr = [];
				$get_arr['entity_type_id'] = 'truck';
				$get_arr['entity_id'] = $request->truck_id;
				$get_arr['in_detail'] = 1;
				$get_arr['mobile_json'] = 1;
				$selected_truck = $this->_entityLib->doGet($get_arr);
				$selected_truck = json_decode(json_encode($selected_truck));
				
				//Get Order Truck ID
				$order_item_flat = new SYSTableFlat('order_trucks');
				$where_condition = ' order_id = ' . $previous_order->entity_id;
				$order_truck = $order_item_flat->getColumnByWhere($where_condition, 'entity_id');
				
				//Update Order Truck
				// echo "<pre>"; print_r($selected_truck);
				$post_arr = [];
				$post_arr['entity_type_id'] = 65;
				$post_arr['truck_id'] = $selected_truck->entity_id;
				$post_arr['order_id'] = $previous_order->entity_id;
				$post_arr['base_fee'] = $selected_truck->base_fee;
				$post_arr['charge_per_minute'] = $selected_truck->charge_per_minute;
				$post_arr['volume'] = $selected_truck->volume;
				//  $post_arr['vehicle_code'] = $selected_truck->vehicle_code;
				$post_arr['min_weight'] = $selected_truck->min_weight;
				$post_arr['max_weight'] = $selected_truck->max_weight;
				$post_arr['truck_class_id'] = $selected_truck->truck_class_id->id;
				// echo "<pre>"; print_r($post_arr); exit;
				
				if ( $order_truck ) {
					$post_arr['entity_id'] = $order_truck->entity_id;
					$response = $this->_entityLib->doUpdate($post_arr);
				}
				// echo "<pre>"; print_r($response); exit;
				
				
			}
			
			if ( isset($this->_tempData['order_status_data']) ) {
				unset($this->_tempData['order_status_data']);
			}
			
		}
		
		
		//Update vehicle and driver
		
		if ( ( isset($request->truck_vehicle) && !empty($request->truck_vehicle) )
			&& ( $request->truck_vehicle != $previous_order->attributes->vehicle_id->id )
		) {
			
			//Decline Order from previous driver
			$arr = [];
			$arr['entity_type_id'] = 68;
			$arr['order_id'] = $previous_order->entity_id;
			$arr['driver_id'] = $previous_order->attributes->driver_id->id;
			$arr['order_status'] = 'declined';
			$arr_response = $this->_entityLib->apiPost($arr);
			
			
			//assign vehicle
			$flat = new SYSTableFlat('vehicle');
			$where_condition = ' entity_id = ' . $request->truck_vehicle;
			$vehicle_raw = $flat->getColumnByWhere($where_condition, 'driver_id');
			
			$arr = [];
			$arr['entity_type_id'] = 68;
			$arr['order_id'] = $previous_order->entity_id;
			$arr['driver_id'] = $vehicle_raw->driver_id;
			$arr['order_status'] = 'assigned';
			$arr_response = $this->_entityLib->apiPost($arr);
			
		}
		
		if ( isset($request->order_status) && !empty($request->order_status) && isset($request->customer_id) ) {
			//notify customer
			$other_data['entity_type_id'] = $request->entity_type_id;
			$other_data['actor_entity_type_id'] = 'customer';
			$other_data['extension_ref_table'] = 'customer_flat';
			$other_data['extension_ref_id'] = $request->customer_id;
			$timestamp = date("Y-m-d H:i:s");
			$sys_history = new SYSEntityHistory();
			$sys_history->logHistory('order_update_customer_notify', $request->entity_id, $request->customer_id, $other_data, $timestamp, $request);
		}
		
		
		//Save Order Revision
		/*       if (isset($this->_tempData['previous_order']) &&  (isset($request->add_revision) && $request->add_revision == 1)) {
	   
				   $sys_entity_type_model = new SYSEntityType();
				   $entity_type_id = $sys_entity_type_model->getIdByIdentifier('order_revision');
	   
				   $order_detail = json_encode($previous_order);
	   
				   $pos_arr = [];
				   $pos_arr['entity_type_id'] = $entity_type_id;
				   $pos_arr['order_id'] = $previous_order->entity_id;
				   $pos_arr['customer_id'] = isset($previous_order->customer_id->id) ? $previous_order->customer_id->id : '';
				   $pos_arr['grand_total'] = "$previous_order->grand_total";
				   $pos_arr['order_detail'] = $order_detail;
				   $pos_arr['inner_response'] = 1;
				   $pos_arr['mobile_json'] = 1;
				   $entity_lib = new Entity();
				   $entity_lib->apiPost($pos_arr);
			   }*/
		
		
	}
	
	/**
	 * @param $request
	 *
	 * @return array
	 */
	public function orderItemBeforeSaveTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		// echo "<pre>"; print_r($request); exit;
		if ( isset($request->product_id) ) {
			if ( $request->product_id > 0 && $request->product_name == '' )
				$return['product_name'] = ItemLib::getItemName($request->product_id);
		}
		
		
		return isset($return) ? $return : array();
	}
	
	/**
	 * business user post trigger
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function businessUserBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		//set Full Name
		$return['full_name'] = CustomHelper::setFullName($request);
		return $return;
	}
	
	/**
	 * business user update trigger
	 *
	 * @param $request
	 *
	 * @return array
	 */
	public function businessUserBeforeSaveTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$return = array();
		//set Full Name
		if ( isset($request->first_name) && isset($request->last_name) ) {
			$return['full_name'] = CustomHelper::setFullName($request);
		}
		
		//Update auth status for customer entity
		//if  requested status is different from the status that has saved
		if ( isset($request->entity_id) && isset($request->user_status) ) {
			$this->_checkIfUpdateUserStatus($request);
		}
		
		if ( count($return) > 0 )
			return $return;
	}
	
	/**
	 * Update auth status for customer entity
	 * if customer requested status is different from the status that has saved
	 *
	 * @param $request
	 */
	public function customerUpdateTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( $this->_isUpdateAuth == 1 && ( isset($request->user_status) && isset($this->_authID) ) ) {
			$this->_updateAuthStatus($this->_authID, $request->user_status);
			$this->_unsetAuthFlags();
		}
		
	}
	
	/**
	 * Update auth status for customer entity
	 * if customer requested status is different from the status that has saved
	 *
	 * @param $request
	 */
	public function businessUserUpdateTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( $this->_isUpdateAuth == 1 && ( isset($request->user_status) && isset($this->_authID) ) ) {
			$this->_updateAuthStatus($this->_authID, $request->user_status);
			$this->_unsetAuthFlags();
		}
		
	}
	
	/**
	 * update entity auth status
	 *
	 * @param $auth_id
	 * @param $status
	 */
	private function _updateAuthStatus($auth_id, $status)
	{
		//update auth status
		$auth_model = new SYSEntityAuth();
		$record = $auth_model->get($auth_id);
		$record->status = $status;
		$record->updated_at = date("Y-m-d H:i:s");
		// reset token
		$auth_model->set($record->entity_auth_id, (array) $record);
	}
	
	/**
	 * get user status and check with requested status
	 * and set _isUpdateAuth to 1 or 0
	 *
	 * @param $request
	 */
	private function _checkIfUpdateUserStatus($request)
	{
		$sys_entity_model = new Entity();
		$entity_data = $sys_entity_model->getData($request->entity_id);
		//print_r($entity_data->attributes); exit;
		if ( isset($entity_data->attributes->user_status) ) {
			// echo $entity_data->attributes->user_status;
			// echo  $request->user_status; exit;
			if ( ( isset($entity_data->attributes->user_status->value)
					&& $entity_data->attributes->user_status->value != $request->user_status )
				|| ( !isset($entity_data->attributes->user_status->value) )
			) {
				$this->_isUpdateAuth = 1;
				$this->_authID = $entity_data->entity_auth_id;
			}
		}
	}
	
	/**
	 * Unset auth flags those are set to update user status
	 */
	private function _unsetAuthFlags()
	{
		$this->_isUpdateAuth = 0;
		unset($this->_authID);
	}
	
	/**
	 * coupon verify trigger
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function couponVerifyTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$response['error'] = 0;
		
		if ( strtotime($request->start_date) > strtotime($request->coupon_expiry) ) {
			$response['error'] = TRUE;
			$response['message'] = trans('system.expiry_must_greater_start_date');
			return $response;
		}
		
	}
	
	
	/**
	 * Coupon before post trigger
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function couponBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		return [ 'coupon_code' => str_random(8) ];
	}
	
	/**
	 * Get product max price and send with list
	 *
	 * @param $request
	 * @param $response
	 *
	 * @return array
	 */
	public function productTagsListingTrigger($request, $response)
	{
		
		if ( isset($response) ) {
			$total_records = FALSE;
			
			if ( isset($response['data'][0]) )
				$total_records = TRUE;
			
			if ( $total_records ) {
				$product_helper_obj = new ProductHelper();
				$max_price = $product_helper_obj->getMaxPriceByProductType('product');
				return [ 'key' => 'max_price', 'data' => $max_price ];
			}
		}
	}
	
	
	/**
	 * On Order Discussion send notification to customer
	 *
	 * @param $request
	 * @param bool $entity_id
	 */
	public function orderDiscussionAddTrigger($request, $entity_id = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( ( isset($request->visible_to_customer) && $request->visible_to_customer == 1 )
			&& ( isset($request->order_id) && !empty($request->order_id) ) ) {
			
			//Get customer info
			$flat_table_model = new FlatTable();
			$customer_raw = $flat_table_model->getCustomerColumnsByOrder($request->order_id);
			
			if ( $customer_raw ) {
				
				if ( isset($customer_raw->customer_id) && ( isset($customer_raw->is_notify) && $customer_raw->is_notify == 1 ) ) {
					$customer_id = $customer_raw->customer_id;
					
					$sys_history = new SYSEntityHistory();
					
					$other_data['entity_type_id'] = $request->entity_type_id;
					$other_data['actor_entity_type_id'] = 'customer';
					$other_data['against_entity_type_id'] = 15;
					$other_data['against_entity_id'] = $request->order_id;
					$other_data['extension_ref_table'] = 'order_discussion_flat';
					$other_data['extension_ref_id'] = $entity_id;
					$timestamp = date("Y-m-d H:i:s");
					
					$sys_history->logHistory('order_discussion_add', $entity_id, $customer_id, $other_data, $timestamp, $request);
				}
			}
			
		}
	}
	
	
	/**
	 * @param $request
	 *
	 * @throws \Exception
	 */
	public function orderHistoryAddTrigger($request, $entity_id = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		//Update Order status / Driver
		$order_status_lib = new OrderStatus();
		$order_response = $order_status_lib->updateOrderStatus($request);
		
	}
	
	/**
	 * Before post order
	 *
	 * @param Request $request
	 *
	 * @return array|bool
	 */
	public function orderHistoryBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->order_status) ) {
			
			if ( !is_numeric($request->order_status) ) {
				
				$order_helper = new OrderHelper();
				$status_data = $order_helper->getOrderStatusData($request->order_status);
				if ( $status_data ) {
					// $request->request->add(['order_status' => $status_data->entity_id]) ;
					$return = [ 'order_status' => $status_data->entity_id ];
				}
			} else {
				$order_helper = new SYSTableFlat('order_statuses');
				$status_data = $order_helper->getColumnByWhere(' entity_id = ' . $request->order_status, '*');
				
			}
			
			if ( isset($status_data->keyword) )
				$return['status_keyword'] = $status_data->keyword;
			
		}
		
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	/**
	 * @param $request
	 *
	 * @return array|bool
	 */
	public function orderBeforeListingTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->order_status) ) {
			
			if ( !is_numeric($request->order_status) ) {
				
				$status_key = $request->order_status;
				$order_helper = new OrderHelper();
				$status_data = $order_helper->getOrderStatusData($status_key);
				if ( $status_data ) {
					// $request->request->add(['order_status' => $status_data->entity_id]) ;
					$return = [ 'order_status' => $status_data->entity_id ];
				}
			}
		}
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	/**
	 * check if status is not pending/confirmed then validate
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function _orderHistoryVerifyTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$response['error'] = 0;
		
		if ( isset($request->order_status) && !empty($request->order_status) ) {
			
			$flat_model = new SYSTableFlat('order_statuses');
			$where_condition = ' entity_id = ' . $request->order_status;
			$row = $flat_model->getColumnByWhere($where_condition, 'keyword');
			
			if ( isset($row->keyword) ) {
				if ( !in_array($row->keyword, array( 'pending', 'confirmed', 'cancelled' )) ) {
					
					if ( isset($request->is_admin_update) && $request->is_admin_update == 1 ) {
						if ( !isset($request->vehicle_id) || empty($request->vehicle_id) ) {
							$response['error'] = TRUE;
							$response['message'] = trans('system.field_required', array( 'field' => 'vehicle_id' ));
							return $response;
						}
					} else {
						if ( !isset($request->driver_id) || empty($request->driver_id) ) {
							$response['error'] = TRUE;
							$response['message'] = trans('system.field_required', array( 'field' => 'driver_id' ));
							return $response;
						}
					}
					
					
				}
			}
			
		}
		
	}
	
	
	/**
	 * @param $request
	 *
	 * @return mixed
	 */
	
	public function customNotificationVerifyTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		$response['error'] = 0;
		
		if ( in_array(trim($request->target_user_entity_type_id), array( "customer", "driver" )) ) {
			
			if ( empty($request->target_user_entity_id) ) {
				
				$response['error'] = TRUE;
				$response['message'] = trans('system.entity_is_required ', array( 'entity' => 'Target User' ));
				return $response;
			}
			
		}
	}
	
	/**
	 * @param $request
	 *
	 * @return array|bool
	 */
	public function productBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$return = $this->_setRetailPrice($request);
		
		if ( $request->item_type == 'gift_card' ) {
			$return['category_id'] = $request->gift_category_id;
		}
		
		if ( $request->item_type == 'deal' ) {
			$return['category_id'] = "7";
		}
		
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	/**
	 * @param $request
	 *
	 * @return array|bool
	 */
	public function productBeforeSaveTrigger($request)
	{
		// by SK : fix for rating update
		if ( !isset($request->item_type) )
			return FALSE;
		
		$request = is_array($request) ? (object) $request : $request;
		$return = $this->_setRetailPrice($request);
		
		if ( $request->item_type == 'gift_card' ) {
			$return['category_id'] = $request->gift_category_id;
		}
		
		if ( $request->item_type == 'deal' ) {
			$return['category_id'] = "7";
		}
		
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	
	/**
	 * Product Add Trigger
	 *
	 * @param Request $request
	 */
	public function _productAddTrigger($request, $response_post = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		if ( isset($request->category_id) ) {
			//Get category parent ids
			$category_ids = explode(',', $request->category_id);
			
			$category_helper = new CategoryHelper();
			$category_helper->adjustProductCategoryParentCount($category_ids);
			
		}
		
	}
	
	/**
	 * Product Update Trigger
	 *
	 * @param Request $request
	 */
	public function _productUpdateTrigger($request, $depend_entity)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->category_id) ) {
			
			$category_ids = explode(',', $request->category_id);
			$category_helper = new CategoryHelper();
			
			//First decrement category count
			if ( isset($this->_entityData) ) {
				$entity_data = (object) $this->_entityData;
				
				if ( isset($entity_data->attributes['category_id']) ) {
					
					$previous_category_ids = [];
					
					if ( isset($entity_data->attributes['category_id'][0]) ) {
						foreach ( $entity_data->attributes['category_id'] as $category ) {
							if ( isset($category->category_id) )
								$previous_category_ids[] = $category->category_id;
						}
					}
					
					if ( count($previous_category_ids) > 0 )
						$category_helper->adjustProductCategoryParentCount($previous_category_ids, '-');
				}
			}
			
			// print_r($previous_category_ids);
			
			//Now increment the category count for product
			if ( count($category_ids) > 0 ) {
				$category_helper->adjustProductCategoryParentCount($category_ids);
			}
		}
		//  print_r($category_ids);
		
		
	}
	
	/**
	 * Set Retail Price by adding margin
	 *
	 * @param $request
	 *
	 * @return array|bool
	 */
	private function _setRetailPrice($request)
	{
		$return = FALSE;
		$general_setting_lib = new GeneralSetting();
		$setting = $general_setting_lib->getSetting();
		
		if ( $request->item_type == 'deal' ) {
			$return = [ 'price' => $request->buying_price ];
		} else {
			if ( isset($setting->selling_price_margin) && !empty($request->buying_price) ) {
				
				if ( !empty($setting->selling_price_margin) ) {
					
					$margin = $request->buying_price * ( $setting->selling_price_margin / 100 );
					$return = [ 'price' => $request->buying_price + $margin ];
				} else {
					$return = [ 'price' => $request->buying_price ];
				}
			}
		}
		
		return $return;
	}
	
	/**
	 * @param $request
	 *
	 * @return array|bool
	 */
	public function inventoryBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->voucher_code) && !empty($request->voucher_code) ) {
			
			$product_code_arr = preg_split("/\r\n|\n|\r/", $request->voucher_code);
			$return = [ 'voucher_code' => implode(',', $product_code_arr) ];
		}
		
		if ( isset($return) ) {
			return $return;
		}
		
		return FALSE;
	}
	
	/**
	 * @param $request
	 * @param bool $entity_id
	 */
	public function inventoryAddTrigger($request, $entity_id = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( isset($request->voucher_code) ) {
			
			$entity_lib = new Entity();
			
			$product_codes = explode(',', $request->voucher_code);
			
			if ( count($product_codes) > 0 ) {
				
				foreach ( $product_codes as $key => $product_code ) {
					
					if ( $key == 0 ) {
						$params = array(
							'entity_type_id' => 73,
							'entity_id' => $entity_id,
							'voucher_code' => Crypt::encrypt($product_code)
						);
						
						$response = $entity_lib->apiUpdate($params);
						
					} else {
						$request->voucher_code = Crypt::encrypt($product_code);
						$params = is_object($request) ? (array) $request : $request;
						$response = $entity_lib->apiPost($params);
					}
					
				} // end of foreach loop
			}
		}
	}
	
	/**
	 * @param $request
	 * @param $depend_entity_request
	 * @param $depend_entity_response
	 */
	public function orderItemAddTrigger($request, $depend_entity_request = FALSE, $depend_entity_response = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		
		if ( $depend_entity_request && $depend_entity_response ) {
			
			$depend_entity_request = is_array($depend_entity_request) ? (object) $depend_entity_request : $depend_entity_request;
			$depend_entity_response = is_array($depend_entity_response) ? (object) $depend_entity_response : $depend_entity_response;
			//  echo "<pre>"; print_r($depend_entity_request);
			if ( isset($depend_entity_response->entity->entity_id) ) {
				
				if ( isset($depend_entity_request->product_id) && !empty($depend_entity_request->product_id) ||
					isset($depend_entity_request->deal_id) && !empty($depend_entity_request->deal_id) ) {
					
					$order_item_lib = new OrderItem();
					if ( !isset($depend_entity_request->item_type) ) {
						$depend_entity_request->item_type = 'product';
					}
					
					Switch ( $depend_entity_request->item_type ) {
						case 'gift_card':
							$order_item_lib->addGiftCardStock($depend_entity_response->entity->entity_id, $depend_entity_request->product_id);
							break;
						case 'deal':
							$order_id = $depend_entity_response->entity->attributes->order_id->id;
							$order_item_lib->addDealStock($order_id, $depend_entity_response->entity->entity_id, $depend_entity_request->product_id);
							break;
						default:
							$order_item_lib->addProductStock($depend_entity_response->entity->entity_id, $depend_entity_request->product_id);
							break;
					}
					
				}
				
			}
		}
		
	}
	
	public function productVerifyTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$response['error'] = 0;
		
		if ( isset($request->is_gift_card) ) {
			
			if ( $request->is_gift_card == 1 && empty($request->gift_category_id) ) {
				$response['error'] = TRUE;
				$response['message'] = trans('system.field_required', array( 'field' => 'Category' ));
				return $response;
			}
			
			if ( $request->is_gift_card == 0 && empty($request->category_id) ) {
				$response['error'] = TRUE;
				$response['message'] = trans('system.field_required', array( 'field' => 'Category' ));
				return $response;
			}
			
		}
		
	}
	
	/**
	 * Wallet Transaction Before Post
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function walletTransactionBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$balance = 0;
		if ( isset($request->customer_id) ) {
			
			if ( !empty($request->customer_id) && ( isset($request->credit) || isset($request->debit) ) ) {
				
				$credit = isset($request->credit) ? $request->credit : 0;
				$debit = isset($request->debit) ? $request->debit : 0;
				
				//calculate balance by get customer current balance
				$wallet_transaction = new WalletTransaction();
				$balance = $wallet_transaction->calculateBalance($request->customer_id, $credit, $debit);
			}
		}
		
		return [ 'balance' => "$balance" ];
		
	}
	
	/**
	 * on post wallet transaction update customer
	 *
	 * @param Request $request
	 */
	public function walletTransactionAddTrigger($request, $response_post = FALSE)
	{
		$request = is_array($request) ? (object) $request : $request;
		if ( isset($request->balance) && isset($request->customer_id) ) {
			
			if ( !empty($request->customer_id) ) {
				
				$entity_model = new SYSEntity();
				$entity_model->updateEntityAttrValue($request->customer_id, 'wallet', "$request->balance", 'customer');
			}
			
		}
	}
	
	public function vendorBeforePostTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$identifier = '';
		if ( isset($request->company_name) ) {
			$identifier = str_replace(' ', '-', strtolower($request->company_name));
		}
		return [ 'identifier' => "$identifier" ];
	}
	
	public function vendorBeforeSaveTrigger($request)
	{
		$request = is_array($request) ? (object) $request : $request;
		$identifier = '';
		if ( isset($request->company_name) ) {
			$identifier = str_replace(' ', '-', strtolower($request->company_name));
		}
		// echo "<pre>"; print_r($identifier); exit;
		return [ 'identifier' => "$identifier" ];
	}
	
	public function orderAfterTrigger($request, $response, $entity_type, $entity_id)
	{
		$order_flat = new OrderFlat();
		$vendor_stock_count = $order_flat->checkVendorStockOrder($entity_id);
		//echo "<pre>"; print_r($response); exit;
		$order = $response;
		$order_items = $response->order_item;
		
		if ( $vendor_stock_count == 0 ) {
			$order_process_lib = new OrderProcess();
			$order_process_lib->processInStockItem($entity_id, $order, $order_items);
		}
		
	}
	
}