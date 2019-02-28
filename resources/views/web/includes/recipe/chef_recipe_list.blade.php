

	@if($deal!=null) 
		
		<div class="allChefRecipe">
			
			@foreach ( $deal  as $deal_attributes )
			
				
					<div class="col-xs-12 col-sm-12 col-md-4 d-flex">
						<div class="recipie-chef-wrap whitebg">
							<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" >								
									<img src="<?php 
															if(isset($deal_attributes["gallery"][0]["file"]))
															{ 
																	$handle = @fopen($deal_attributes["gallery"][0]["file"], "r");
																	if(strpos("$handle", "Resource id") !== false)
																	{
																			 
																			echo $deal_attributes["gallery"][0]["file"]; 
																	} 
																	else 
																	{ 
																			echo url("/")."/public/web/img/image_not_found_all.jpg";
																	} 
															}  
															else
															{
																	echo url("/")."/public/web/img/image_not_found_all.jpg"; 
															}
												?>" class="img-responsive" width="268" />
							</a>
							<div class="recipie-chef-detail">
								<div class="seeMoreWrap">
									<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" class="seeMore"><span class="icon-tt-right-arrow"></span></a>
								</div>
								<span class="vam"><img src="<?php 
												
															if(isset($deal_attributes['chef']['detail']["gallery"][0]["file"]))
															{ 
																	$handle = @fopen($deal_attributes['chef']['deal']["gallery"][0]["file"], "r");
																	if(strpos("$handle", "Resource id") !== false)
																	{
																			 
																			echo $deal_attributes['chef']['detail']["gallery"][0]["file"]; 
																	} 
																	else 
																	{ 
																			echo url("/")."/public/web/img/image_not_found_all.jpg";
																	} 
															}  
															else
															{
																	echo url("/")."/public/web/img/image_not_found_all.jpg"; 
															}
												?>" width="31"> <?php if(isset($deal_attributes['chef']['detail']['name'])) echo $deal_attributes['chef']['detail']['name']; ?>  (450)</span>
								
								
								
								
								<h4>
									<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" >								
										<?php if(isset($deal_attributes['title'])) echo $deal_attributes['title']; ?>
									</a>
								</h4>
							</div>
						</div>
					</div>
					
					
					
				
					
			
			@endforeach
		@endif
		

					