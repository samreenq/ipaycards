
@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")

					<link href="<?php echo url('/').'/public/web/css/select2.css';?>" rel="stylesheet"/>
					<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
					<link href="<?php echo url('/').'/public/web/css/ayoshare.css';?>" rel="stylesheet">
					<script src="http://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>
			
	@endsection


	@section("navbar")
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@include("web/includes/cartbar")
	@endsection

	@section('header')
			<!-- Header -->	
			
			<header id="detail-header">
				@include("web/includes/secondry_header")
			</header>
			
	@endsection
	
	<?php 
		//	print_r($recipe); exit;
	?>
	@section("product")
				<?php

                if(isset($recipe['category_id'][0]))
						$categories = $recipe['category_id'][0];

                //Get image of product

                //Get image of product
                $gallery = isset($recipe['gallery'][0]) ? json_decode(json_encode($recipe['gallery'])) : false;
                $image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
                //Get thumb of product
                $thumb = \App\Libraries\Fields::getGalleryImage($gallery,'product','thumb');

                $chef_gallery = isset($recipe['chef']['detail']['gallery'][0]) ? json_decode(json_encode($recipe['chef']['detail']['gallery'])) : false;
                $chef_image = \App\Libraries\Fields::getGalleryImage($chef_gallery,'chef','thumb');

				 //print_r($categories_all); exit;
				?>
			<div class="feature-bg" style="background:url(<?php echo url('/').'/public/web/img/product/product-feature-img-1.jpg'; ?>);"></div>
			<section class="product-detail-Section">
				<div class="container">
					<div class="productHeader">
						<div class="row align-items-baseline no-gutters mb20">
							<div class="align-items-start mr-auto">
								<div class="breadcrumb">
								   <a class="breadcrumb-item" href="">Home</a>
								   <?php 
											
												foreach( $categories_all as $row ) 
												{
													if($row['category_id'] ==  $categories['parent_id'])
													{
								   ?>
														 <a class="breadcrumb-item" href="{{ url('/').'/recipe?entity_type_id=14&category_id='.$row['category_id']}}">
									  <?php 
															echo $row['title'];
									  ?>
														  </a>
									 <?php
													}
												}
									  
									  ?>
								
								  <?php 
										if(isset($categories))
										{
								  ?>
											<span class="breadcrumb-item"><?php echo $categories['title']; ?></span>
								  <?php
										}
								  ?>
								</div>
							</div>
							<div class="align-items-end">
							<!--
								<ul class="changeProduct pull-right">
									<li><a href="#"><span class="icon-tt-left-arrow"></span></a></li>
									<li><a href="#"><span class="icon-tt-right-arrow"></span></a></li>
								</ul>
								-->
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-lg-6 pr-lg-0">
								<img src='<?php echo $image; ?>' alt="img" class="productBigImg img-responsive" width="570px" height="651px"/>
							</div>
							<div class="col-md-12 col-lg-6 pl-lg-0">
								<div class="recipeWholeDetail whitebg">
									<div class="col-md-10 m-sm-auto">
										<div class="chiefName vam"><img src="<?php echo $chef_image; ?>" width="31" height="31"><?php if(isset($recipe['chef']['detail']['name'])) echo $recipe['chef']['detail']['name'] ; ?>(<?php echo  $recipe['chef']['detail']['recipe_count']; ?>)</div>
										<h2><?php if(isset($recipe['title'])) echo $recipe['title'];  ?><span></span></h2>
										<ul class="vam">
                                            <?php if(isset($recipe['cooking_minutes']) && $recipe['cooking_minutes'] > 0){ ?>
											<li><span class="icon-tt-clock-icon"></span> <?php echo $recipe['cooking_minutes']; ?> Min Total</li>
                                                <?php } ?>
											<li><span class="icon-tt-dish-icon"></span> <?php if(isset($recipe['serving'])) echo $recipe['serving'].' Servings ';?> </li>
										</ul>
										<div class="d-sm-flex align-items-center mb20">
											<h3 class="mr-auto align-items-start"><?php echo $currency; ?> <?php if(isset($recipe['price'])) echo $recipe['price']; ?>  <?php if(isset($recipe['weight']) && isset($recipe['weight']) && $recipe['item_unit']['option']) echo ' / ('.$recipe['weight'].' '.$recipe['item_unit']['option'].')'; else echo "/ each"; ?></h3>
											<!--<a href="#" class="align-items-end viewIngredients">View Ingredients</a>-->
										</div>
										<p><?php if(isset($recipe['description'])) echo $recipe['description']; ?></p>
										<div class="d-sm-flex align-items-center mb50">
											<div class="count-input">
												<a class="incr-btn prn text-right" data-action="decrease" href="#"><span class="icon-tt-minus-icon"></span></a>
												<input type="hidden" name="entity_id" value="<?php if(isset($recipe['entity_id'])) echo $recipe['entity_id']; ?>" />
												<input type="hidden" name="product_code" value="<?php if(isset($recipe['product_code'])) echo $recipe['product_code'] ?>" />
												<input type="hidden" name="title" value="<?php if(isset($recipe['title'])) echo $recipe['title']; ?>" />
												<input type="hidden" name="thumb" value="<?php echo $thumb; ?>" />
												<input type="hidden" name="price" value="<?php if(isset($recipe['price'])) echo $recipe['price']; ?>" />
												<input type="hidden" name="weight" value="<?php if(isset($recipe['weight'])) echo $recipe['weight']; ?>" />
												<input type="hidden" name="unit_option" value="<?php if(isset($recipe['item_unit']['option'])) echo $recipe['item_unit']['option']; ?>" />
												<input type="hidden" name="unit_value" value="<?php if(isset($recipe['item_unit']['value'])) echo $recipe['item_unit']['value']; ?>" />
												<input class="quantity"  name="product_quantity"  type="text"  value="1"/>
												
												<a class="incr-btn pln text-left" data-action="increase" href="#"><span class="icon-tt-plus-icon"></span></a>
											</div>
											<button type="submit"  class="add add-to-cart">Add to cart</button>
										</div>
										<ul class="share-wishlist-wrap d-sm-flex">
											<li><a href="#" data-toggle="modal" data-target=".socialmedia"><span class="icon-tt-share-icon"></span> Share</a></li>
											
											
													<input type="hidden" class="entity_id" value="<?php if(isset($recipe['entity_id'])) echo $recipe['entity_id']; ?>" />
													<input type="hidden" class="product_code" value="<?php if(isset($recipe['product_code'])) echo $recipe['product_code'] ?>" />
													<input type="hidden" class="title" value="<?php if(isset($recipe['title'])) echo $recipe['title']; ?>" />
													<input type="hidden" class="thumb" value="<?php echo $thumb; ?>" />
													<input type="hidden" class="price" value="<?php if(isset($recipe['price'])) echo $recipe['price']; ?>" />
													<input type="hidden" class="weight" value="<?php if(isset($recipe['weight'])) echo $recipe['weight']; ?>" />
													<input type="hidden" class="unit_option" value="<?php if(isset($recipe['item_unit']['option'])) echo $recipe['item_unit']['option']; ?>" />
													<input type="hidden" class="unit_value" value="<?php if(isset($recipe['item_unit']['value'])) echo $recipe['item_unit']['value']; ?>" />
											
													
												<li class="wishlist">
													@if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
														<span class="icon-tt-like-icon add_to_wishlist_button "  <?php if($wishlist==1){ ?>style="color: #139CB4;" <?php } ?>  ></span>
													@else
														<span class="icon-tt-like-icon add_to_wishlist_button" data-toggle="modal" data-target=".siginmodal" ></span>
													@endif
													Add to Wishlist
												</li>
										</ul>
									</div>
								</div>
							</div><!--
							<div class="col-md-12 col-lg-6 pl-lg-0">
								<div class="productWholeDetail whitebg">
									
										<a href="#" class="perishable">Perashible</a>
										
										<h2><?php if(isset($recipe['title'])) echo $recipe['title'];  ?></h2>
										<h3><?php echo $currency; ?> <?php if(isset($recipe['price'])) echo $recipe['price']; ?>  <?php if(isset($recipe['weight']) && isset($recipe['weight']) && $recipe['item_unit']['option']) echo ' / ('.$recipe['weight'].' '.$recipe['item_unit']['option'].')'; ?></h3>
										<p> <?php if(isset($recipe['description'])) echo $recipe['description']; ?>?></p>
										
										
										
										<div class="d-sm-flex align-items-center mb50">
											<div class="count-input">
												<a class="incr-btn prn text-right" data-action="decrease" href="#"><span class="icon-tt-minus-icon"></span></a>
												<input type="hidden" name="entity_id" value="<?php if(isset($recipe['entity_id'])) echo $recipe['entity_id']; ?>" />
												<input type="hidden" name="product_code" value="<?php if(isset($recipe['product_code'])) echo $recipe['product_code'] ?>" />
												<input type="hidden" name="title" value="<?php if(isset($recipe['title'])) echo $recipe['title']; ?>" />
												<input type="hidden" name="thumb" value="<?php if(isset($recipe['gallery'][0]['file'])) echo $recipe['gallery'][0]['file']; ?>" />
												<input type="hidden" name="price" value="<?php if(isset($recipe['price'])) echo $recipe['price']; ?>" />
												<input type="hidden" name="weight" value="<?php if(isset($recipe['weight'])) echo $recipe['weight']; ?>" />
												<input type="hidden" name="unit_option" value="<?php if(isset($recipe['item_unit']['option'])) echo $recipe['item_unit']['option']; ?>" />
												<input type="hidden" name="unit_value" value="<?php if(isset($recipe['item_unit']['value'])) echo $recipe['item_unit']['value']; ?>" />
												<input class="quantity"  name="product_quantity"  type="text"  value="1"/>
												
												<a class="incr-btn pln text-left" data-action="increase" href="#"><span class="icon-tt-plus-icon"></span></a>
											</div>
											<button type="submit"  class="add add-to-cart">Add to cart</button>
										</div>
										<ul class="share-wishlist-wrap d-sm-flex">
											<li><a href="#" data-toggle="modal" data-target=".socialmedia"><span class="icon-tt-share-icon"></span> Share</a></li>
											
											
													<input type="hidden" class="entity_id" value="<?php if(isset($recipe['entity_id'])) echo $recipe['entity_id']; ?>" />
													<input type="hidden" class="product_code" value="<?php if(isset($recipe['product_code'])) echo $recipe['product_code'] ?>" />
													<input type="hidden" class="title" value="<?php if(isset($recipe['title'])) echo $recipe['title']; ?>" />
													<input type="hidden" class="thumb" value="<?php if(isset($recipe['gallery'][0]['file'])) echo $recipe['gallery'][0]['file']; ?>" />
													<input type="hidden" class="price" value="<?php if(isset($recipe['price'])) echo $recipe['price']; ?>" />
													<input type="hidden" class="weight" value="<?php if(isset($recipe['weight'])) echo $recipe['weight']; ?>" />
													<input type="hidden" class="unit_option" value="<?php if(isset($recipe['item_unit']['option'])) echo $recipe['item_unit']['option']; ?>" />
													<input type="hidden" class="unit_value" value="<?php if(isset($recipe['item_unit']['value'])) echo $recipe['item_unit']['value']; ?>" />
											
													
												<li class="wishlist">
												
													<span class="icon-tt-like-icon  "></span>
													Add to Wishlist
												</li>
										</ul>
									
								</div>
							</div> -->
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="recipeTabsWrap">
									<!-- Nav tabs -->
									<ul class="recipe-nav-tabs nav  clearfix" role="tablist">
										<li role="presentation" ><a href="#directions" aria-controls="directions" class="nav-link active" role="tab" data-toggle="tab">Directions</a></li>
										<li role="presentation"><a href="#ingredients" aria-controls="ingredients" class="nav-link" role="tab" data-toggle="tab">Ingredients</a></li>
										<li role="presentation"><a href="#reviews" aria-controls="reviews" class="nav-link" role="tab" data-toggle="tab">Reviews</a></li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="directions">
											
											<div class="row">
												<div class="col-md-9">
													<p>
														@if(isset($recipe['direction'])) {{ $recipe['direction'] }} @endif.
													</p>
												</div>
												
											</div>
											
										</div>
										<div role="tabpanel" class="tab-pane" id="ingredients">
											<ul class="row clearfix">
												<?php 
												
														
														if(isset($recipe['product_recipe_id']['recipe_item']))
															foreach($recipe['product_recipe_id']['recipe_item'] as $ingredients )
															{

                                                				$item_unit = isset($ingredients['item_id']['detail']['item_unit']['option']) ? "&nbsp;".$ingredients['item_id']['detail']['item_unit']['option']: "";


												?>
																<li>
												<?php
																		if(isset($ingredients['item_id']['detail']['title'])) 
																			echo $ingredients['item_id']['detail']['title'];
																
												?>
																		<span>
																				<?php 
																						if(isset($ingredients['weight'])) 
																								echo $ingredients['weight'].$item_unit;
																				?>
																		</span>
																</li>
												<?php
															}
												?>
												
											</ul>
											
										</div>
										<div role="tabpanel" class="tab-pane" id="reviews">
											<div class="row">
												
												<?php 
														if(Session::has('users'))
															$user = Session::get('users', 'default'); 
														else 
															$user[0]['entity_id'] = 0; 
														
														$check = 0;
														if(isset($reviews))
															foreach ( $reviews as $review_attributes ) 
															{
																if($user[0]['entity_id']== $review_attributes['customer']['entity_id'])
																	$check = 1; 
																else 
																	$check = 0;
																
														
												?>
																<div class="col-md-6 col-lg-4 singleReview">
																	<ul class="starRating">
																		<?php 
																				$score = $review_attributes['rating'];
																				$less  = 5 - $review_attributes['rating']; 
																				for ( $i=1;$i<=$score;$i++) 
																				{
																		?>
																					<li><span class="icon-tt-star-fill-icon"></span></li>
																					
																		<?php 
																				}
																		?>
																		<?php 
																				for ( $i=1;$i<=$less;$i++) 
																				{
																					
																		?>
																						<li><span class="icon-tt-star-icon"></span></li>
																		<?php 
																				}
																		?>
																					
																					<li>(<?php echo $review_attributes['rating']; ?>)</li>
																	</ul>
																	<p><?php echo $review_attributes['review']; ?></p>
																	<p class="reviewGiver"><?php echo $review_attributes['customer']['first_name'].' '.$review_attributes['customer']['last_name']; ?> - <span><?php echo date("m/d/y",strtotime($review_attributes['created_at']));?></span></p>
																</div>
												<?php 
															}
												?>
													
													<div class="col-md-12 text-center">
													
														@if( $check==0  ) 
															@if(  (isset($_SESSION['fbUserProfile']) || Session::has('users')) )
																	<a href="#" data-toggle="modal" data-target=".reviewmodal" class="reviewMore">Write a review</a>
															@else 
																	<a href="#" data-toggle="modal" data-target=".siginmodal" class="reviewMore">Write a review</a>
															@endif
														@endif
													</div>
														
													
													<?php
													//<pre>if(isset($recipe['description'])) {{ $recipe['description'] }} @endif</pre>
													?>
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
					
	@endsection
	
	@section("recipie_chef_fegs")
			@include("web/includes/recipe/recipie_chef_fegs")
	@endsection
	
	@section("footer")
		@include("web/includes/footer")
	@endsection

	
	
	
	
	
	{{--  Models   --}}
	

	@section("signin")
		@include("web/includes/models/signin")
	@endsection

	@section("signup")
		@include("web/includes/models/signup")
	@endsection
	
	@section("about_us")
		@include("web/includes/models/about_us")
	@endsection
	
	
	@section("refer_friend")
		@include("web/includes/models/refer_friend")
	@endsection
	
	@section("change_password")
		@include("web/includes/models/change_password")
	@endsection

	
	@section("forget_password")
		@include("web/includes/models/forget_password")
	@endsection
	
	
	
	@section("phone_verification")
		
		@include("web/includes/models/phone_verification")
	@endsection

	@section("social_phone_verification")
		
		@include("web/includes/models/social_phone_verification")
	@endsection
	
	@section("review")
	
		@include("web/includes/models/review")
	@endsection
	
	@section("socialmedia")
	
		@include("web/includes/models/socialmedia")
	@endsection
	

	@section("foot")
		@include("web/includes/foot")
		
		

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
		<!-- jQuery Awesome Sosmed Share Button -->
		<script src="<?php echo url('/').'/public/web/js/ayoshare.js';?>"></script>		
		<script>
		$(function() {
			$(".anu").ayoshare({
				counter: true,
				button: {
					google : true,
					facebook : true,
					pinterest : true,
					linkedin : true,
					twitter : true,
					flipboard : true,
					email : true,
					whatsapp : true,
					telegram : true,
					line : true,
					bbm : true,
					viber : true,
					sms : true
				}
			});
			$("#unik").ayoshare({
				button: {
					google : true,
					stumbleupon : true,
					facebook : true,
					pinterest : true,
					bufferapp : true,
					reddit : true,
					vk : true,
					pocket : true,
					twitter : true,
					digg : true,
					telegram : true,
					sms : true
				}
			});
		});
		</script>
			
		<script>


            var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
            menus("{{ route('menus') }}",category_id) ;
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				
				signin("{{ route('signin') }}");
				//signup("{{ route('signup') }}");
				
				saveReview("{{ route('review') }}");
				topChefDeal("{{ route('top_chef_deals_list') }}");
				guestChefDeal("{{ route('guest_chef_deals_list') }}");
				
				add_to_wishlist("{{ route('add_to_wishlist') }}");
				
				aboutBusiness("{{ route('aboutBusiness') }}")	;
				referAFriend("{{ route('refer_a_friend') }}");
			
				
				load_wishlist("{{ route('add_to_wishlist') }}");
				
				
				
				
				// Auto Adjust Height
				$(window).on('load', function() {
					
					//$('#flowers li').click(function(){
					//	$('.collapse').collapse('hide');
					//});
					//$(document).click(function(){
					//	$('.collapse').collapse('hide');
					//});
				
					
					function resize(selector, footer) {
						var totalheight = $(window).height();
						if(footer){
							var lessheight = $('.cart-tabs .cartTabHeader').height() + $('.tab-content .cartTabFooter').height();
							var docheight = totalheight - lessheight;
						}else{
							var lessheight = parseInt($('.cart-tabs .cartTabHeader').height());
							var docheight = totalheight - lessheight - parseInt(25);
						}			
									
						$('.tab-content ' + selector).css("height", docheight);		
						$('.tab-content ' + selector).css("min-height", '556px'); // i have given minimum height
					}
					
					$(document).ready(function() {
						resize('.basketList',false); //basketList
						resize('.wishList',false); //wishList
					});
					
					$(window).resize(function() {
						resize('.basketList',false); //basketList
						resize('.wishList',false); //wishList
					});
						
				});

				// Modal Script
				$('#myModal').on('shown.bs.modal', function () {
					$('#myInput').focus()
				});
				
				// Add Cart Btn Animation
				$('.addtocart').click(function(){
					$(this).hide();
					var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
				});

				// All Small Script
				$(document).ready(function () {
					//Select2
					$(".js-example-basic-single").select2({
						minimumResultsForSearch: Infinity
					});
					
					//Sider Bar Fixed on Scroll
					$('#sidebar').stickySidebar({
						topSpacing: 20,
						containerSelector: '.container',
						innerWrapperSelector: '.sidebar__inner'
					});
				 
					// Field Style
					$(".fluid-label").focusout(function(){
						$(".focused").removeClass("focused");	
					});
					$('.fluid-label').fluidLabel({
						focusClass: 'focused'
					});
					
					//Navigation Menu Slider
					$('#cartList, #cartList2').on('click',function(e){
						e.preventDefault();
						$('body').toggleClass('nav-expanded');
					});
                    $('.overlay').on('click', function (e) {
                        e.preventDefault();
                        $('body').toggleClass('nav-expanded');
                    });
					$('#nav-close').on('click',function(e){
						e.preventDefault();
						$('body').removeClass('nav-expanded');
					});
					$('.basketList').enscroll({
						showOnHover: true,
						verticalTrackClass: 'track3',
						verticalHandleClass: 'handle3'
					});
					$('.wishList').enscroll({
						showOnHover: true,
						verticalTrackClass: 'track3',
						verticalHandleClass: 'handle3'
					});
					
					$('.wishlist').on('click',function(e){
						$('.add_to_wishlist_button').css('color','#139CB4');
					});
					
					//Header Slider
					$('.headerSlider').bxSlider({
						mode: 'fade',
						speed: 1000,
						captions: true,
						pager: false,
						controls: false,
						auto: true
					});
					
					// Wizard Form

					
				});
				
				// Star Rating
					var $star_rating = $('.star-rating .tt');
						var SetRatingStar = function() {
						  return $star_rating.each(function() {
							if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
							  return $(this).removeClass('icon-tt-star-icon').addClass('icon-tt-star-fill-icon');
							} else {
							  return $(this).removeClass('icon-tt-star-fill-icon').addClass('icon-tt-star-icon');
							}
						  });
						};

						$star_rating.on('click', function() {
							
						$('#rating').val($(this).data('rating'));
						  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
						  return SetRatingStar();
						});

						SetRatingStar();
						$(document).ready(function() {

						});
				
				//Inc Dec Button----------------
				$(".incr-btn").on("click", function (e) {
					var $button = $(this);
					var oldValue = $button.parent().find('.quantity').val();
					$button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
					if ($button.data('action') == "increase") {
						var newVal = parseFloat(oldValue) + 1;
					} else {
						// Don't allow decrementing below 1
						if (oldValue > 1) {
							var newVal = parseFloat(oldValue) - 1;
						} else {
							newVal = 1;
							$button.addClass('inactive');
						}
					}
					$button.parent().find('.quantity').val(newVal);
					e.preventDefault();
				});
				
		
		</script>


	@endsection

