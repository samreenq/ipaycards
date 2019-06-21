<?php
/**
 * this model is create to get data from flat table
 */

namespace App\Http\Models\Custom;

use App\Http\Models\Base;
use App\Libraries\GeneralSetting;
use Illuminate\Database\Eloquent\Model;

Class OrderPaymentLogs extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'order_payment_logs';
    }

    public function add($method,$lead_order_id,$params,$response)
    {
        $this->method = $method;
        $this->lead_order_id = $lead_order_id;
        $this->request = json_encode($params);
        $this->response = json_encode($response);
        $this->created_at = date('Y-m-d H:i:s');
        $this->save();
    }



}