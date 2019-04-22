<?php
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Api\System\EntityController;
use App\Http\Controllers\Controller;
use App\Http\Models\Custom\BrandFlat;
use App\Http\Models\Custom\OrderFlat;
use App\Http\Models\FlatTable;
use App\Http\Models\SYSAttribute;
use App\Http\Models\SYSTableFlat;
use App\Libraries\CustomerHelper;
use App\Libraries\CustomHelper;
use App\Libraries\Driver;
use App\Libraries\EntityCustomer;
use App\Libraries\EntityDriver;
use App\Libraries\EntityNotification;
use App\Libraries\Fields;
use App\Libraries\GeneralSetting;
use App\Libraries\ItemLib;
use App\Libraries\OrderHelper;
use App\Libraries\OrderHistory;
use App\Libraries\OrderStatus;
use App\Libraries\ProductHelper;
use App\Libraries\System\Entity;
use App\Libraries\Truck;
use Auth;
use View;
use DB;
use Validator;
use Illuminate\Http\Request;
use Redirect;
use Mail;
use Illuminate\Support\Facades\Input;
use Response;
// models
use App\Http\Models\Admin;
use App\Http\Models\AdminModule;
use App\Http\Models\AdminModulePermission;
use App\Http\Models\Page;
use App\Http\Models\ApiMethodField;
use File;
use App\Libraries\EntityHelper;
use App\Libraries\OrderProcess;
use Carbon\Carbon;

/**
 * Class EntityAjaxController
 */
