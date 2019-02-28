	<?php 
			if(isset($popularCategories[0]))
			{
				foreach ( $popularCategories as $attributes ) 
				{
    //Get image of product
    $gallery = isset($attributes['image']) ? json_decode(json_encode($attributes['image'])) : false;
    $image = \App\Libraries\Fields::getCategoryImage($gallery,'compressed_file','web');
	?>
					<div class="col-sm-6 col-md-6 col-lg-3">
						<a href="<?php echo url('/').'/product?entity_type_id=14&category_id='.$attributes['category_id']; ?>" class="popCate-wrap whitebg">
							<img src="<?php echo $image; ?>" class="img-responsive" width="268px" height="214px"/>
							<div class="popCate-detail">
								<h4><?php echo $attributes['title'];?><span>(<?php echo $attributes['product_count'];?>)</span></h4>
							</div>
						</a>
					</div>
	<?php 
				}
			}
	?>
	
