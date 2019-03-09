	
	
	<!-- Today Today Essentials -->
	<?php
			if(count($essentials)>0)
				foreach ($essentials as $attributes) 
				{
   					 $price = $attributes["attributes"]['price'];

					           if(isset($attributes["attributes"]['product_promotion_id']))
								{
									if($attributes["attributes"]['product_promotion_id']>0) 
									{
										if(isset($attributes["attributes"]['promotion_start_date']))
											$start_date = date("Y-m-d H:i:s",strtotime($attributes["attributes"]['promotion_start_date'])); 
										if(isset($attributes["attributes"]['promotion_end_date']))
											$end_date = date("Y-m-d H:i:s",strtotime($attributes["attributes"]['promotion_end_date'])); 
										$current_date = date("Y-m-d H:i:s"); 
										
										if(isset($start_date) && isset($end_date))
										{
											if($current_date >=$start_date && $current_date <=$end_date ) 
											{
												if(isset($attributes["attributes"]['promotion_discount_amount']))
												{
													$price = $attributes["attributes"]['promotion_discount_amount'];
												}
											}
										}
									}
								}

					//Get image of product
   				 $gallery = isset($attributes['gallery'][0]) ? json_decode(json_encode($attributes['gallery'])) : false;
   				 $image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
				
			?>
					
					<div class="col-xs-12 col-sm-6 col-lg-3">
						<div class="product-wrap whitebg">
									
							
								<input type="hidden" class="entity_id" value="<?php if(isset($attributes['entity_id'])) echo $attributes['entity_id']; ?>" />
								<input type="hidden" class="product_code" value="<?php if(isset($attributes["attributes"]['product_code'])) echo $attributes["attributes"]['product_code'] ?>" />
								<input type="hidden" class="title" value="<?php if(isset($attributes["attributes"]['title'])) echo $attributes["attributes"]['title']; ?>" />
								<input type="hidden" class="thumb" value="<?php if(isset($attributes['gallery'][0]['file'])) echo $attributes['gallery'][0]['file']; ?>" />
								<input type="hidden" class="price" value="<?php echo $price; ?>" />

						
							{{--<button class="like-btn wishlist"><span class="icon-tt-like-icon"></span></button>--}}
							<img width="268px" height="221px" src='<?php echo $image; ?>' class="img-responsive" width="268px"/>
							<div class="product-detail">
								<div class="addCartWrap">
								
										<input type="hidden" class="entity_id" value="<?php if(isset($attributes['entity_id'])) echo $attributes['entity_id']; ?>" />
										<input type="hidden" class="product_code" value="<?php if(isset($attributes["attributes"]['product_code'])) echo $attributes["attributes"]['product_code'] ?>" />
										<input type="hidden" class="title" value="<?php if(isset($attributes["attributes"]['title'])) echo $attributes["attributes"]['title']; ?>" />
										<input type="hidden" class="thumb" value="<?php if(isset($attributes['gallery'][0]['file'])) echo $attributes['gallery'][0]['file']; ?>" />
										<input type="hidden" class="price" value="<?php echo $price; ?>" />
										<input class="quantity" type="hidden" name="product_quantity" value="1"/>
											
									<button class="addtocart">
										<span class="icon-tt-cart-Icon"></span>
									</button>
									<div class="pro-inc-wrap">
										<div class="count-input">
											<a class="incr-btn incr-btn5 text-right prn" data-action="decrease" href="#"><span class="icon-tt-minus-icon"></span></a>
											
											
											<input type="hidden" class="entity_id" value="<?php if(isset($attributes['entity_id'])) echo $attributes['entity_id']; ?>" />
											<input type="hidden" class="product_code" value="<?php if(isset($attributes["attributes"]['product_code'])) echo $attributes["attributes"]['product_code'] ?>" />
											<input type="hidden" class="title" value="<?php if(isset($attributes["attributes"]['title'])) echo $attributes["attributes"]['title']; ?>" />
											<input type="hidden" class="thumb" value="<?php if(isset($attributes['gallery'][0]['file'])) echo $attributes['gallery'][0]['file']; ?>" />
											<input type="hidden" class="price" value="<?php echo $price; ?>" />
											<input class="quantity" type="number" name="product_quantity" value="1" readonly/>
											
											<a class="incr-btn incr-btn5 text-left pln" data-action="increase" href="#"><span class="icon-tt-plus-icon"></span></a>
										</div>
									</div>
								</div>
								{{--<a href="<?php echo $product_detail_url.'?entity_type_id='.$attributes['entity_type_id'].'&product_code='.$attributes['attributes']['product_code'] ?>" class="perishable">Perishable</a>--}}
								<h4>	
									<a href="<?php echo $product_detail_url.'?entity_type_id='.$attributes['entity_type_id'].'&product_code='.$attributes['attributes']['product_code'] ?>" >
										<?php echo $attributes['attributes']['title'];?>
									</a>
								</h4>
								<div class="product-footer clearfix">

								<?php 
								
										if(isset($attributes["attributes"]['product_promotion_id'])) 
										{
											if($attributes["attributes"]['product_promotion_id']>0) 
											{
												if(isset($attributes["attributes"]['promotion_start_date']))
													$start_date = date("Y-m-d H:i:s",strtotime($attributes["attributes"]['promotion_start_date'])); 
												if(isset($attributes["attributes"]['promotion_end_date']))
													$end_date = date("Y-m-d H:i:s",strtotime($attributes["attributes"]['promotion_end_date'])); 
												$current_date = date("Y-m-d H:i:s"); 
											
												if($current_date >=$start_date && $current_date <=$end_date ) 
												{
													if(isset($attributes["attributes"]['promotion_discount_amount']))
														$price = $attributes["attributes"]['promotion_discount_amount'];
								?>
													<p class="prise"><?php echo $currency ?> <?php if(isset($attributes["attributes"]['promotion_discount_amount'])) echo $attributes["attributes"]['promotion_discount_amount']; ?></p>
													<p class="prise">&nbsp;&nbsp;&nbsp;</p>
													<p class="prise"><strike><?php echo $currency.' '.$attributes["attributes"]['price']; ?>  </strike></p>
								<?php 		
												}
												else 
												{
								?>
													<p class="prise"><?php echo $currency; ?>   @if(isset($attributes["attributes"]['price'])) {{ $attributes["attributes"]['price'] }} @endif</p>
								<?php 	
												}
								?>
											
								<?php 
											}
											else
											{
								?>
													<p class="prise"><?php echo $currency; ?>   @if(isset($attributes["attributes"]['price'])) {{ $attributes["attributes"]['price'] }} @endif</p>
								<?php 
											}
										}
										else
										{
								?>
													<p class="prise"><?php echo $currency; ?>  @if(isset($attributes["attributes"]['price'])) {{ $attributes["attributes"]['price'] }} @endif</p>
								<?php 
										}
										
								?>
							
								</div>
							</div>
						</div>
					</div>
	<?php 
	
				}
			
	?>