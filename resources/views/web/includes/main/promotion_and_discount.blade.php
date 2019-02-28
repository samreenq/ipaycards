

<ul class="smBannerSlider">
							
<?php 
		$a = 1; 
		if(isset($promotion_discount[0]))
		{
			foreach ($promotion_discount as $promotion_discount_attributes ) 
			{
    			$gallery = isset($promotion_discount_attributes['gallery'][0]) ? json_decode(json_encode($promotion_discount_attributes['gallery'])) : false;
   				$image = \App\Libraries\Fields::getGalleryImage($gallery,'promotion_discount','compressed_file');
			
?>

				<li class="smSingleBanner sm-banner-<?php echo $a; ?>" style="background-size:363px 162px !important;  background: url('<?php  echo $image; ?>') no-repeat top left;">
						<a href="<?php echo url('/').'/product?entity_type_id=14&product_promotion_id='.$promotion_discount_attributes['entity_id']; ?>" class="fullLink"></a>
						<h3><?php echo $promotion_discount_attributes['title'] ?></h3>
						<a href="<?php echo url('/').'/product?entity_type_id=14&product_promotion_id='.$promotion_discount_attributes['entity_id']; ?>" class="shop-now">shop now</a>
					
				</li>
				
<?php
				$a++;
			}
		}
?>


</ul>