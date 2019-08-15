@extends("web.templates.template2")

@section("head")
    @include("web/includes/head")

    <link href="<?php echo url('/') . '/public/web/css/component.css';?>" rel="stylesheet"/>

@endsection


@section("navbar")
    @include("web/includes/navbar")
@endsection

@section("cartbar")
    @include("web/includes/cartbar")
@endsection
@section('header')
    <header id="header">
        <div class="flyout-overlay for_banneroverlay"></div>
        <div class="fly-nav-inner">
            <div class="container">
                <button class="dropdown-toggle" data-toggle="dropdown">More <span
                            class="glyphicon glyphicon-chevron-down pull-right"></span></button>
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
                                     id="LoadingImage1" align="center" style="display: none">
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

        <div class="container pageNavWrap">
            <div class="greedy-overflow"></div>
            <div class="greedy-nav page-nav" id="animationHover">
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
				</div>
				<div class="main-banner">
					<div class="container">
						<div class="row">
							<div class="bannerContWrap clearfix">
								<div class="col-12">
									<h1 style="font-weight: bold !important; font-size: 40px;">Check out all the available Brand Cards we have got for you.</h1>
									<form class="form-horizontal" role="form" method="GET" action="{{ url('/product') }}">
											<div class="toolbar-search" >
												<input class="search-bar" required="required" class="form-control" name="title" placeholder="I’m looking for…" type="text" value="">
												<button class="search-btn"  type="submit"><span class="icon-tt-right-arrow"></span></button>

											</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="three-sm-banner-wrap">
					<div class="container">
						<div class="row" id="promotionAndDiscountUrl">

						</div>
					</div>
				</div>
				<ul class="headerSlider">
					<li style="background:url('<?php echo url('/').'/public/web/img/header-bg.jpg'?>')"></li>
					<!-- <li style="background:url(img/header-bg2.jpg);"></li>
					<li style="background:url(img/header-bg02.jpg);"></li>
					<li style="background:url(img/header-bg2.jpg);"></li> -->
				</ul>

        <div id="scrollHeader" class="ha-header ha-header-hide">
            <div class="page-nav-second">
                <div class="d-flex container align-items-center">
                    <a class="navbar-brand logo" href="#">
                        <h4 style="font-family: 'Roboto', sans-serif;font-weight: 400;line-height: 1.5;color: #212529;margin-right:10px;">{!! APP_NAME !!}</h4>
                       <!-- <img src="<?php // echo url('/') . '/public/web/img/logo.png';?>" width="172"/> -->
                    </a>
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
                            <li>Deals</li>
                        </ul>
                        <ul class='hidden-links hidden'></ul>
                    </div>
                    <div class="headerRight">
                        <a href="#" id="cartList"><span class="icon-tt-cart-Icon"></span>{{--<span
                                    class="orderNotification"></span>--}}</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection




@section("footer")
    @include("web/includes/footer")
@endsection


@section("brands")
    <section class="browse_brand_sec">
        <div class="np-seasons">
            <div class="container">
                <div class="row align-items-baseline no-gutters mb30 stitle-wrap">
                    <h2 class="mr-auto align-items-start">Browse By Brands</h2>
                    <a href="<?php echo url('/') . '/brand'; ?>"
                       class="align-items-end viewMore">See More</a>
                </div>
                <div class="row brandList">
                    <div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
                         id="LoadingbrandListImage" align="center" style="display: none">
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


@section("top_category")
    <section class="greybg topCategories">
    </section>
@endsection

@section("essentials")
    <section class="essentials ha-waypoint" data-animate-down="ha-header-show" data-animate-up="ha-header-hide">
        <div class="container">
            <div class="row align-items-baseline no-gutters mb30 stitle-wrap">
                <h2 class="mr-auto align-items-start">Our Featured Items</h2>
                <a href="<?php echo url('/') . '/product?entity_type_id=14&featured_type=2'; ?>"
                   class="align-items-end viewMore">See More</a>
            </div>
            <div class="row todayTodayEssentials" id="todayTodayEssentials">
                <div class="load_spinner" id="LoadingtodayTodayEssentialsImage" align="center">
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
    </section>
@endsection

@section("guest_chef_deal")
    @include("web/includes/main/guest_chef_deal")
@endsection

@section("popular_categories")

   <!-- <section class="lightgreybg popCate">
        <div class="container">
            <div class="row align-items-baseline no-gutters mb30 stitle-wrap">
                <h2 class="mr-auto align-items-start">Popular Categories</h2>
            </div>
            <div class="row popularCategories">
                <div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
                     id="LoadingPopularCategoriesImage" align="center" style="display: none">
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
    </section>-->

@endsection


