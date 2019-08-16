

@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")

					<link href="<?php echo url('/').'/public/web/css/component.css';?>" rel="stylesheet"/>
			
	@endsection


	@section("navbar")
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@include("web/includes/cartbar")
	@endsection

	@section('header')
			<!-- Header -->	
			
			

			<header id="header">
				<div class="flyout-overlay"></div>
				<div class="fly-nav-inner">
					<div class="container">
						<button class="dropdown-toggle" data-toggle="dropdown">More <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
						<div class="dropdown-menu mega-dropdown-menu">
							<ul class="row">
								<li class="col-sm-12">
									<ul class=" menus sidebar__inner" role="tablist">
										<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingImage" align="center" style="display: none">
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
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>

				@include("web/includes/secondry_header")
				
				<ul class="headerSlider">
					<li style="background:url('<?php echo url('/').'/public/web/img/header-bg02.jpg\''?>)"></li>
					<!-- <li style="background:url(img/header-bg2.jpg);"></li>
					<li style="background:url(img/header-bg02.jpg);"></li>
					<li style="background:url(img/header-bg2.jpg);"></li> -->
				</ul>

				<div id="scrollHeader" class="ha-header ha-header-hide">
					<div class="page-nav-second">
						<div class="d-flex container">	
							<a class="navbar-brand logo" href="javascript:void(0)">
								<h4 style="font-family: 'Roboto', sans-serif;font-weight: 400;line-height: 1.5;color: #212529;margin-right:10px;">CubixCommerce</h4>
								<!-- <img src="<?php // echo url('/').'/public/web/img/logo.png';?>" width="172"/></a> -->
							<div class="greedy-nav-second">
								<button type="button" class="pull-right">More</button> 
								<ul class=" menus visible-links">
									<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingImage" align="center" style="display: none">
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
								</ul>
								<ul class='hidden-links hidden'></ul>
							</div>
							<div class="headerRight">
								<a href="javascript:void(0)" id="cartList"><span class="icon-tt-cart-Icon"></span><span class="orderNotification">1</span></a></li>
							</div>
						</div>
					</div>
				</div>
			</header>
			
	@endsection
		

		
	@section("recipe")
		<?php
        //Get image of product
        $gallery = isset($product['gallery'][0]) ? json_decode(json_encode($chef['gallery'])) : false;
        $chef_image = \App\Libraries\Fields::getGalleryImage($gallery,'chef','thumb');

		?>
		
			<div class="feature-bg" style="background:url(<?php echo url('/').'/public/web/img/product/recipe-feature-img-1.jpg'?>);"></div>
			<section class="chef-Section ">
				<div class="container">
					<div class="detailHeader">
						<div class="row">
							<div class="col-md-12 col-lg-6 pr-lg-0">
								<img src="{!!  $chef_image !!}" alt="img" class="recipeBigImg img-responsive"/>
							</div>
							<div class="col-md-12 col-lg-6 pl-lg-0">
								<div class="chefInfo whitebg">
									<div class="col-md-10 m-sm-auto">
										<h4 class="chefTitle"><?php if(isset($chef['name'])) echo $chef['name'] ?> (<?php   echo $chef['recipe_count'] ?>) <span><?php if(isset($chef['certified  '])) echo $chef['certified'] ?><?php if(isset($chef['chef_restaurant'])) echo $chef['chef_restaurant'] ?></span></h4>
										<ul class="flowerRating">
										
											@if(isset($chef['star_rating']['value']))
											
													@for ($i = 0; $i < $chef['star_rating']['value']; $i++)
														<li><span class="icon-tt-flower-icon"></span></li>
													@endfor
											
											@endif
											
										
										</ul>
										<h4>About</h4>
										<p>@if(isset($chef['about_me'])) {{ $chef['about_me']}} @endif </p>
										<div class="d-sm-flex align-items-end">
											<div class="mr-auto align-items-start">
												<h4>Chef's Area of Expertise</h4>
												<ul class="foodExperties">
													<pre>@if(isset($chef['expertise_area'])) {{ $chef['expertise_area']}} @endif </pre>
												</ul>
											</div>
											<div class="align-items-end">
												<ul class="chefSocial">
													<li><a href="@if(isset($chef['facebook_url'])){{$chef['facebook_url']}}@endif" class="facebook"><span class="icon-tt-facebook-icon"></span></a></li>
													<li><a href="@if(isset($chef['twitter_url'])){{$chef['twitter_url']}}@endif" class="twitter"><span class="icon-tt-twitter-icon"></span></a></li>
													<li><a href="@if(isset($chef['instagram_url'])){{$chef['instagram_url']}}@endif" class="instagram"><span class="icon-tt-instagram-icon"></span></a></li>
													<li><a href="@if(isset($chef['youtube_url'])){{$chef['youtube_url']}}@endif" class="youtube"><span class="icon-tt-youtube-icon"></span></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="allChefRecipe">
						
								<div id="recipes"  class="row">
										
											<div 	style="
																position: absolute;
																top: 50%;
																left: 50%;
																margin-top: -50px;
																margin-left: -50px;
																width: 100px;
																height: 100px;
											
														"

													id="LoadingImageRecipes" align="center" style="display: none"
											>
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
								<div class="container page_showcase" style="display:none">
									<nav aria-label="Page navigation" class="clearfix">
										<ul class="pagination cusPagination float-right" id="pagination"></ul>
									</nav>
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
	
	@section("foot")
		@include("web/includes/foot")
		
		

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/jquery.simplePagination.js';?>" type="text/javascript"></script>
		
		
		<script>
			
								
			$('#pagination').pagination(
			{
				items: 5,
				itemOnPage: 9,
				currentPage: 1,
				cssStyle: '',
				prevText: '<span aria-hidden="true">&laquo;</span>',
				nextText: '<span aria-hidden="true">&raquo;</span>',
				onInit: function () 
				{
					
					// fire first page loading
					limit = 9;
					page = 1; 
					offset = (page  * limit) -  limit; 
					
					
					recipe_all_list(22,2,"<?php if(isset($chef['name'])) echo  $chef['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",'','','','','',offset,limit);

	
				},
				onPageClick: function (page, evt) 
				{
					// some code
					limit = 9;
					offset = (page  * limit) -  limit; 
					recipe_all_list(22,2,"<?php if(isset($chef['name'])) echo  $chef['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",'','','','','',offset,limit);

				}
			});
	
	



				<?php 
						if( isset($_REQUEST['title']) ) 
						{
				?> 
							product_list_by_title(14,"<?php echo $_REQUEST['title'] ?>", "{{ route('product_title') }}","{{ route('product_detail') }}");
				<?php							
						}
				?>
            var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
            menus("{{ route('menus') }}",category_id) ;
		
			load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
			total("{{ route('total_price') }}");			
			add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
			

			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
			referAFriend("{{ route('refer_a_friend') }}");
			aboutBusiness("{{ route('aboutBusiness') }}")	;
			
			add_to_wishlist("{{ route('add_to_wishlist') }}");
				
			
			
			load_wishlist("{{ route('add_to_wishlist') }}");
			
				
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
			
			
		</script>


	@endsection

