<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Libraries\CustomHelper;
use App\Libraries\GeneralSetting;
use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Input;
use Validator;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;


use App\Http\Models\Web\WebEntity;


class CronController extends Controller {
	
	private $_web_entity_model;
	
	public function __construct()
    {
		$this->_web_entity_model = new WebEntity();
	}
	
	public function cron(Request $request)
	{
		
		$date_time  = "2017-11-23 00:00:00"; 
		$promotions = $this->_web_entity_model->getPromotions($date_time);
		$promotion  = array();
		$p=0;
		foreach($promotions as $promotion_attributes )
		{
		
			$promotion[$p]['title']		 	= $promotion_attributes->title;  
			$promotion[$p]['start_date'] 	= $promotion_attributes->start_date;
			$promotion[$p]['end_date'] 	 	= $promotion_attributes->end_date;
			$promotion[$p]['availability'] 	= $promotion_attributes->availability;
			$promotion_items  = $this->_web_entity_model->getPromotionItem($promotion_attributes->entity_id);
			$q=0;
			foreach ( $promotion_items as $promotion_items_attributes ) 
			{
				$promotion[$p]['depend_entity'][$q]['entity_id'] 			 = $promotion_items_attributes->entity_id;
				$promotion[$p]['depend_entity'][$q]['coupon_type'] 			 = $promotion_items_attributes->coupon_type;
				$promotion[$p]['depend_entity'][$q]['promotion_product_id']  = $promotion_items_attributes->promotion_product_id; 
				$promotion[$p]['depend_entity'][$q]['discount'] 			 = $promotion_items_attributes->discount;
				$promotion[$p]['depend_entity'][$q]['promotion_discount_id'] = $promotion_items_attributes->promotion_discount_id;
				$promotion[$p]['depend_entity'][$q]['promotion_type'] 		 = $promotion_items_attributes->promotion_type;
				$q++;
			}
			$p++;
		}		
		
		
print_r($promotion); 
		
    echo "<br /><br /><br /><br />";
		foreach ( $promotion as $promotion_attributes)
		{
			foreach ( $promotion_attributes['depend_entity'] as $product ) 
			{
				
				$price = $this->_web_entity_model->getVarcharAttributeValue($product['promotion_product_id'],122);
				$price = (isset($price[0]->value)) ? $price[0]->value : null ;
				 echo ' , '.$price; 
				 
				if($price != null  ) 
				{
					
					if($product['coupon_type'] == 1 )  // 1 for discount% 
					{
						$discount_price = ($product['discount'] * $price) / 100 ;
					}
					if($product['coupon_type'] == 2 )  // 2 for flat 
					{
						$discount_price =  $price - $product['discount'] ; 
					}
					
					$has_discount = $this->_web_entity_model->getIntAttributeValue($product['promotion_product_id'],206);
					$has_discount =  $has_discount[0]->value;
						
					
					if($has_discount == false )   // Update Discount Price 
					{
							
						$result = $this->_web_entity_model->insertVarcharAttributeValue($product['promotion_product_id'],14,205,$discount_price); // 205 is attribute id of discount price  
						
					}
					if($has_discount == 1 )   // Update Discount Price 
					{
						$result = $this->_web_entity_model->updateVarcharAttributeValue($product['promotion_product_id'],205,$discount_price); // 205 is attribute id of discount price  		
						var_dump($result); 
					}
						
							
						
					
				}
						
			}
			echo "<br /><br /><br /><br />";
		}
		
		//discount price SELECT * FROM `sys_entity_varchar` WHERE entity_id = 149 AND attribute_id = 205 
		//has discount  SELECT * FROM `sys_entity_int` WHERE entity_id = 149 AND attribute_id = 206    

	}
	

	
}
