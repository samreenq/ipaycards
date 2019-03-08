

@extends("web.templates.template3")

	@section("head")
		
	    @include("web/includes/head")
		 
					<link href="<?php echo url('/').'/public/web/css/select2.css'; ?>" rel="stylesheet">
					
				
	@endsection


	@section("navbar")
		@parent
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@parent
		
		@include("web/includes/cartbar")
	@endsection

	@section('header')
		@include("web/includes/header")
	@endsection	
	
	@section("payment")
		<section class="dashboard-Section lightgreybg">
			<div class="flyout-overlay"></div>
			<div class="fly-nav-inner">
				<div class="container">
					<button class="dropdown-toggle dropdownActivePage" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
					<div class="dropdown-menu mega-dropdown-menu">
						<ul class="row">
							<li class="col-sm-12">
								<ul class="sidebar__inner">
									<li class="li-active"><a href="{{ route('account_detail') }}">Your Account</a></li>
									<li class="li-active active"><a href="{{ route('payment') }}">Payment</a></li>
									<li class="li-active"><a href="{{ route('order_history') }}">Order History</a></li>
									{{--<li class="li-active"><a href="{{ route('address_book') }}">Address Book</a></li>--}}
									<li class="li-active"><a href="{{ route('customer_wallet') }}">Wallet</a></li>
									<li class="li-active"><a href="{{ route('logout') }}">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="dashboardLeftBar col-md-12 col-lg-3 col-xl-2">
						<aside>
							<ul class="sidebar__inner">
								<li class="li-active"><a href="{{ route('account_detail') }}">Your Account</a></li>
								<li class="li-active active"><a href="{{ route('payment') }}">Payment</a></li>
								<li class="li-active"><a href="{{ route('order_history') }}">Order History</a></li>
								{{--<li class="li-active"><a href="{{ route('address_book') }}">Address Book</a></li>--}}
								<li class="li-active"><a href="{{ route('customer_wallet') }}">Wallet</a></li>
								<?php
							
										if (isset($_SESSION['fbUserProfile']) )
										{
								?>
											
											<li ><a href="<?php echo $_SESSION['logoutURL']; ?>">Logout</a></li>
								
								<?php
										}

										if (Session::has('users')  )
										{
									
								?>
											
											<li ><a href="{{ route('signout') }}">Logout</a></li>
								
								<?php 
										}
										

								?>
						
							</ul>
						</aside>
					</div>
					<div class="col-md-12 col-lg-9 col-xl-10">
						<div class="d-sm-flex align-items-center dashboard-header">
							<h4 class="mr-auto align-items-start">Payment</h4>
						</div>
						<div class="paymentEditContent panelled whitebg">
							<div class="payment-method">
									<div id="error_msg_change_payment_method" class="help-block text-left animated fadeInDown hide" style=""></div>
		
								<div class="big-radio CashDeliveryWrap noselect">
									<img src="<?php echo url('/').'/public/web/img/volet-logo.svg'?>" alt="bitcoin-logo" width="35"/>
									<input type="radio" class="payment_method_type" name="payment_method_type" id="cash-on-delivery" value="cod" <?php if(isset($customer[0]['payment_method_type']['value'])) if($customer[0]['payment_method_type']['value']=="cod") echo "checked"; ?> >
									<label for="cash-on-delivery">
										Cash On Delivery
									</label>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
								
								</div>
								<div class="big-radio CreditCardWrap">
									<img src="<?php echo url('/').'/public/web/img/all-card-icon.svg'?>" alt="bitcoin-logo" width="156"/>
									<input type="radio" class="payment_method_type" name="payment_method_type" id="credit-card" value="webpay" <?php if(isset($customer[0]['payment_method_type']['value'])) if($customer[0]['payment_method_type']['value']=="webpay") echo "checked"; ?> />
									<label for="credit-card">Stripe Integration</label>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
										
								</div>
								
								<!--<div class="big-radio cryptoCurrencyWrap noselect">
									<img src="<?php // echo url('/').'/public/web/img/bitcoin-logo.svg'?>" alt="bitcoin-logo" width="78"/>
									<input type="radio" class="payment_method_type" name="payment_method_type" id="crypto-currency" value="bitcoin" <?php // if(isset($customer[0]['payment_method_type']['value'])) if($customer[0]['payment_method_type']['value']=="bitcoin") echo "checked"; ?> >
									<label for="crypto-currency">
										Crypto Currency
									</label>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
								</div>-->
							</div>
							{{--<br /><br />--}}
							<div class="addCardWrap addCardLabel-pl-0">
									
								<div class="col-md-12 d-sm-flex">
									<p class="mr-auto align-items-start">We use SSL encryption to protect your information</p>
									<!--
									<input type="submit" name="" value="Save" style="background-color: #4fbe9e; color: #fff; border: none; padding: 10px 33px; text-transform: uppercase;"/>
									-->
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
		
		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js';?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
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
		
		
		
			$("input[name='payment_method_type']").click(function(){
					savePaymentMehtodType("{{ route('change_your_account_payment_method') }}",$(this).val()); 
			});


			var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
			menus("{{ route('menus') }}",category_id) ;

			load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
			total("{{ route('total_price') }}");			
			add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
			
						
			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
				
			aboutBusiness("{{ route('aboutBusiness') }}")	;
			referAFriend("{{ route('refer_a_friend') }}");
			
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
					resize('.basketList',true); //basketList
					resize('.wishList',false); //wishList
				});
				
				$(window).resize(function() {
					resize('.basketList',true); //basketList
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
				updateNav();
			  }
			}

			// Window listeners
			$(window).resize(function() {
				updateNav();
			});
			$btn.on('click', function() {
			  $hlinks.toggleClass('hidden');
			});
			updateNav();
			
			
			// Nav Greedy Close When Other is Open
			$( "body" ).click(function(e) {
				if(!$(e.target).parent().hasClass("greedy-nav")){
					$(".greedy-nav .hidden-links").addClass("hidden");
				}
				if(!$(e.target).parent().hasClass("greedy-nav-second")){
					$(".greedy-nav-second .hidden-links").addClass("hidden");
				}
			});
			
			// Responsive Menu
			$(document).click(function(){
				if($(document).find('.flyout-wrap').length > 0){
					var section = $('.dropdown-toggle').parent().parent().parent();
					$(section).removeClass('flyout-wrap');
				}
			});

			$('.dropdown-toggle').on('click', function () {
				if($(document).find('.flyout-wrap').length > 0){
					var section = $(this).parent().parent().parent();
					$(section).removeClass('flyout-wrap');
				}else{
					var section = $(this).parent().parent().parent();
					$(section).addClass('flyout-wrap');
				}
			});

			$('.li-active').on('click', function () {
				$('.dropdown-toggle').html($(this).html() + '<span class="glyphicon glyphicon-chevron-down pull-right"></span>');
				$('section').removeClass('flyout-wrap');
			});
			
			// Active Name Menu
			var current_url = window.location.href;
				current_url = current_url.split('#');
				if(current_url.length > 1){
					var collection = current_url[1];
					collection = collection.replace('_',' ');
					$('.dropdownActivePage').html(collection);
				} 
			
		</script>
	@endsection

