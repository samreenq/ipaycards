

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
	
	
	@section("product")
				<?php
					if(isset($product['attributes']['category_id'][0]))
						$categories = $product['attributes']['category_id'][0];

                //Get image of product
                $gallery = isset($product['gallery'][0]) ? json_decode(json_encode($product['gallery'])) : false;
                $image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');


				?>
			<div class="feature-bg" style="background:url(<?php echo url('/').'/public/web/img/product/product-feature-img-1.jpg'; ?>);"></div>
			<section class="product-detail-Section pb-0">
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
								  		
														 <a class="breadcrumb-item" href="{{ url('/').'/product?entity_type_id=14&category_id='.$row['category_id']}}">
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
							<div class="align-items-end"><!--
								<ul class="changeProduct pull-right">
									<li><a href="#"><span class="icon-tt-left-arrow"></span></a></li>
									<li><a href="#"><span class="icon-tt-right-arrow"></span></a></li>
								</ul>
								-->
							</div>
						</div>
						<div class="detail_container whitebg">
							<div class="row">
								<div class="col-md-12 col-lg-6 pr-lg-0 align-items-start d-flex">
									<img src="<?php echo $image; ?>" alt="img" class="detail_img img-responsive"/> <!--class="productBigImg" -->


								</div>
								<div class="col-md-12 col-lg-6 pl-lg-0">
									<div class="productWholeDetail whitebg">


                                        <?php

                                        $price = '';
                                        $product_price = $product["attributes"]['price'];

                                        if(isset($product["attributes"]['product_promotion_id']))
                                        {
                                            if($product["attributes"]['product_promotion_id']>0)
                                            {
                                                if(isset($product["attributes"]['promotion_start_date']))
                                                    $start_date = date("Y-m-d H:i:s",strtotime($product["attributes"]['promotion_start_date']));
                                                if(isset($product["attributes"]['promotion_end_date']))
                                                    $end_date = date("Y-m-d H:i:s",strtotime($product["attributes"]['promotion_end_date']));
                                                $current_date = date("Y-m-d H:i:s");

                                                if(isset($start_date) && isset($end_date))
                                                {
                                                    if($current_date >=$start_date && $current_date <=$end_date )
                                                    {
                                                        if(isset($product["attributes"]['promotion_discount_amount']))
                                                        {
                                                            $price = $product["attributes"]['promotion_discount_amount'];
                                                        }

                                                    }
                                                }

                                            }
                                        }

                                        //if($product['attributes']['category_form']['option'])
                                        //{
                                        ?>
										{{--<a href="#" class="perishable">--}}<?php  //echo $product['attributes']['category_form']['option']; ?>{{--</a>--}}
                                        <?php
                                        //	}
                                        ?>
										<h2><?php if(isset($product['attributes']['title'])) echo $product['attributes']['title'];  ?></h2>
											@if(empty($price))
												<h3>{!! $currency.$product_price !!}</h3>
											@else
												<p class="prise_fordetail for_strike"><strike><?php if(isset($product["attributes"]['price'])) echo '$'.$product_price; ?></strike></p>
												<h3>&nbsp;{!! $currency.$price !!}</h3>

												@endif
											<?php if(isset($product["attributes"]['weight']) && isset($product["attributes"]['item_unit']['value']) && $product["attributes"]['item_unit']['option']) echo '/ ('.$product["attributes"]['weight'].' '.$product["attributes"]['item_unit']['option'].')'; ?></h3>
										<p>@if(isset($product['attributes']['description'])) {{ $product['attributes']['description'] }} @endif</p>

										<div class="cartShareWrap">
											<div class="d-sm-flex align-items-center mb30">
												<div class="count-input">
													<a class="incr-btn prn text-right" data-action="decrease" href="#"><span class="icon-tt-minus-icon"></span></a>
													<input type="hidden" name="entity_id" value="<?php if(isset($product['entity_id'])) echo $product['entity_id']; ?>" />
													<input type="hidden" name="product_code" value="<?php if(isset($product["attributes"]['product_code'])) echo $product["attributes"]['product_code'] ?>" />
													<input type="hidden" name="title" value="<?php if(isset($product["attributes"]['title'])) echo $product["attributes"]['title']; ?>" />
													<input type="hidden" name="thumb" value="<?php if(isset($product['gallery'][0]['file'])) echo $product['gallery'][0]['file']; ?>" />
													<input type="hidden" name="price" value="<?php if(!empty($price)) echo $price; else echo $product_price; ?>" />
													<input type="hidden" name="weight" value="<?php if(isset($product["attributes"]['weight'])) echo $product["attributes"]['weight']; ?>" />
													<input type="hidden" name="unit_option" value="<?php if(isset($product["attributes"]['item_unit']['option'])) echo $product["attributes"]['item_unit']['option']; ?>" />
													<input type="hidden" name="unit_value" value="<?php if(isset($product["attributes"]['item_unit']['value'])) echo $product["attributes"]['item_unit']['value']; ?>" />

													<input type="hidden" class="item_type" value="<?php if(isset($product["attributes"]['item_type']['value'])) echo $product["attributes"]['item_type']['value'] ?>" />

													<input class="quantity"  name="product_quantity"  type="text"  value="1"/>







													<a class="incr-btn pln text-left" data-action="increase" href="#"><span class="icon-tt-plus-icon"></span></a>
												</div>
												<button type="submit"  class="add add-to-cart">Add to cart</button>

											</div>


											<ul class="share-wishlist-wrap d-sm-flex ">
												<li><a href="#" data-toggle="modal" data-target=".socialmedia" ><span class="icon-tt-share-icon"></span> Share</a></li>


												<input type="hidden" class="entity_id" value="<?php if(isset($product['entity_id'])) echo $product['entity_id']; ?>" />
												<input type="hidden" class="product_code" value="<?php if(isset($product["attributes"]['product'])) echo $product["attributes"]['product_code'] ?>" />
												<input type="hidden" class="title" value="<?php if(isset($product["attributes"]['title'])) echo $product["attributes"]['title']; ?>" />
												<input type="hidden" class="thumb" value="<?php if(isset($product['gallery'][0]['file'])) echo $product['gallery'][0]['file']; ?>" />
												<input type="hidden" name="price" value="<?php if(!empty($price)) echo $price; else echo $product_price; ?>" />
												<input type="hidden" class="weight" value="<?php if(isset($product["attributes"]['weight'])) echo $product["attributes"]['weight']; ?>" />
												<input type="hidden" class="unit_option" value="<?php if(isset($product["attributes"]['item_unit']['option'])) echo $product["attributes"]['item_unit']['option']; ?>" />
												<input type="hidden" class="unit_value" value="<?php if(isset($product["attributes"]['item_unit']['value'])) echo $product["attributes"]['item_unit']['value']; ?>" />

												<li class="wishlist" >

													@if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
														<span class="icon-tt-like-icon add_to_wishlist_button "  <?php if($wishlist==1){ ?>style="color: #139CB4;" <?php } ?>  ></span>
													@else
														<span class="icon-tt-like-icon add_to_wishlist_button" data-toggle="modal" data-target=".siginmodal" ></span>
													@endif
													Add to Wishlist</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="direction">
									<h3>Direction</h3>
									<p>@if(isset($product['attributes']['direction'])) {{ $product['attributes']['direction'] }} @endif</p>
								</div>
							</div>
						</div>
						-->
					</div>
					
					
				</div>
			</section>
					
	@endsection
	
	
	
	@section("news_and_peak_seasons")
	
				<section class="lightgreybg topCategories">
					<div class="np-seasons">
						<div class="container">
							<div class="row align-items-baseline no-gutters mb30 stitle-wrap">
								<h2 class="mr-auto align-items-start">Related Items</h2>
								<a href="<?php echo url('/').'/product?entity_type_id=14&featured_type=1'; ?>" class="align-items-end viewMore" >See More</a>
							</div>
							<div class="row newsAndPeakSeasons">
									<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingnewsAndPeakSeasonsImage" align="center" style="display: none">
												<div class="floatingCirclesG">
													<div class="f_circleG frotateG_01"></div>
													<div class="f_circleG frotateG_02"></div>
													<div class="f_circleG frotateG_03"></div>
													<div class="f_circleG frotateG_04"></div>
													<div class="f_circleG frotateG_05"></div>
													<div class="f_circleG frotateG_06"></div>
													<div class="f_circleG frotateG_07"></div>
													<div class="f_circleG frotateG_08"></div>
												</div>
										</div>	
							</div>
						
						</div>
					</div>
				</section>
				
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
	
	@section("socialmedia")
		@include("web/includes/models/socialmedia")
	@endsection
	

	@section("foot")
		@include("web/includes/foot")
		
		

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
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


        var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
        menus("{{ route('menus') }}",category_id) ;

			load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
			total("{{ route('total_price') }}");			
			add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
			newsAndPeakSeasons(14,1,"{{ route('newsAndPeakSeasons') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}");
		
			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
			//topChefDeal("{{ route('top_chef_deals_list') }}");
			referAFriend("{{ route('refer_a_friend') }}");
			aboutBusiness("{{ route('aboutBusiness') }}")	;
			
			
			
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
						$('.tab-content ' + selector).css("min-height", '300px'); // i have given minimum height 
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
					
					$('.wishlist').on('click',function(e){
						$('.add_to_wishlist_button').css('color','#139CB4');
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
				
				//Inc Dec Button----------------
				$(".incr-btn").on("click", function (e) {
					var $button = $(this);
					var oldValue = $button.parent().find('.quantity').val();

                    if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {
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
                    }
				});
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
		
		</script>


	@endsection