Class EntityAjaxController extends EntityBackController
{
    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        // construct parent

        parent::__construct($request);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function getoptions(Request $request)
    {
        $search_columns['title'] = $request->term;
        //attribute_code
        $search_columns['entity_type_id'] = $request->entity_type_id;
        $entityData = array();
        $attribute_code = false;
        if(isset($request->attribute_code) && !empty($request->attribute_code)){
            $response = SYSAttribute::getLinkedAttributeCode($request->attribute_code);
            if($response != false)
             $attribute_code = $response->attribute_code;
            unset($search_columns['title']);
            $search_columns[$attribute_code] = $request->term;
        }

        $entity_lib = new Entity();
        $response = $entity_lib->apiList($search_columns);
        $data = json_decode(json_encode($response));
       // $data = $this->__internalCall($request,DIR_API.'system/' . $this->_object_identifier . '/listing', 'GET', $search_columns,false);

        if (!empty($data->data->entity_listing)) {
            foreach ($data->data->entity_listing as $item) {
                $title = '';
                if ($item->attributes) {
                    if (isset($item->attributes->$attribute_code)) {
                        $title = $item->attributes->$attribute_code;
                    }elseif (isset($item->attributes->title)) {
                        $title = $item->attributes->title;
                    } elseif (isset($item->attributes->name)) {
                        $title = $item->attributes->name;
                    }
                } else {
                    if (isset($item->title)) {
                        $title = $item->title;
                    } elseif (isset($item->name)) {
                        $title = $item->name;
                    }
                }
                $entityData[] = array("entity_id" => $item->entity_id, "title" => $title);
            }
            return $entityData;
        }
        return ['data' => []];

    }

    /**
     * Get Entity type - item data
     * @param Request $request
     * @return array
     */
    public function getItemData(Request $request)
    {
        $entity_data = $this->getSearchEntityData($request);
        $data = $entity_data['data'];
        $attribute_code = $entity_data['attribute_code'];

        $entityData = array();
        if (!empty($data->data->entity_listing)) {
            foreach ($data->data->entity_listing as $item) {


                $title = '';
                $item_unit = '';
                $total_inventory = 0;
                $item_code = "";
                $category = "";

                if ($item->attributes) {

                    if(isset($item->attributes->item_unit)){
                        $item_unit  = EntityHelper::parseAttributeToDisplay($item->attributes->item_unit);
                    }

                    if(isset($item->attributes->item_unit)){
                        $item_unit_value  =  EntityHelper::parseAttributeValue($item->attributes->item_unit);
                    }

                    if(isset($item->attributes->item_code)){
                        $item_code  = $item->attributes->item_code;
                    }

                    if(isset($item->attributes->total_inventory)){
                        $total_inventory  = $item->attributes->total_inventory;
                    }

                    if(isset($item->attributes->item_category_id->title)){
                        $category  = $item->attributes->item_category_id->title;
                    }

                    if (isset($item->attributes->$attribute_code)) {
                        $title = $item->attributes->$attribute_code;
                    }elseif (isset($item->attributes->title)) {
                        $title = $item->attributes->title;
                    } elseif (isset($item->attributes->name)) {
                        $title = $item->attributes->name;
                    }
                } else {
                    if (isset($item->title)) {
                        $title = $item->title;
                    } elseif (isset($item->name)) {
                        $title = $item->name;
                    }
                }
                $total_inventory = ($total_inventory>0) ? $total_inventory : 0;
                $entityData[] = array(
                    "entity_id" => $item->entity_id,
                    "title" => $title,
                    "total_inventory" => $total_inventory,
                    "item_unit_value" => $item_unit_value,
                    "item_unit" => $item_unit,
                    "category"=>$category,
                    "item_code"=>$item_code);
            }
            return $entityData;
        }
        return ['data' => []];

    }

    /**
     * Get all roles for dropdown
     * @param Request $request
     * @return array|string
     */
    public function getRoleOptions(Request $request)
    {
        $entityData = array();
        $ex2Model = $this->_model_path . "SYSRole";
        $ex2Model = new $ex2Model;

        //if group is set then get role filter by group
        if(isset($request->is_group)){
            $data = $ex2Model->getGroupByEntityType($request->entity_type_id);
        }
        else if(isset($request->parent_id)){
            $data = $ex2Model->getRoleByEntityTypeAndGroup($request->entity_type_id,$request->parent_id);
        }
        else{
            //get role associated with group
            $data = $ex2Model->getGroupRoleByEntityType($request->entity_type_id);
        }

        if ($data) {
            foreach ($data as $item) {
                //echo "<pre>"; print_r($item);
                $title = '';
                if (isset($item->title)) {
                    $title = $item->title;
                } elseif (isset($item->name)) {
                    $title = $item->name;
                }

                $entityData[] = array("role_id" => $item->role_id, "title" => $title);
            }
        }
        return $rretDAta['data'] = $entityData;

    }


    /**
     * Get entity data which is search
     * @param $request
     * @return \App\Http\Controllers\count
     */
    public function getSearchEntityData($request)
    {
        if(isset($request->term)){
            $search_columns['title'] = $request->term;
        }
        //attribute_code
        $search_columns['entity_type_id'] = $request->entity_type_id;

        if(isset($request->entity_id)){
            $search_columns['entity_id'] = $request->entity_id;
        }


        $attribute_code = false;
        if(isset($request->attribute_code) && !empty($request->attribute_code)){
            $response = SYSAttribute::getLinkedAttributeCode($request->attribute_code);
            if($response != false)
                $attribute_code = $response->attribute_code;
            $search_columns[$attribute_code] = $request->term;
        }

        $data = $this->__internalCall($request,DIR_API.'system/' . $this->_object_identifier . '/listing', 'GET', $search_columns,false);

        return array(
            "attribute_code" => $attribute_code,
            "data"=>$data);
    }



    public function getOrderCart(Request $request)
    {
        $params = $request->all();

        if(isset($params['depend_entity'])) {
            $depend_params = $params['depend_entity'];
            unset($params['depend_entity']);

            $order_id = $request->order_id;
            $params['entity_id'] = $order_id;

            $entity_helper = new EntityHelper();
            //Validate Order
            $entity_validate = $entity_helper->validateEntity($params, true);

            if ($entity_validate['error'] == 1) {
                $assignData['error'] = 1;
                $assignData['message'] = $entity_validate['message'];
                return $assignData;
            } else {
                //Validate Order Items
                if (count($depend_params) > 0) {
                    foreach ($depend_params as $depend_param) {

                        $entity_depend_validate = $entity_helper->validateEntity($depend_param);
                        if ($entity_depend_validate['error'] == 1) {
                            $assignData['error'] = 1;
                            $assignData['message'] = $entity_depend_validate['message'];
                            return $assignData;
                        }
                    }
                }
            }


            //Calculate Order statistic to update order
            $order_process_obj = new OrderProcess();
            $order_process_response = $order_process_obj->processRequest($order_id,$request->all(),TRUE);

            if($order_process_response['error'] == 0){

                // echo "<pre>"; print_r($order_process_response); exit;

                $view_file = $this->_assignData["dir"] . "order/order_total";
                $view = view($view_file, ['data' => $order_process_response, 'is_update_order' => true])->render();

                $assignData['error'] = 0;

                if(isset($order_process_response['suggested_truck'])){
                    $assignData['suggested_truck'] = $order_process_response['suggested_truck'];
                }

                if(isset($order_process_response['selected_truck_id'])){
                    $assignData['selected_truck_id'] = $order_process_response['selected_truck_id'];
                }

                if(isset($order_process_response['selected_truck'])){
                    $assignData['selected_truck'] = $order_process_response['selected_truck'];
                }

                $assignData['message'] = $order_process_response['message'];
                $assignData['view'] = $view;
            }
            else{
                $assignData['error'] = 1;
                $assignData['message'] = $order_process_response['message'];
            }

        }
        else{
            $assignData['error'] = 1;
            $assignData['message'] = "Please add order items to update cart";
        }

        return $assignData;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function totalCountStats(Request $request)
    {
        $data = array();

        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $general_setting     = new GeneralSetting();
        $order_helper_lib    = new OrderHelper();
        $customer_lib        = new EntityCustomer();
        $item_lib = new ItemLib();


        $total_sale      = $order_helper_lib->totalSale($start_date,$end_date);
        $total_order     = $order_helper_lib->totalOrder($start_date,$end_date);
        $total_customer  = $customer_lib->totalCount($start_date,$end_date);
        $total_driver    = $item_lib->totalCount($start_date,$end_date);

        $data['total_sales']    = ($total_sale && $total_sale > 0) ? $general_setting->getPrettyPrice($total_sale) : 0;
        $data['total_order']    = ($total_order && $total_order > 0) ? $total_order : 0;
        $data['total_customer'] = ($total_customer && $total_customer > 0) ? $total_customer : 0;
        $data['total_driver']   = ($total_driver && $total_driver > 0) ? $total_driver : 0;


        return array('error' => 0,'data'=> $data,'message' => 'success');

    }

    /**
     * @param Request $request
     * @return array
     */
    public function totalSalesChart(Request $request)
    {
        $data = array();

        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->totalSalesByDate($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topProductChart(Request $request)
    {
        $data = array();

        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $product_helper_lib = new ProductHelper();
        $data = $product_helper_lib->topProducts($request->product_type,$start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function totalOrderByProductType(Request $request)
    {
        $data = array();

        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $product_count = $order_helper_lib->totalOrderByProductType(1,$start_date,$end_date);
        $recipe_count = $order_helper_lib->totalOrderByProductType(2,$start_date,$end_date);
        $bundle_count = $order_helper_lib->totalOrderByProductType(3,$start_date,$end_date);

        $data['product_count'] = ($product_count &&  $product_count > 0) ?  $product_count : 0;
        $data['recipe_count'] = ($recipe_count &&  $recipe_count > 0) ?  $recipe_count : 0;
        $data['bundle_count'] = ($bundle_count &&  $bundle_count > 0) ?  $bundle_count : 0;

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getListWidgets(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $tags_table_model = new SYSTableFlat('tags');
        $tag_list = $tags_table_model->getAll(5);

        $view_file = $this->_assignData["dir"] ."ajax/tag-list";
        $data['tags_list'] =  view($view_file,['data'=>$tag_list])->render();

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topDriverChart(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->topDriverByOrder($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topCustomerChart(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->topCustomerByOrder($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }


    /**
     * @param Request $request
     * @return array
     */
    public function topCustomerList(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $flat_table_model = new FlatTable();
        $list = $flat_table_model->topCustomers($start_date,$end_date);

        $view_file = $this->_assignData["dir"] ."ajax/customer-list";
        $data['coupon_list'] =  view($view_file,['data'=> $list])->render();

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topDriverList(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $flat_table_model = new FlatTable();
        $list = $flat_table_model->topDrivers($start_date,$end_date);
        $view_file = $this->_assignData["dir"] ."ajax/customer-list";
        $data['coupon_list'] =  view($view_file,['data'=> $list])->render();

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getTopProducts(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $flat_table_model = new FlatTable();
        $data = $flat_table_model->topVehicles($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }
    

    /**
     * @param Request $request
     * @return array
     */
    public function activePromotion(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $flat_table_model = new FlatTable();
        $list = $flat_table_model->activePromotions($start_date,$end_date);

        $view_file = $this->_assignData["dir"] ."ajax/promotion-list";
        $data['coupon_list'] =  view($view_file,['data'=> $list])->render();

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function activeCoupon(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $flat_table_model = new FlatTable();
        $coupon_list = $flat_table_model->activeCoupons($start_date,$end_date);

        $view_file = $this->_assignData["dir"] ."ajax/active-coupon";
        $data['coupon_list'] =  view($view_file,['data'=>$coupon_list])->render();

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topDeliverySlots(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->topDeliverySlots($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function topCity(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->topCity($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function peakOrderTime(Request $request)
    {
        $data = array();
        if($request->filter_type == "date"){
            $dates = CustomHelper::getDatesByFilterType($request->filter_type,$request->start_date,$request->end_date);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;

        }else{
            $dates = CustomHelper::getDatesByFilterType($request->filter_type);
            $start_date = $dates->start_date;
            $end_date = $dates->end_date;
        }

        $order_helper_lib = new OrderHelper();
        $data = $order_helper_lib->peakOrderTime($start_date,$end_date);

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }


    public function getDeliverySlot(Request $request)
    {
        if(isset($request->day)){
            $day_raw = explode('|',$request->day);
            $day = $day_raw[0];

            $flat_table_model = new SYSTableFlat('delivery_slot_item');
            $where_condition = ' delivery_slot_id = '.$day;
            $delivery_slot_items = $flat_table_model->getDataByWhere($where_condition);

            $delivery_slot_raw = array();

            if($delivery_slot_items){

                foreach($delivery_slot_items as $delivery_slot_item){

                    $delivery_slots = array(
                        'entity_id' => $delivery_slot_item->entity_id,
                        'title' => $delivery_slot_item->start_time. ' - '.$delivery_slot_item->end_time,
                    );

                    $delivery_slot_raw[] = $delivery_slots;
                }
            }

            return array('error' => 0,'data'=> $delivery_slot_raw ,'message' => 'success');

        }

        return array('error' => 1,'data'=> [],'message' => 'No Data');
    }



    /**
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function getOrderStatus(Request $request)
    {
        $warning_message = '';
        $entity_lib = new Entity();
        $post_arr = [];
        $post_arr['entity_type_id'] = 15;
        $post_arr['entity_id'] = $request->order_id;
        $order_raw = $entity_lib->doGet($post_arr);
        $order = json_decode(json_encode($order_raw));

        $flat_model = new SYSTableFlat('order_statuses');
        $order_statuses =  $flat_model->getDataByWhere();

      // echo "<pre>"; print_r($drivers); exit;
        $view_file = $this->_assignData["dir"] ."ajax/order-status";

        $data['html'] =  view($view_file,['data'=> array(
            'order' => $order,
            'status_list'=>$order_statuses,
            'warning' => $warning_message)])->render();

        $data['vehicle_id'] = isset($order->attributes->vehicle_id->id) ?  $order->attributes->vehicle_id->id : "";

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }

    /**
     * Update Order Status
     */
    public function updateOrderStatus(Request $request)
    {
        $params = $request->all();
        $params = is_array($params) ? (object)$params : $params;

        $return['error'] = 0;
        try {
            if (isset($request->order_id)) {

               $params->is_admin_update = 1;
              //  echo "<pre>"; print_r($params); exit;
                $order_history_lib = new OrderHistory();
                $history_response = $order_history_lib->addHistory($params);
                if($history_response->error == 1){
                    $return['error'] = 1;
                    $return['message'] = $history_response->message;
                    return $return;
                }

                $return['message'] = "Order updated successfully";

            }
            else{
                $return['error'] = 1;
                $return['message'] = "Parameters missing";
            }
        }
            catch (\Exception $e) {
                $return['error'] = 1;
                $return['message'] = $e->getMessage();
                $return['debug'] = 'File : ' . $e->getFile() . ' : Line ' . $e->getLine() . " : Stack " . $e->getTraceAsString();
            }

        return $return;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function getOrderStats(Request $request)
    {
        if(isset($request->entity_id)){

            $order_helper = new OrderHelper();
            $identifier = $request->identifier;

            $flats_model = new SYSTableFlat('order');
            $total_order_raw = $flats_model->getColumnByWhere($identifier.'_id ='.$request->entity_id,'COUNT(entity_id) as total');

            if($total_order_raw && $total_order_raw->total > 0){

                //
                $flat_model = new SYSTableFlat($identifier);
                $driver = $flat_model->getColumnByWhere(' entity_id ='.$request->entity_id,'*');

                $profile = $driver;
                if($identifier == 'driver'){
                    $response = $order_helper->getDriverOrderStats($request->all());
                    $driver_lib = new Driver();
                    $profile->review_options = $driver_lib->getDriverReview($driver->rating_options);
                }
                else{
                    $response = $order_helper->getCustomerOrderStats($request->all());
                    $customer_lib = new EntityCustomer();
                    $profile->review_options = $customer_lib->getReviewOptions($driver->rating_options);
                }


                $join_date = CustomHelper::getJoiningDays($driver->created_at);

                $profile->joining_key = $join_date['key'];
                $profile->joining_value = $join_date['value'];

            }
            else{
                $profile = $response = false;
            }


            //echo "<pre>"; print_r($profile); exit;
            $view_file = $this->_assignData["dir"] ."ajax/order-stats";
            $data['html'] =  view($view_file,
                ['data'=> $response,'driver' => $profile,'identifier' => $identifier])->render();

        }

        return array('error' => 0,'data'=> $data,'message' => 'success');
    }


    public function getOrderCalendar(Request $request)
    {
        if(isset($request->driver_id) && !empty($request->driver_id)){
            $arr = [];

           // $start_date = date('Y-m-d',strtotime($request->start_date));
            $end_date = date('Y-m-d',strtotime($request->end_date));
            $end_date = Carbon::createFromFormat('Y-m-d', $end_date)->subDay(2)->format('Y-m-d');

           // $dates[] = Carbon::createFromFormat('Y-m-d', $start_date)->format('Y-m-d');
            $j = 0;
            for($i = 6; $i >= 0; $i--){
                $dates[$i] = Carbon::createFromFormat('Y-m-d', $end_date)->subDay($j)->format('Y-m-d');
                $j++;
            }
            sort($dates);
           //echo "<pre>"; print_r($dates); exit;
            $start_date = $dates[0];
          /*  if(!empty($request->end_date)){
                $end_date= date('Y-m-d',strtotime($request->end_date));
            }else{
                $end_date = $dates[6];
            }*/

            if($request->driver_id == 'all'){
                $request->driver_id = false;
            }

            $order_flat = new OrderFlat();
            $orders = $order_flat->getDriverOrderSlots($request->driver_id,$start_date,$end_date);
            //echo "<pre>"; print_r($orders); exit;

            $view_file = $this->_assignData["dir"] ."ajax/calendar-slot";

            $data['html'] =  view($view_file, ['orders' => $orders,'dates'=>$dates])->render();
            $data['dates'] = $dates;
            return array('error' => 0,'data'=> $data,'message' => 'success');
        }
        return array('error' =>1,'data'=> [],'message' => 'No Data');

    }

    public function getOrderCalendarContent(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); exit;
        if (isset($request->driver_id) && !empty($request->driver_id)) {

            if($request->driver_id == 'all'){
                $request->driver_id = false;
            }

            $order_flat = new OrderFlat();
            $orders =  $order_flat->getDriverOrderDetail( $request->driver_id,$request->pickup_date,$request->start_time,$request->end_time);
          //  echo "<pre>"; print_r($orders); exit;

            $view_file = $this->_assignData["dir"] ."ajax/calendar-content";

            $data['html'] =  view($view_file, ['orders' => $orders])->render();
            return array('error' => 0,'data'=> $data,'message' => 'success');

        }
        return array('error' =>1,'data'=> [],'message' => 'No Data');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCategoryBrands(Request $request)
    {
        if(isset($request->category_id)){

            $brand_flat = new BrandFlat();
            $brands = $brand_flat->getByCategoryID($request->category_id);

            if($brands){
                return array('error' =>0,'data'=> $brands,'message' => 'success');
            }
        }


        return array('error' =>1,'data'=> [],'message' => 'No Data');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProductByBrand(Request $request)
    {
        if(isset($request->brand_id)){

            $flat_table_model = new SYSTableFlat('product');
            $where_condition = ' brand_id = '.$request->brand_id;
            $data = $flat_table_model->getDataByWhere($where_condition);
            if($data){
                return array('error' =>0,'data'=> $data,'message' => 'success');
            }
        }


        return array('error' =>1,'data'=> [],'message' => 'No Data');
    }

    public function getBrandCategories(Request $request)
    {
        if(isset($request->brand_id)){

            $params['entity_type_id'] = 'brand';
            $params['entity_id'] = $request->brand_id;
            $params['mobile_json'] = 1;

            $entity_lib = new Entity();
            $records =  $entity_lib->apiGet($params);
            $records = json_decode(json_encode($records));

           // echo "<pre>"; print_r($records); exit;
            if(isset($records->data->brand->brand_category_id)){

                foreach($records->data->brand->brand_category_id as $category){
                    $data[] = array(
                        'entity_id' => $category->category_id,
                        'title' => $category->title,
                    );
                }

                return array('error' =>0,'data'=> $data,'message' => 'success');
            }
        }


        return array('error' =>1,'data'=> [],'message' => 'No Data');
    }

}