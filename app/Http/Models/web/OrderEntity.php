<?php 

namespace App\Http\Models\Web;

use App\Http\Models\Base;
use App\Libraries\CustomHelper;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes AS SoftDeletes;
use App\Libraries\EntityTypeMask;
use Illuminate\Http\Request;



class OrderEntity extends Base
{

	function getLeadOrder($customer_id)
    {
														
		try 
		{
			$sql = "SELECT  entity_id from order_flat WHERE customer_id=".$customer_id." and order_status='lead'"; 
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	
	
	
}