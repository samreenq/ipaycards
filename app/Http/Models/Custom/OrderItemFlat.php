<?php
/**
 * this model is create to get data from flat table
 */

namespace App\Http\Models\Custom;

use App\Http\Models\Base;

Class OrderItemFlat extends Base {

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'order_item_flat';

    }

    public function validateGiftCard($product_code)
    {
        $query = "SELECT oi.* 
                FROM order_flat o
                LEFT JOIN order_item_flat oi 
                LEFT JOIN inventory_flat i ON oi.`inventory_id` = i.`entity_id`
                ON (o.`entity_id` = oi.`order_id`)
                WHERE i.voucher_code = '".$product_code."'
                AND oi.is_redeem = 0";

        $row = \DB::select($query);
        return isset($row[0]) ? $row[0] : false;
    }

}