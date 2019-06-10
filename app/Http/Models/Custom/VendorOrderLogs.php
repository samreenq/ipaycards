<?php
/**
 * this model is create to get data from flat table
 */

namespace App\Http\Models\Custom;

use App\Http\Models\Base;
use App\Libraries\GeneralSetting;
use Illuminate\Database\Eloquent\Model;

Class VendorOrderLogs extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'vendor_order_logs';
    }

    public function add($vendor,$order_id,$order_item_id,$order_stock_id,$product_id,$params,$response)
    {
        $this->vendor = $vendor;
        $this->order_id = $order_id;
        $this->order_item_id = $order_item_id;
        $this->order_stock_id = $order_stock_id;
        $this->product_id = $product_id;
        $this->request_params = json_encode($params);
        $this->response = json_encode($response);
        $this->created_at = date('Y-m-d H:i:s');
        $this->save();
    }



}