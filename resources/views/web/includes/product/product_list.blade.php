
<?php 

	if(isset($products[0])) 
	{	
			foreach ( $products  as $productItemsList )
			{

				//Get image of product
				$gallery = isset($productItemsList['gallery'][0]) ? json_decode(json_encode($productItemsList['gallery'])) : false;
				$image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
					$thumb = \App\Libraries\Fields::getGalleryImage($gallery, 'product', 'thumb');

								if(isset($productItemsList["attributes"]['product_promotion_id']))
								{
									if($productItemsList["attributes"]['product_promotion_id']>0) 
									{
										if(isset($productItemsList["attributes"]['promotion_start_date']))
											$start_date = date("Y-m-d H:i:s",strtotime($productItemsList["attributes"]['promotion_start_date'])); 
										if(isset($productItemsList["attributes"]['promotion_end_date']))
											$end_date = date("Y-m-d H:i:s",strtotime($productItemsList["attributes"]['promotion_end_date'])); 
										$current_date = date("Y-m-d H:i:s"); 
										
										if(isset($start_date) && isset($end_date))
										{
											if($current_date >=$start_date && $current_date <=$end_date ) 
											{
												if(isset($productItemsList["attributes"]['promotion_discount_amount']))
												{
													$price = $productItemsList["attributes"]['promotion_discount_amount'];
												}
												else
												{
													if(isset($productItemsList["attributes"]['price']))
														$price = $productItemsList["attributes"]['price'];
													else 
														$price = '';
												}
											}
											else 
											{
												if(isset($productItemsList["attributes"]['price']))
													$price = $productItemsList["attributes"]['price'];
												else 
													$price = '';
											}
										}
										else 
										{
											if(isset($productItemsList["attributes"]['price']))
												$price = $productItemsList["attributes"]['price'];
											else 
												$price = '';
										}
									}
									else
									{
										if(isset($productItemsList["attributes"]['price']))
											$price = $productItemsList["attributes"]['price'];
										else 
											$price = '';
									}
								}
								else
								{
									if(isset($productItemsList["attributes"]['price']))
										$price = $productItemsList["attributes"]['price'];
									else 
										$price = '';
								}
								
							
						?>

				<div  class="col-sm-6 <?php if(!isset($_REQUEST['category_id'])){ ?>col-md-3 <?php }else { ?> col-md-4<?php } ?> d-flex" >
				
					<div class="product-wrap whitebg">
					
						<input type="hidden" class="entity_id" value="<?php if(isset($productItemsList['entity_id'])) echo $productItemsList['entity_id']; ?>" />
						<input type="hidden" class="product_code" value="<?php if(isset($productItemsList["attributes"]['product_code'])) echo $productItemsList["attributes"]['product_code'] ?>" />
						<input type="hidden" class="title" value="<?php if(isset($productItemsList["attributes"]['title'])) echo $productItemsList["attributes"]['title']; ?>" />
						<input type="hidden" class="thumb" value="<?php echo $thumb; ?>" /><input type="hidden" class="price" value="<?php echo $price; ?>" />
						<input type="hidden" class="weight" value="<?php if(isset($productItemsList["attributes"]['weight'])) echo $productItemsList["attributes"]['weight']; ?>" />
						<input type="hidden" class="unit_option" value="<?php if(isset($productItemsList["attributes"]['item_unit']['option'])) echo $productItemsList["attributes"]['item_unit']['option']; ?>" />
						<input type="hidden" class="unit_value" value="<?php if(isset($productItemsList["attributes"]['item_unit']['value'])) echo $productItemsList["attributes"]['item_unit']['value']; ?>" />
						<input type="hidden" class="item_type" value="<?php if(isset($productItemsList["attributes"]['item_type']['value'])) echo $productItemsList["attributes"]['item_type']['value'] ?>" />
						

							
							@if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
					
								{{--	<button class="like-btn wishlist"><span class="icon-tt-like-icon"></span></button>--}}
							@else 
									{{--<button 	data-toggle="modal" data-target=".siginmodal" class="like-btn "><span class="icon-tt-like-icon"></span></button>--}}
								
							@endif
						<a href="<?php if(isset($productItemsList['attributes']['product_code'])) echo $product_detail_url.'?entity_type_id='.$productItemsList['entity_type_id'].'&product_code='.$productItemsList['attributes']['product_code'];  ?>" >
							<img class="lazyload img-responsive" src='<?php echo $image; ?>' class="img-responsive" width="268px" height="180px"/>
						</a>
						<div class="product-detail" id="product-{!! $productItemsList['entity_id'] !!}">
							<div class="addCartWrap">	
							
									<input type="hidden" class="entity_id" value="<?php if(isset($productItemsList['entity_id'])) echo $productItemsList['entity_id']; ?>" />
									<input type="hidden" class="product_code" value="<?php if(isset($productItemsList["attributes"]['product_code'])) echo $productItemsList["attributes"]['product_code'] ?>" />
									<input type="hidden" class="title" value="<?php if(isset($productItemsList["attributes"]['title'])) echo $productItemsList["attributes"]['title']; ?>" />
								<input type="hidden" class="thumb" value="<?php echo $thumb; ?>" /><input type="hidden" class="price" value="<?php echo $price; ?>" />
									<input type="hidden" class="weight" value="<?php if(isset($productItemsList["attributes"]['weight'])) echo $productItemsList["attributes"]['weight']; ?>" />
									<input type="hidden" class="unit_option" value="<?php if(isset($productItemsList["attributes"]['item_unit']['option'])) echo $productItemsList["attributes"]['item_unit']['option']; ?>" />
									<input type="hidden" class="unit_value" value="<?php if(isset($productItemsList["attributes"]['item_unit']['value'])) echo $productItemsList["attributes"]['item_unit']['value']; ?>" />
									<input type="hidden" class="quantity" name="product_quantity" value="1"/>
									<input type="hidden" class="item_type" value="<?php if(isset($productItemsList["attributes"]['item_type']['value'])) echo $productItemsList["attributes"]['item_type']['value'] ?>" />


								<button class="addtocart">
									<span class="icon-tt-cart-Icon"></span>
								</button>
								<div class="pro-inc-wrap">
										<div class="count-input">
										<a class="incr-btn  incr-btn3 text-right prn" data-action="decrease" >
											<span class="add icon-tt-minus-icon"></span>
										</a>
										
										<input type="hidden" class="entity_id" value="<?php if(isset($productItemsList['entity_id'])) echo $productItemsList['entity_id']; ?>" />
										<input type="hidden" class="product_code" value="<?php if(isset($productItemsList["attributes"]['product_code'])) echo $productItemsList["attributes"]['product_code'] ?>" />
										<input type="hidden" class="title" value="<?php if(isset($productItemsList["attributes"]['title'])) echo $productItemsList["attributes"]['title']; ?>" />
											<input type="hidden" class="thumb" value="<?php echo $thumb; ?>" /><input type="hidden" class="price" value="<?php echo $price; ?>" />
										<input type="hidden" class="weight" value="<?php if(isset($productItemsList["attributes"]['weight'])) echo $productItemsList["attributes"]['weight']; ?>" />
										<input type="hidden" class="unit_option" value="<?php if(isset($productItemsList["attributes"]['item_unit']['option'])) echo $productItemsList["attributes"]['item_unit']['option']; ?>" />
										<input type="hidden" class="unit_value" value="<?php if(isset($productItemsList["attributes"]['item_unit']['value'])) echo $productItemsList["attributes"]['item_unit']['value']; ?>" />
										<input class="quantity" type="number" name="product_quantity" value="1"/>
										<input type="hidden" class="item_type" value="<?php if(isset($productItemsList["attributes"]['item_type']['value'])) echo $productItemsList["attributes"]['item_type']['value'] ?>" />


											<a class=" incr-btn incr-btn3 text-left pln" data-action="increase" >
											<span class="add icon-tt-plus-icon"></span>
										</a>
									</div>
								</div>
							</div>
							{{--<a href="{!! url('/') !!}/product_detail?entity_type_id=14&product_code={!! $productItemsList['attributes']['product_code'] !!}" class="perishable">{!! $productItemsList['attributes']['product_code'] !!}</a>--}}
							<h4>
								<a href="<?php if(isset($productItemsList['attributes']['product_code'])) echo $product_detail_url.'?entity_type_id='.$productItemsList['entity_type_id'].'&product_code='.$productItemsList['attributes']['product_code']; ?>" >
								@if(isset($productItemsList["attributes"]['title'])) {{ $productItemsList["attributes"]['title'] }} @endif</a>
							</h4>										
							<div class="product-footer clearfix">
								<span class="count">
													
																    
																		@if(isset($productItemsList["attributes"]['weight']) && isset($productItemsList["attributes"]['item_unit']['option'])) 
																			{{ '('  }} 
																				{{	$productItemsList["attributes"]['weight']}}
																					
																				{{$productItemsList["attributes"]['item_unit']['option']}}
																			{{ ' )' }}
																		@endif
																					
															
								</span>
								
								<?php 
								
										if(isset($productItemsList["attributes"]['product_promotion_id'])) 
										{
											if($productItemsList["attributes"]['product_promotion_id']>0) 
											{
												if(isset($productItemsList["attributes"]['promotion_start_date']))
													$start_date = date("Y-m-d H:i:s",strtotime($productItemsList["attributes"]['promotion_start_date'])); 
												if(isset($productItemsList["attributes"]['promotion_end_date']))
													$end_date = date("Y-m-d H:i:s",strtotime($productItemsList["attributes"]['promotion_end_date'])); 
												$current_date = date("Y-m-d H:i:s"); 
											
												if(isset($start_date) && isset($end_date))
												{
													if($current_date >=$start_date && $current_date <=$end_date ) 
													{
														if(isset($productItemsList["attributes"]['promotion_discount_amount']))
															$price = $productItemsList["attributes"]['promotion_discount_amount'];
								?>
														<p class="prise for_strike"><strike><?php echo $currency; ?>  <?php echo $productItemsList["attributes"]['price']; ?>  </strike></p>
														<p class="prise">&nbsp;&nbsp;&nbsp;</p>
														<p class="prise"><?php echo $currency; ?>  <?php if(isset($productItemsList["attributes"]['promotion_discount_amount'])) echo $productItemsList["attributes"]['promotion_discount_amount']; ?></p>


								<?php 		
													}
													else 
													{
								?>
													<p class="prise"><?php echo $currency; ?>  @if(isset($productItemsList["attributes"]['price'])) {{ $productItemsList["attributes"]['price'] }} @endif</p>
								<?php 	
													}
												}
												else 
												{
								?>
													<p class="prise"><?php echo $currency; ?>   @if(isset($productItemsList["attributes"]['price'])) {{ $productItemsList["attributes"]['price'] }} @endif</p>
								<?php 	
												}
								?>
											
								<?php 
											}
											else
											{
								?>
													<p class="prise"><?php echo $currency; ?>  @if(isset($productItemsList["attributes"]['price'])) {{ $productItemsList["attributes"]['price'] }} @endif</p>
								<?php 
											}
										}
										else
											{
								?>
													<p class="prise"><?php echo $currency; ?>  @if(isset($productItemsList["attributes"]['price'])) {{ $productItemsList["attributes"]['price'] }} @endif</p>
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

								
<?php
			
	}
	else
	{
?>
				<!--
					<section class="error404-Section lightgreybg">
						<div class="container">
							<div class="row">
								<div class="col-sm-12 m-sm-auto col-md-12 m-md-auto col-lg-12 m-lg-auto">
									<div class="error404img">
										<img class="img-responsive" src="{{url('/')}}/public/web/img/error404.png" alt="error404" width="309">
									</div>
									<div class="error404content text-center">
										<h2>No Product Found</h2>
										<p>We are sorry but the product you are looking for does not exist.<br>You could return to the <a href="{{url('/')}}">homepage</a></p>
									</div>
									
								</div>
							</div>
						</div>
					</section>
					-->
					
					
					<div class="error404Wrap ml-auto mr-auto mt70 mb70">
										<div class="error404img mt50 mb50">
											<img class="img-responsive" src="{{ url('/') }}/public/web/img/error404.png" alt="error404" width="309">
										</div>
										<div class="error404content text-center">
											<h2>No Product Found</h2>
											<p>We are sorry but the product you are looking for does not exist.<br>You could return to the <a href="{{url('/')}}">homepage</a></p>
										</div>
					</div>

<?php		
	}
?>
		

			