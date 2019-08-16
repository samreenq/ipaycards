
	<?php 
	

		if(isset($deal[0])) 
			foreach($deal as $deal_attributes ) 
			{

    //Get image of product
    $gallery = isset($deal_attributes['gallery'][0]) ? json_decode(json_encode($deal_attributes['gallery'])) : false;
    $image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');

    //Get Chef Image
    $chef_gallery = isset($deal_attributes['chef']['detail']['gallery'][0]) ? json_decode(json_encode($deal_attributes['chef']['detail']['gallery'])) : false;
    $chef_image = \App\Libraries\Fields::getGalleryImage($chef_gallery,'chef','compressed_file');

	?>
				<div class="col-md-12 col-lg-6">
					<div class="chef-deal-wrap">
						<div class="chef-deal-img">
							<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" class="fullLink"></a>
							<img src='<?php echo $image;?>' class="img-responsive" width="554px" height="100%"/>
							<div class="seeMoreWrap">
								<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" class="seeMore"><span class="icon-tt-right-arrow"></span></a>
							</div>
						</div>
						<div class="chef-deal-detail">
							<span class="vam">
													
							<img src="<?php echo $chef_image; ?>" width='31px' height="31px" /><a href='<?php if(isset($deal_attributes['chef']['detail'])) echo url('/').'/chef?entity_id='.$deal_attributes['chef']['detail']['entity_id']; ?> '><?php if(isset($deal_attributes['chef']['detail']['name'])) echo $deal_attributes['chef']['detail']['name']; ?> </a>(<?php if(isset($deal_attributes['chef']['detail']['recipe_count'])) echo  $deal_attributes['chef']['detail']['recipe_count']; ?>)</span>
							<h3><?php if(isset($deal_attributes['title'])) echo $deal_attributes['title']; ?></h3>
						</div>
					</div>
				</div>
				
	<?php 
			}
	?>