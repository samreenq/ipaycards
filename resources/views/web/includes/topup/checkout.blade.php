

@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")
					<link href="<?php echo url('/').'/public/web/css/select2.css';?>" rel="stylesheet"/>
				
				<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
				<link href="<?php echo url('/').'/public/web/css/ayoshare.css';?>" rel="stylesheet">
				<script src="http://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>
			
	@endsection


	@section("navbar")
		@parent
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@parent
		
		@include("web/includes/cartbar")
	@endsection
		
		
	
	@section("checkout3")

		<section class="checkout-step-3 lightgreybg">
		<div class="container">
			<div class="checkout-header">
				<ul class="checkout-steps">
					<li class="active"><a href="javascript:void(0)"><span>1</span> Information</a></li>
					<li class="active"><a href="javascript:void(0)"><span>2</span> Verification</a></li>
					<li class="active"><a href="javascript:void(0)"><span>3</span> Payment</a></li>
					<li class="active"><a href="javascript:void(0)"><span>4</span> Checkout</a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="order-Confirm whitebg">

						<div class="error-message"></div>

						<div class="order-pending">
							<h2>Wait...</h2>
							<p>Please Wait While order is processing for Transaction Order ID : <span id="lead_order_id"></span></p>
						</div>
						<div class="order-done hide">
							<h2>Congratulations!</h2>
							<h4>Order <span id="final_order_id"></span> is confirmed</h4>
							<p>Your payment has been processed successfully and your booking is confirmed.</p>

							<br /><br />
							<!--
									<div class="orderConfirnmSm">
										<p>Share to</p>
										<ul>
											<li><a href="#" class="twitter"><span class="icon-tt-twitter-icon"></span></a></li>
											<li><a href="#" class="facebook"><span class="icon-tt-facebook-icon"></span></a></li>
										</ul>
									</div>
							-->

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

	@section("socialmedia")
		@include("web/includes/models/socialmedia")
	@endsection

	@section("foot")
		@include("web/includes/foot")
		
		
		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js';?>"></script>
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
				
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				show_cart("{{ route('show_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				process_order("{{ route('saveorder') }}");
				
				
				
				signin("{{ route('signin') }}");
				//signup("{{ route('signup') }}");
				referAFriend("{{ route('refer_a_friend') }}");
				aboutBusiness("{{ route('aboutBusiness') }}")	;

				$(document).ready(function(){


                        var entity_id = localStorage.lead_topup_id;
                      //  var payment_method = localStorage.charge_type;

                           if(entity_id  != undefined) {

                               $('#lead_order_id').text(entity_id);

                               $.ajax({
                                   url: "{{ route('topup_order') }}",
                                   type: 'post',
                                   data: {_token: "{!! csrf_token() !!}", lead_topup_id: entity_id},
                                   dataType: 'json',
                                   success: function (data) {
                                       if (data.error == 0) {
                                           $('.order-pending').addClass('hide');
                                           $('.order-done').removeClass('hide');
                                           $('#final_order_id').text(data.data.order_id);
                                           localStorage.removeItem('lead_topup_id');
                                           //window.location = site_url+'/checkout3/'+data.data.order_id;
                                       } else {
                                           // $('.add-to-cart').removeAttr('disabled');
                                           $('.error-message').html('');
                                           $('.error-message').append('<div class="alert alert-danger">' + data.message + '</div>');
                                           return false;
                                       }
                                   }

                               });
                           }
                           else{
                               window.location.href = "{!! url('/') !!}";
						   }


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
					
					// Sticky sidebar Checkout
					$('#sidebarCheckout').stickySidebar({
						topSpacing: 20,
						containerSelector: '.recipeFixed',
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


