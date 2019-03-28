<?php

/**
 * Description: this library is to get truck information
 * Author: Samreen <samreen.quyyum@cubixlabs.com>
 * Date: 11-July-2018
 * Time: 11:00 PM
 * Copyright: CubixLabs
 */
namespace App\Libraries;


use App\Http\Models\SYSTableFlat;
use App\Libraries\System\Entity;

Class OrderItem
{
    public $_pLib = '';
    
    public function __construct()
    {
        $this->_pLib = new Entity();
    }
    /**
     * Validate Order Item
     * @param $items
     * @return \StdClass
     */
    public function validateItems($items)
    {
        $return = new \StdClass();
        $return->error = 0;

        try{
            //validate Items
            if(count($items) > 0){
                foreach($items as $extra_item){

                    $response_validate = $this->_pLib->postValidator((array)$extra_item);

                    if($response_validate){
                        $return->error = 1;
                        $return->message = $response_validate;
                    }
                }
            }
        }
        catch (\Exception $e) {
            //  echo $e->getTraceAsString(); exit;
            $return->error = 1;
            $return->message = $e->getMessage();
            //$return['debug'] = 'File : ' . $e->getFile() . ' : Line ' . $e->getLine();
        }

        return $return;

    }

    /**
     * Calculate items total load
     * @param $items
     * @return \StdClass
     */
    public function calcTotalLoad($items)
    {
        $return = new \StdClass();
        $return->weight = $return->volume =  0;

        if(count($items) > 0){
            foreach($items as $order_item){

                $return->volume += $order_item->volume*$order_item->quantity;
                $return->weight +=  $order_item->weight*$order_item->quantity;
            }
        }

        return $return;
    }

    /**
     * @param $order_items
     * @return \StdClass
     */
    public function addOrderItem($order_items)
    {
        $return = new \StdClass();
        $return->error = 0;

        if(count($order_items) > 0){

            foreach($order_items as $item){

                $order_response =  $this->_pLib->apiPost($item);
                $order_response = json_decode(json_encode($order_response));

                if($order_response->error == 1){

                    $return->error = 1;
                    $return->message = $order_response->message;
                    return $return;
                }


            }
        }
        $return->message = "Success";

        return $return;
    }

    /**
     * Add Gift Card Stock
     * @param $order_item_id
     * @param $product_id
     */
    public function addGiftCardStock($order_item_id,$product_id)
    {
        $flat_table = new SYSTableFlat('vendor');
        $vendor = $flat_table->getColumnByWhere(' identifier = "ipaycards"','entity_id');

        //Get Product
        $flat_table = new SYSTableFlat('product');
        $product = $flat_table->getColumnByWhere(' entity_id = '.$product_id,'*');
        //   echo "<pre>"; print_r($product); exit;
        //Create inventory
        $params = array(
            'entity_type_id' => 'inventory',
            'vendor_id' => $vendor->entity_id,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'product_id' => $product_id,
            'product_code' =>  str_random(8),
            'availability' => 'reserved',
        );

        $inventory_response = $this->_pLib->apiPost($params);
        $inventory_response = json_decode(json_encode($inventory_response));

        if(isset($inventory_response->data->entity->entity_id)){

            //echo "<pre>"; print_r($inventory_id); exit;
            //Update Order Item
            $params = [
                'entity_type_id' => 16,
                'entity_id' => $order_item_id,
                'inventory_id' => $inventory_response->data->entity->entity_id,
                'vendor_id' => $vendor->entity_id,
                'order_from' => 'in_stock'
            ];

            $this->_pLib->apiUpdate($params);
        }
    }

    /**
     * Add Product Stock
     * @param $order_item_id
     * @param $product_id
     */
    public function addProductStock($order_item_id,$product_id)
    {
        //Get inventory
        $flat_table = new SYSTableFlat('inventory');
        $data = $flat_table->getDataByWhere(' product_id = ' . $product_id . ' AND availability = "available"');
        // echo "<pre>"; print_r($data);
        if ($data && isset($data[0])) {


            //Update Order Item
            $params = [
                'entity_type_id' => 16,
                'entity_id' => $order_item_id,
                'inventory_id' => $data[0]->entity_id,
                'order_from' => 'in_stock'
            ];

            $item_response = $this->_pLib->apiUpdate($params);
            //echo "<pre>"; print_r($item_response); exit;
            //Update Inventory Status
            $params = [
                'entity_type_id' => 73,
                'entity_id' => $data[0]->entity_id,
                'availability' => 'reserved',
            ];

            $this->_pLib->apiUpdate($params);
        } else {
            //Update Order Item
            $params = [
                'entity_type_id' => 16,
                'entity_id' => $order_item_id,
                'order_from' => 'vendor_stock'
            ];

            $this->_pLib->apiUpdate($params);
        }
    }

    /**
     * Add Deal Stock
     * @param $order_id
     * @param $order_item_id
     * @param $deal_id
     */
    public function addDealStock($order_id,$order_item_id,$deal_id)
    {
        //Get Deal
        $flat_table = new SYSTableFlat('product');
        $deal_data = $flat_table->getDataByWhere(' entity_id = ' . $deal_id.' AND item_type = "deal"');
        if ($deal_data && isset($deal_data[0])) {

            $deal = $deal_data[0];
            $vendor_stock = 0;
            $product_ids = explode(',',$deal->product_ids);

            if(isset($product_ids)){

                foreach($product_ids as $product_id){

                    //Get inventory
                    $flat_table = new SYSTableFlat('inventory');
                    $data = $flat_table->getDataByWhere(' product_id = ' . $product_id . ' AND availability = "available"');

                    if ($data && isset($data[0])) {

                        //Add Order Item Deal
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'order_id' => $order_id,
                            'order_item_id' => $order_item_id,
                            'parent_product_id' => $deal_id,
                            'product_id' => $product_id,
                            'inventory_id' => $data[0]->entity_id,
                            'order_from' => 'in_stock',
                            'vendor_id' =>  $data[0]->vendor_id
                        ];

                        $item_response = $this->_pLib->apiPost($params);
                        //echo "<pre>"; print_r($item_response); exit;
                        //Update Inventory Status
                        $params = [
                            'entity_type_id' => 'inventory',
                            'entity_id' => $data[0]->entity_id,
                            'availability' => 'reserved',
                        ];

                        $this->_pLib->apiUpdate($params);
                    } else {
                        //Add Order Item out of stock
                        $params = [
                            'entity_type_id' => 'order_item_deal',
                            'order_id' => $order_id,
                            'order_item_id' => $order_item_id,
                            'parent_product_id' => $deal_id,
                            'product_id' => $product_id,
                            'order_from' => 'vendor_stock',
                        ];

                        $this->_pLib->apiPost($params);
                        $vendor_stock++;
                    }
                }

                //Update Order Item in stock /out stock flag
                $order_from = ($vendor_stock > 0) ? 'vendor_stock' :  'in_stock';

                $params = array(
                    'entity_type_id' => 'order_item',
                    'entity_id' => $order_item_id,
                    'order_from' => $order_from
                );

                $this->_pLib->apiUpdate($params);

            }

        }
    }



}