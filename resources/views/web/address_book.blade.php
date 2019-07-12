

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
	
	@section("order_history")
		
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
									<!--<li class="li-active "><a href="{{ route('payment') }}">Payment</a></li>-->
									<li class="li-active active"><a href="{{ route('order_history') }}">Order History</a></li>
									<li class="li-active"><a href="{{ route('address_book') }}">Address Book</a></li>
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
								<li><a href="{{ route('account_detail') }}">Your Account</a></li>
								<!--<li><a href="{{ route('payment') }}">Payment</a></li>-->
								<li ><a href="{{ route('order_history') }}">Order History</a></li>
								<li class="active"><a href="{{ route('address_book') }}">Address Book</a></li>
								<li><a href="{{ route('customer_wallet') }}">Wallet</a></li>
								<li><a href="{{ route('logout') }}">Logout</a></li>
							</ul>
						</aside>
					</div>
					<div class="col-md-12 col-lg-9 col-xl-10">
						<div class="d-sm-flex align-items-center dashboard-header">
							<h4 class="mr-auto align-items-start">Address Book</h4>
						</div>
						<div class="ashboard-content panelled whitebg clearfix">
							<div class="orderAddress col-md-10 m-md-auto ">
								<div class="error-message"></div>
								<div class="addressScroll">
								<?php 
										$c=1;
									
										if(!empty($address))
										{
											foreach($address as $attributes)
											{
												if(isset($attributes['street'])) 
												{
								?>
													<div class="radio">
														<input type="radio" name="radio" id="radio<?php echo $c; ?>" value="option1" checked="">
														<label for="radio<?php echo $c; ?>">
															<?php echo $attributes['street']; ?>
														</label>
													</div>
								<?php 
													$c++;
												}
											}
										}
								?>
								</div>
								
								<form action="" method="post" id="formSaveAddress" name="formSaveAddress">
									
									<!--
									<div class="fluid-label">
										<textarea name="street" placeholder="Street Address*"></textarea>
										<label>Street Address*</label>
									</div>
									-->
									
								
									<div class="">
										<div class="map_canvas" style="width: 100%; height: 400px; margin: 10px 20px 10px 0; " ></div>
										<input class="map_textbox" id="geocomplete" type="text" placeholder="Type in an address" value="Nigeria" />
										<input class="map_search" id="find" type="button" value="Find" />
										<input id="latitude" name="latitude" type="hidden" >
										<input id="longitude" name="longitude" type="hidden" >
										<input type="hidden" name="_token" value="{!! csrf_token() !!}" />
										<input class="map_reset" id="reset" type="button" style="display:none;" value="Reset Marker" />
										 
										<div class="map_text" style="margin-top:-54%">Drag the map to your exact location</div>
									</div>
									
										<div class="fluid-label">
										  <textarea required="required"  name="formatted_address" placeholder="Street Address* 19,Ilupeju street isheri oshun,Lagos"></textarea>
										     <label>Street Address*</label>
										</div>
									<input type="button" id="save_address_book" name="" value="Save" class="btn-xs btn-theme ml-auto d-sm-flex align-items-end"/>
								
							</form>
										
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
		<script src="http://maps.googleapis.com/maps/api/js?key={!! $google_api_key !!}&amp;libraries=places"></script>
		<script src="<?php echo url('/').'/public/web/js/jquery.geocomplete.js'; ?>"></script>
    

		

		<script>
				
			<?php 
				if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
				{
			?>
					load_wishlist("{{ route('add_to_wishlist') }}");
				
			<?php 
				}
			?>
		
			var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '';?>";
			menus("{{ route('menus') }}",category_id) ;
		
			load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
			total("{{ route('total_price') }}");			
			add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
			
						
			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
			referAFriend("{{ route('refer_a_friend') }}");
			aboutBusiness("{{ route('aboutBusiness') }}")	;
			
		
			$(function(){
        $("#geocomplete").geocomplete({
          map: ".map_canvas",
          details: "form ",
          markerOptions: {
            draggable: true
          }
        });
        
        $("#geocomplete").bind("geocode:dragged", function(event, latLng){
          $("input[name=latitude]").val(latLng.lat());
          $("input[name=longitude]").val(latLng.lng());
          $("#reset").show();
        });
		
		$("#geocomplete").bind("geocode:result", function(event, result){
		  $("input[name=latitude]").val(result.geometry.location.lat());
          $("input[name=longitude]").val(result.geometry.location.lng());
        });
		
   
        
        $("#reset").click(function(){
          $("#geocomplete").geocomplete("resetMarker");
          $("#reset").hide();
          return false;
        });
        
        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        }).click();
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



				$('#save_address_book').on('click',function(){

				    console.log($('#formSaveAddress').serialize()); //return false;
                    $.ajax ({
                        url: site_url+'/address/save',
                        type: 'post',
                        data: $('#formSaveAddress').serialize(),
                        dataType: 'json',
                        success: function(data)
                        {
                           if(data.error == 0){
                                window.location = site_url+'/address_book';
                            }
                            else{
                                $(".error-message").addClass('alert alert-danger');
                                $(".error-message").html(data['message']);
                            }
                        }

                    });

				});
			
		</script>
	@endsection

