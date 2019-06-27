<?php
/**
 * this model is create to get data from flat table
 */

namespace App\Http\Models\Custom;

use App\Http\Models\Base;
use Illuminate\Database\Eloquent\Model;

Class TopupPaymentLogs extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'topup_payment_logs';
    }

    public function add($service_type,$method,$lead_order_id,$params,$response)
    {
        $this->service_type = $service_type;
        $this->method = $method;
        $this->lead_topup_id = $lead_order_id;
        $this->request = json_encode($params);
        $this->response = json_encode($response);
        $this->created_at = date('Y-m-d H:i:s');
        $this->save();
    }



}