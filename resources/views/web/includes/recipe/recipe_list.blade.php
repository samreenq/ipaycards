<?php
	if(isset($recipe[0])) 
	{
			foreach ( $recipe  as $recipeItemsList )
			{

				//Get image of product
				$gallery = isset($recipeItemsList['gallery'][0]) ? json_decode(json_encode($recipeItemsList['gallery'])) : false;
				$image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');

				//Chef Gallery image
				$chef_gallery = isset($recipeItemsList['attributes']['chef']['detail']['gallery'][0]) ? json_decode(json_encode($recipeItemsList['attributes']['chef']['detail']['gallery'])) : false;
				$chef_image = \App\Libraries\Fields::getGalleryImage($chef_gallery,'chef','thumb');
?>	
					<div class="col-xs-12 col-sm-12 col-md-4 d-flex">
						<div class="recipie-chef-wrap whitebg">
							<img width="363px"  height="295px" src='<?php echo $image; ?>' class="img-responsive" width="268" />
							<div class="recipie-chef-detail">
								<div class="seeMoreWrap">
									<a href="{{$product_detail_url.'?entity_type_id='.$recipeItemsList['entity_type_id'].'&product_code='.$recipeItemsList['attributes']['product_code']}}" class="seeMore"><span class="icon-tt-right-arrow"></span></a>
								</div>
								<span class="vam"><img src="<?php echo $chef_image; ?>" width="31"> @if(isset($recipeItemsList["attributes"]['chef']['detail']['attributes']['name'])) {{ $recipeItemsList["attributes"]['chef']['detail']['attributes']['name'] }} @endif (<?php echo  $recipeItemsList["attributes"]['chef']['detail']['attributes']['recipe_count']  ?>)</span>
								<h4>
									<a href="{{$product_detail_url.'?entity_type_id='.$recipeItemsList['entity_type_id'].'&product_code='.$recipeItemsList['attributes']['product_code']}}" >
									@if(isset($recipeItemsList["attributes"]['title'])) {{ $recipeItemsList["attributes"]['title'] }} @endif</a>
								</h4>
							</div>
						</div>
					</div>
					
<?php			
			}
	}
	else 
	{
		
?>
					<div class="error404Wrap ml-auto mr-auto mt70 mb70">
										<div class="error404img mt50 mb50">
											<img class="img-responsive" src="{{url('/')}}/public/web/img/error404.png" alt="error404" width="309">
											<h2>No Recipe Found</h2>
											<p>We are sorry but the Recipe you are looking for does not exist.<br>You could return to the <a href="{{url('/')}}">homepage</a></p>
										</div>
					</div>
<?php			
	}
?>

					