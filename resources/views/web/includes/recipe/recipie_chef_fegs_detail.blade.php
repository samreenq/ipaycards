
						<?php 
						
								if(isset($deal[0]))
								foreach($deal as $deal_attributes ) 
								{

                        //Get image of product
                        $gallery = isset($deal_attributes['gallery'][0]) ? json_decode(json_encode($deal_attributes['gallery'])) : false;
                        $image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');

                        $chef_gallery = isset($deal_attributes['chef']['detail']['gallery'][0]) ? json_decode(json_encode($deal_attributes['chef']['detail']['gallery'])) : false;
                        $chef_image = \App\Libraries\Fields::getGalleryImage($chef_gallery,'chef','thumb');

						?>
										<div class="col-xs-12 col-sm-12 col-md-4 d-flex">
											<div class="recipie-chef-wrap whitebg">
												<img src='<?php echo $image;
												?>' class="img-responsive" width="363px" height="295px" />
												<div class="recipie-chef-detail">
													<div class="seeMoreWrap">
															<a href="<?php if(isset($deal_attributes['product_code']))echo url('/')."/recipe_detail?entity_type_id=14&product_code=".$deal_attributes['product_code']; ?>" class="seeMore"><span class="icon-tt-right-arrow"></span></a>
													</div>
													<span class="vam">
																	<img src="<?php echo $chef_image; ?>" width='31px' height="31px" /><?php if(isset($deal_attributes['chef']['detail']['name'])) echo $deal_attributes['chef']['detail']['name']; ?> (<?php echo $deal_attributes['chef']['detail']['recipe_count']; ?>)</span>
													<h4><?php if(isset($deal_attributes['title'])) echo $deal_attributes['title']; ?></h4>
												</div>
											</div>
										</div>
						<?php 
								}
						?>
					