@section("testimonial")
    <section class="greybg popCate">
        <div class="container">
            <div class="row align-items-baseline no-gutters mb30 stitle-wrap">
                <h2 class="mr-auto align-items-start">Browse By Categories</h2>
            </div>
            <div class="row" id="mainCategory">
                <div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
                     id="LoadingPopularCategoriesImage" align="center" style="display: none">
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



    <script src="<?php echo url('/') . '/public/web/js/enscroll.min.js';?>"></script>
    <script src="<?php echo url('/') . '/public/web/js/waypoints.min.js';?>"></script>
    <script src="<?php echo url('/') . '/public/web/js/custom/product.js'?>"></script>

    <script>
        menus("{{ route('menus') }}",<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';  ?>) ;

        load_cart("{{ route('add_to_cart') }}", "{{ route('total_price') }}");
        total("{{ route('total_price') }}");
        add_to_Cart("{{ route('total_price') }}", "{{ route('add_to_cart') }}");
        load_wishlist("{{route('add_to_wishlist')}}");
		popularCategories("{{ route('popularCategories') }}");

        brandProducts("{{ route('getBrands') }}", "{{ route('product_detail') }}");
        todayTodayEssentials(14, 2, "{{ route('essentials') }}", "{{ route('product_detail') }}", "{{ route('add_to_wishlist') }}", "{{ route('add_to_cart') }}", "{{ route('total_price') }}");
        signin("{{ route('signin') }}");
       // signup("{{ route('signup') }}", "{{ route('phoneVerification') }}");
      //  resendCode("{{ route('resendCode') }}");
        sendCode("{{ route('sendCode') }}", "{{ route('socialPhoneVerfication') }}");
        aboutBusiness("{{ route('aboutBusiness') }}");
        testimonial("{{ route('testimonial') }}");
        promotionAndDiscount("{{ route('promotionAndDiscount') }}");
        mainCategory("{{ route('main_category') }}");

        aboutBusiness("{{ route('aboutBusiness') }}");

        topCategoryProducts(14, 2, "{{ route('top_category_products') }}", "{{ route('product_detail') }}", "{{ route('add_to_wishlist') }}", "{{ route('add_to_cart') }}", "{{ route('total_price') }}");

        // Auto Adjust Height
        $(window).on('load', function () {
            function resize(selector, footer) {
                var totalheight = $(window).height();
                if (footer) {
                    var lessheight = $('.cart-tabs .cartTabHeader').height() + $('.tab-content .cartTabFooter').height();
                    var docheight = totalheight - lessheight;
                } else {
                    var lessheight = parseInt($('.cart-tabs .cartTabHeader').height());
                    var docheight = totalheight - lessheight - parseInt(25);
                }

                $('.tab-content ' + selector).css("height", docheight);
                $('.tab-content ' + selector).css("min-height", '569px'); // i have given minimum height
            }

            $(document).ready(function () {
                resize('.basketList', true); //basketList
                resize('.wishList', false); //wishList
            });

            $(window).resize(function () {
                resize('.basketList', true); //basketList
                resize('.wishList', false); //wishList
            });

        });

        // Modal Script
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });






        //$('.addtocart').click(function(){
        //	var count=$('#pro-inc-wrap').val();
        //	$(this).animate({width:'110px'},'slow');
        //$(this).animate({opacity:'0'},'0');
        //$('#total-count').text(count);

        /*$(this).fadeOut('fast');*/

        //$('.total-visible').animate({opacity:'1'},'fast');
        //});


        //----------------------------------------
        var $head = $('#scrollHeader');
        $('.ha-waypoint').each(function (i) {
            var $el = $(this),
                animClassDown = $el.data('animateDown'),
                animClassUp = $el.data('animateUp');

            $el.waypoint(function (direction) {
                if (direction === 'down' && animClassDown) {
                    $head.attr('class', 'ha-header ' + animClassDown);
                }
                else if (direction === 'up' && animClassUp) {
                    $head.attr('class', 'ha-header ' + animClassUp);
                }
            }, {offset: '100%'});
        });

        // All Small Script
        $(document).ready(function () {

            // Field Style
            $(".fluid-label").focusout(function () {
                $(".focused").removeClass("focused");
            });
            $('.fluid-label').fluidLabel({
                focusClass: 'focused'
            });

            //Navigation Menu Slider
            $('#cartList, #cartList2').on('click', function (e) {
                e.preventDefault();
                $('body').toggleClass('nav-expanded');
            });
            $('.overlay').on('click', function (e) {
                e.preventDefault();
                $('body').toggleClass('nav-expanded');
            });
            $('#nav-close').on('click', function (e) {
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

            //Three Small Banner Slider on Screen 991
            /* $('.smBannerSlider').bxSlider({
                controls: false,
                auto: true,
                minSlides: 1,
                maxSlides: 3,
                slideWidth: 360,
                slideMargin: 10,
                captions: true
            }); */

            // Wizard Form
            // Wizard Form



        });

        //Inc Dec Button----------------
        $(".incr-btn").on("click", function (e) {


            var $button = $(this);
            var oldValue = $button.parent().find('.quantity').val();
            $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
            var oldValue = parseFloat(oldValue) + 1;
            if ($button.data('action') == "increase") {
                var newVal = parseFloat(oldValue) + 1;
            }
            if ($button.data('action') == "decrease") {
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


        //$('#cartList').on('click', function () {
        //	$("body").toggleClass('stop_scroll');
        //});


        // Responsive Menu

        // Active Name Menu
        var current_url = window.location.href;
        current_url = current_url.split('#');
        if (current_url.length > 1) {
            var collection = current_url[1];
            collection = collection.replace('_', ' ');
            $('.dropdownActivePage').html(collection);
        }

        // Lazy load
        // $(function() {
        //   $('img').Lazy();
        //});


        $(document).ready(function () {
            $(window).load(function () {
                setTimeout(function () {
                    retinaImage();
                }, 500);
                $('.cartTabHeader .nav-tabs li').click(function () {
                    retinaImage();
                });
            });
        });

        function retinaImage() {
            $('img').each(function () {
                var image_width = $(this).width();
                var image_height = $(this).height();
                if (image_width == 0 && image_height == 0) {
                    $(this).attr('width', '63');
                    $(this).attr('height', '60');
                }
            });
        }


    </script>



@endsection

