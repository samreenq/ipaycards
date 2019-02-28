<?php 

namespace App\Http\Models\Web;

use App\Http\Models\Base;
use App\Libraries\CustomHelper;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes AS SoftDeletes;
use App\Libraries\EntityTypeMask;
use Illuminate\Http\Request;



class WebEntity extends Base
{

    function getPromotions($date_time)
    {
		try 
		{
			$sql = "SELECT * from promotion_discount_flat WHERE start_date <= '".$date_time."' and end_date >= '".$date_time."'"; 
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	function getPromotionItem($promotion_discount_id)
    {
		try 
		{
			$sql = "select * from promotion_item_flat where promotion_discount_id = ".$promotion_discount_id; 
			
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	function getVarcharAttributeValue($entity_id,$attribute_id)
    {
		try 
		{
			$sql = "select value from sys_entity_varchar where entity_id = ".$entity_id." and attribute_id=".$attribute_id ; 
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	function getIntAttributeValue($entity_id,$attribute_id)
    {
		try 
		{
			$sql = "select value from sys_entity_int where entity_id = ".$entity_id." and attribute_id=".$attribute_id ; 
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	function updateVarcharAttributeValue($entity_id,$attribute_id,$discount_price)
    {
							
		try 
		{
			$data =\DB::table('sys_entity_varchar')
														->where('entity_id', $entity_id)
														->where('attribute_id', $attribute_id)
													->update(	['value' => $discount_price]);	

			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }

	function insertVarcharAttributeValue($entity_id,$entity_type_id,$attribute_id,$discount_price)
    {
		
		$data =\DB::table('sys_entity_varchar')
													->insert	(	[
																		'entity_type_id'	=> $entity_type_id   ,
																		'entity_id'			=> $entity_id     	 ,
																		'attribute_id'		=> $attribute_id  	 ,
																		'lang_identifier'   => "en"			 	 ,
																		'value'				=> $discount_price	
																	]
																 );		
														
		try 
		{
			
												
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	
	
	function getAboutBusiness()
    {
														
		try 
		{
			$sql = "SELECT  a.id,a.`entity_id`,a.title,a.`description`,a.`sub_title` , b.`entity_id` AS item_entity_id , b.`title` AS item_title,b.`description` AS item_description FROM `about_business_flat` a , `about_business_items_flat` b WHERE a.`entity_id` = b.`about_business_id`"; 
			$data = \DB::select($sql);
			return $data;
		}
		catch (\Exception $e) 
		{
			return array();
		}
    }
	
	
	
	
}