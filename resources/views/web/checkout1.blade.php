

@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")
		 <link href="<?php echo url('/').'/public/web/css/select2.css';?>" rel="stylesheet"/>
			
	@endsection


	@section("navbar")
		@parent
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@parent
		
		@include("web/includes/cartbar")
	@endsection
		
		
	
	@section("checkout1")
			
		<section class="checkout-step-1 lightgreybg">
			<div class="container">
				<div class="checkout-header">
					<ul class="checkout-steps">
						<li class="active"><a href="javascript:void(0)"><span>1</span> Review your Order</a></li>
						<li><a ><span>2</span> Delivery Info</a></li>
						<li><a ><span>3</span> Order Confirm</a></li>
					</ul>
				</div>
				<div class="row clearfix recipeFixed">
					<div class="col-md-12 col-lg-8 recipe-item-wrap">
						<div class="greybg clearfix align-items-center d-sm-flex">
							<h4 class="mr-auto align-items-start">Your Basket</h4>
							<div class="align-items-start selectDayWrap">
								<!--<select class="day js-example-basic-single ">-->

								<!--</select>-->
							</div>
							{{--<div class="align-items-start selectTimeWrap pl-sm-2">
								<select class="time js-example-basic-single ">
									<option value="">NA</option>
								</select>
							</div>--}}
						</div>
						<div id="show_list" class="whitebg recipe-item-list">
									<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
												"
												
									id="LoadingImageCart" align="center" style="display: none">
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
					<div class="col-md-12 col-lg-4">
						<div id="sidebarCheckout">
							<div class="whitebg checkOrderWrap sidebar__inner">
								<h4>Summary</h4>
								
								<p>You will recieve your voucher codes after payment via email.</p>
								
								<!--
										<form role="form">
											<div class="fluid-label">
											   <span class="icon-tt-cupon-icon"></span>
											   <input id="coupon_code" type="text" placeholder="Coupon Code" />
											   <label>Coupon Code</label>
											</div>
											<input  type="button" name="" value="Apply" class="calculateDiscount coupon-btn"/>
										</form>
								-->
								<div class="checkOrderTotal">
									<table width="100%"> 
										<!--
										<tr>
											<td class="summaryTitle">Coupons Discount</td>
											<td class="summaryPrice discount"></td>
										</tr>
										
										<tr>
											<td class="summaryTitle">Loyalty Points</td>
											<td class="summaryPrice calculated_loyalty_points"></td>
										</tr>
										-->
									<!--
										<tr>
											<td class="summaryTitle">Delivery Charges</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
										
										<tr>
											<td class="summaryTitle">Tax</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
										
									-->
										<tr class="borderB"><td colspan="2"><div></div></td></tr>
										<tr>
											<td class="summaryTitle">Order Total</td>
											<td class="totalPrice subtotal">$</td>
										</tr>
										<tr>
											<td colspan="2"  align="center"></td>
										</tr>
									</table>
									
									
									
									
									
									<?php
							
											if (isset($_SESSION['fbUserProfile']) )
											{
									  ?>
													<div class="checkFooter  text-center">
																	<button  class="checkout btn-block" >Check Out</button>
																	<p class="text-center"><span class="icon-tt-lock-icon"></span> Secure SSL Checkout</p>
													</div>
													

									  <?php
											}

											if (Session::has('users')  )
											{
										
									?>
												<div class="checkFooter  text-center">
																	<button  class="checkout btn-block" >Check Out</button>
																	<p class="text-center"><span class="icon-tt-lock-icon"></span> Secure SSL Checkout</p>
																</div>
													
									
									<?php 
											}
											if (!Session::has('users') && !isset($_SESSION['fbUserProfile']) )
											{

									?>
													<div class="checkFooter text-center">
																	<a href="javascript:void(0)" data-toggle="modal" data-target=".siginmodal" >Check Out</a>
																	<p class="text-center"><span class="icon-tt-lock-icon"></span> Secure SSL Checkout</p>
													</div>
									<?php 
											}


									?>
									
									
									
									
									
									
									
									
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>


	@endsection
	
	
		
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
	
	
	@section("phone_verification")
		
		@include("web/includes/models/phone_verification")
	@endsection
	
	@section("social_phone_verification")
		
		@include("web/includes/models/social_phone_verification")
	@endsection	
	
	
	@section("change_password")

		@include("web/includes/models/change_password")
	@endsection
	
	@section("forget_password")
		@include("web/includes/models/forget_password")
	@endsection
	
	
	@section("editYourDetailmodal")
	
		@include("web/includes/models/editYourDetailmodal")
	@endsection
	
	@section("footer")
		@parent
		
		@include("web/includes/footer")
	@endsection


	@section("foot")
		@include("web/includes/foot")
		
		
		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js';?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
	

		<script>
				<?php 
					if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
					{
				?>
						load_wishlist("{{ route('add_to_wishlist') }}");
					
				<?php 
					}
				?>	
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				show_cart("{{ route('show_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				checkout("{{ route('checkout') }}","{{ route('checkout2') }}");
				discount("{{ route('discount') }}","{{ route('total_price') }}");
				
				signin("{{ route('signin') }}");
				//signup("{{ route('signup') }}");
				referAFriend("{{ route('refer_a_friend') }}");
				aboutBusiness("{{ route('aboutBusiness') }}")	;
			
			
				if(typeof(localStorage.coupon_code)!="undefined")
				{
					
					localStorage["coupon_code"] =" ";
					localStorage.setItem("coupon_code", " ");
				}
				
				deliverytime("{{ route('delivery_slot') }}");
				$('.day').change(function(){
						deliverytime("{{ route('delivery_slot') }}");
				}); 

				
				// Auto Adjust Height
				$(window).on('load', function() {
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
				
				// Nav Greedy First
				var $nav = $('.greedy-nav');
				var $btn = $('.greedy-nav button');
				var $vlinks = $('.greedy-nav .visible-links');
				var $hlinks = $('.greedy-nav .hidden-links');
				var breaks = [];
				function updateNav() {			  
				  var availableSpace = $btn.hasClass('hidden') ? $nav.width() : $nav.width() - $btn.width() - 30;
				  // The visible list is overflowing the nav
				  if($vlinks.width() > availableSpace) {
					// Record the width of the list
					breaks.push($vlinks.width());
					// Move item to the hidden list
					$vlinks.children().last().prependTo($hlinks);
					// Show the dropdown btn
					if($btn.hasClass('hidden')) {
					  $btn.removeClass('hidden');
					}
				  // The visible list is not overflowing
				  } else {
					// There is space for another item in the nav
					if(availableSpace > breaks[breaks.length-1]) {
					  // Move the item to the visible list
					  $hlinks.children().first().appendTo($vlinks);
					  breaks.pop();
					}
					// Hide the dropdown btn if hidden list is empty
					if(breaks.length < 1) {
					  $btn.addClass('hidden');
					  $hlinks.addClass('hidden');
					}
				  }
				  // Keep counter updated
				  $btn.attr("count", breaks.length);
				  // Recur if the visible list is still overflowing the nav
				  if($vlinks.width() > availableSpace) {
					setTimeout(updateNav,1); //updateNav();
				  }
				}

				// Window listeners
				$(window).resize(function() {
					setTimeout(updateNav,1); //updateNav();
				});
				$btn.on('click', function() {
				  $hlinks.toggleClass('hidden');
				});
				setTimeout(updateNav,1); //updateNav();
				
				
				// Nav Greedy Close When Other is Open
				$( "body" ).click(function(e) {
					if(!$(e.target).parent().hasClass("greedy-nav")){
						$(".greedy-nav .hidden-links").addClass("hidden");
					}
					if(!$(e.target).parent().hasClass("greedy-nav-second")){
						$(".greedy-nav-second .hidden-links").addClass("hidden");
					}
				});
				
				
		</script>

	@endsection


