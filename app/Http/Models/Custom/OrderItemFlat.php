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
        $encryption_key = config('constants.ENCRYPTION_KEY');

        $query = "SELECT oi.*, oii.`price`,oii.`discount_price`
                FROM order_flat o
                LEFT JOIN order_item_deal_flat oi ON (o.`entity_id` = oi.`order_id`)
                 LEFT JOIN order_item_flat oii ON oii.entity_id = oi.`order_item_id`
                LEFT JOIN inventory_flat i ON oi.`inventory_id` = i.`entity_id`
                WHERE i.voucher_code = AES_ENCRYPT('".$product_code."', '".$encryption_key."')
                AND (oi.is_redeem IS NULL OR oi.is_redeem = 0)";

        $row = \DB::select($query);
        return isset($row[0]) ? $row[0] : false;
    }

}