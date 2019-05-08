<?php

/**
 * Class ProductHelper
 */
namespace App\Libraries;
use App\Http\Models\FlatTable;
use App\Http\Models\SYSTableFlat;
use App\Http\Requests\Request;
use App\Libraries\System\Entity;

Class OrderCart
{
    private $_sysTableFlatModel = '';

    /**
     * ProductHelper constructor.
     */
    public function __construct()
    {
        $this->_sysTableFlatModel = new SYSTableFlat('order_cart');
    }

    public function mergeWebCart($customer_id,$guest_cart = false)
    {

        try {
            $cart_products = [];
            $where_condition = ' customer_id = ' . $customer_id;
            $order_cart_record = $this->_sysTableFlatModel->getDataByWhere($where_condition);


            if ($order_cart_record) {

                $order_cart = $order_cart_record[0];

                if ($order_cart) {
                    $cart_items = json_decode($order_cart->cart_item);

                    $entity_ids = $cart_item_quantity  = [];

                    if ($cart_items) {
                        foreach ($cart_items as $item) {
                            $entity_ids[] = $item->product_id;
                            $cart_item_quantity[ $item->product_id ] = $item->quantity;
                        }
                    }

                    if($guest_cart){

                        foreach($guest_cart as $guest_item){

                            $product_id = isset($guest_item->entity_id) ? $guest_item->entity_id : $item->entity_id;
                            $quantity =  isset($guest_item->product_quantity) ? $guest_item->product_quantity : $item->product_quantity;

                            if(!in_array($product_id,$entity_ids)){
                                $entity_ids[] = $product_id;
                            }
                            $cart_item_quantity[ $product_id ] = $quantity;
                            unset($guest_item);
                        }

                       // echo "<pre>"; print_r($cart_item_quantity); exit;
                    }

                    if (count($entity_ids) > 0) {

                        $entity_model = new Entity();

                        $params = [
                            'entity_type_id' => 'product',
                            'entity_id' => implode(',', $entity_ids),
                            'status' => 1,
                           // 'availability' => 1,
                            'mobile_json' => 1
                        ];

                        $products_response = $entity_model->apiList($params);
                        $products = json_decode(json_encode($products_response));
                        $cart_products = $this->_getUpdatedProducts($products, $cart_item_quantity);


                        if($guest_cart){
                            $this->saveCart($customer_id,json_encode($cart_products));
                        }
                    }
                }
            }

            $return['error'] = 0;
            $return['message'] = 'success';
            $return['data'] =  array('products'=>$cart_products,'total' => count($cart_products));
            return $return;

        } catch (\Exception $e) {
            $return['error'] = 1;
            $return['message'] = $e->getMessage();
        }

    }

    private function _getUpdatedProducts($products,$cart_item_quantity)
    {
        $cart_products = array();
       // echo "<pre>"; print_r( $products);
        if($products && $products->error == 0){

            if($products->data->page->total_records > 0){

                //echo "<pre>"; print_r($products->data->product);
                foreach($products->data->product as $product){
                  //  echo "<pre>"; print_r($product);
                    $thumb = Fields::getGalleryImageFile($product->gallery,'product','file');
                    $price = $product->price;

                    if(isset($product->product_promotion_id) && $product->product_promotion_id >0)
                    {
                        if((isset($product->promotion_start_date) && !empty($product->promotion_start_date)) &&
                            (isset($product->promotion_end_date) && !empty($product->promotion_end_date))) {

                            $current_date = date("Y-m-d H:i:s");

                            if (strtotime($current_date) >= strtotime($product->promotion_start_date) &&
                                strtotime($current_date) <= strtotime($product->promotion_end_date)) {

                                if (isset($product->promotion_discount_amount)) {
                                    $price = $product->promotion_discount_amount;
                                }
                            }

                        }
                    }

                    $cart_product = array(
                        'entity_id' => $product->entity_id,
                        'product_code' => $product->product_code,
                        'title' => $product->title,
                        'thumb' => $thumb,
                        'price' => $price,
                       // 'weight' => $product->weight,
                        //'unit_option' => isset($product->item_unit->option) ? $product->item_unit->option : "",
                       // 'unit_value'  => isset($product->item_unit->value) ? $product->item_unit->value : "",
                        'product_quantity' => $cart_item_quantity[$product->entity_id],
                        'item_type' => $product->item_type->value,

                    );
                    //echo "<pre>"; print_r($cart_product);
                    $cart_products[] = $cart_product;
                   // echo "<pre>"; print_r($cart_products); exit;
                }


            }
        }

        return $cart_products;
    }

    /**
     * @param bool $customer_id
     * @param string $products
     * @return array|bool
     */
    public function saveCart($customer_id = false,$products = '')
    {
        if($customer_id){

            $where_condition = ' customer_id = ' . $customer_id;
            $order_cart_record = $this->_sysTableFlatModel->getDataByWhere($where_condition,array('entity_id'));

            if($order_cart_record){
                $order_cart = $order_cart_record[0];

                $params = array(
                    'entity_type_id' => 54,
                    'entity_id' => $order_cart->entity_id,
                    'customer_id' => $customer_id,
                    'cart_item' => $products,
                    'mobile_json' => 1,
                );
               // echo "<pre>"; print_r( $params); exit;
                $entity_lib = new Entity();
                $response =   $entity_lib->apiUpdate($params);

            }else{
                $params = array(
                    'entity_type_id' => 54,
                    'customer_id' => $customer_id,
                    'cart_item' => $products,
                    'mobile_json' => 1,
                );
                //echo "<pre>"; print_r( $params);
                $entity_lib = new Entity();
                $response =   $entity_lib->apiPost($params);
                //echo "<pre>"; print_r( $response);exit;
            }

            return $response;
        }

        return true;
    }

    /**
     * Get Order cart
     * @param $customer_id
     * @return array
     */
    public function getOrderCart($customer_id)
    {
            $params = array(
                'entity_type_id' => 'order_cart',
                'customer_id' => $customer_id,
                'mobile_json' => 1,
            );
        $entity_lib = new Entity();
        $cart = $entity_lib->apiList($params);

        if(isset($cart['data']['order_cart'][0]) && !empty($cart['data']['order_cart'][0])){

            $update_item = array();
            $cart_items = json_decode($cart['data']['order_cart'][0]->cart_item);

            if(!is_array($cart_items) && !empty($cart_items)){
                $cart_items = json_decode($cart_items);
            }

            if(!empty($cart_items) && count($cart_items) > 0){

                foreach($cart_items as $item){

                        $params = array(
                            'entity_type_id' => 'product',
                            'entity_id' => $item->product_id,
                            'status' => 1,
                            'mobile_json' => 1,
                        );

                   // echo "<pre>"; print_r($params); exit;
                    $product_information = $entity_lib->apiGet($params);

                    if(isset($product_information['data']['product'])){
                        $item->detail = $product_information['data']['product'];
                    }else{
                        $item->detail = new \StdClass();
                    }

                    if(isset($item->detail))
                        $update_item[] = $item;
                    unset($item);

                }
            }

            $cart['data']['order_cart'][0]->cart_item = $update_item;
        }

       // print_r($cart); exit;
        return $cart;

    }

    /**
     * @param $customer_id
     * @param bool $guest_cart
     * @return mixed
     */
    public function mergeCart($customer_id,$guest_cart = false)
    {
        try {
            $where_condition = ' customer_id = ' . $customer_id;
            $order_cart_record = $this->_sysTableFlatModel->getDataByWhere($where_condition);


            if ($order_cart_record) {

                $order_cart = $order_cart_record[0];

                if ($order_cart) {
                    $cart_items = json_decode($order_cart->cart_item);

                    $entity_ids = $cart_item_quantity  = [];

                    if ($cart_items) {
                        foreach ($cart_items as $item) {
                            $entity_ids[] = $item->product_id;
                            $cart_item_quantity[ $item->product_id ] = $item->quantity;
                        }
                    }

                    if($guest_cart){

                        foreach($guest_cart as $guest_item){

                            $product_id = isset($guest_item->product_id) ? $guest_item->product_id : $item->product_id;
                            $quantity =  isset($guest_item->quantity) ? $guest_item->quantity : $item->quantity;

                            if(!in_array($product_id,$entity_ids)){
                                $entity_ids[] = $product_id;
                            }
                            $cart_item_quantity[ $product_id ] = $quantity;
                            unset($guest_item);
                        }

                    }

                        $save_cart = [];
                        if(count($cart_item_quantity) > 0 ){

                            foreach($cart_item_quantity as $id => $cart_quantity){
                                $save_cart[] = array(
                                    'product_id' => $id,
                                    'quantity' => $cart_quantity
                                );
                            }
                            $this->saveCart($customer_id,json_encode($save_cart));
                        }
                        else{
                            $this->saveCart($customer_id);
                        }
                    //echo "<pre>"; print_r($save_cart); exit;

                }
            }

            $return['error'] = 0;
            $return['message'] = 'success';
            return $return;

        } catch (\Exception $e) {
            $return['error'] = 1;
            $return['message'] = $e->getMessage();
        }

    }


}