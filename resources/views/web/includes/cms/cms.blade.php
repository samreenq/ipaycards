


@extends("web.templates.template2")

@section("head")
    @parent

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

@section("faq")

<section class="termandcond-Section lightgreybg">
    <div class="flyout-overlay"></div>
{{--    <div class="fly-nav-inner">
        <div class="container">
            <button class="dropdown-toggle" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
            <div class="dropdown-menu mega-dropdown-menu">
                <ul class="row">
                    <li class="col-sm-12">
                        <ul class="nav sidebar__inner" role="tablist">
                            <li class="li-active" role="presentation"><a href="#termsofuse" class="active" data-toggle="tab">Terms of Use</a></li>
                            <li class="li-active" role="presentation"><a href="#privacypolicy" data-toggle="tab">Privacy Policy</a></li>
                            <li class="li-active" role="presentation"><a href="#copyrightpolicy" data-toggle="tab">Copyright Policy</a></li>
                            <li class="li-active" role="presentation"><a href="#giftcards" data-toggle="tab">Gift Cards</a></li>
                            <li class="li-active" role="presentation"><a href="#promotions" data-toggle="tab">Promotions</a></li>
                            <li class="li-active" role="presentation"><a href="#alcohol" data-toggle="tab">Alcohol</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>--}}

    <?php
    $cms_flat = new \App\Http\Models\SYSTableFlat('cms');
    $where_condition = 'status = 1';
    $cms_raw = $cms_flat->getDataByWhere($where_condition);
    ?>

    <div class="container">
        <div class="row">
            <div class="termandcond-left-bar col-md-12 col-lg-3 col-xl-2">
                <div id="sidebar">
                    <ul class="nav sidebar__inner" role="tablist">
                        <?php if($cms_raw){
                        foreach($cms_raw as $record){

                        $class_active = '';
                            if(isset($page_slug) && $record->slug == $page_slug){
                                $class_active = 'active';
                            }
                        ?>
                        <li role="presentation"><a class="{!! $class_active !!}" href="{!! url('/').'/cms/'.$record->slug !!}">{!! $record->title !!}</a></li>
                        <?php }
                        } ?>
                    {{--    <li role="presentation"><a href="#termsofuse" class="active" data-toggle="tab">Terms of Use</a></li>
                        <li role="presentation"><a href="#privacypolicy" data-toggle="tab">Privacy Policy</a></li>
                        <li role="presentation"><a href="#copyrightpolicy" data-toggle="tab">Copyright Policy</a></li>
                        <li role="presentation"><a href="#giftcards" data-toggle="tab">Gift Cards</a></li>
                        <li role="presentation"><a href="#promotions" data-toggle="tab">Promotions</a></li>
                        <li role="presentation"><a href="#alcohol" data-toggle="tab">Alcohol</a></li>--}}
                    </ul>
                </div>
            </div>



            <div class="termandcond-right-bar col-md-12 col-lg-9 col-xl-10">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="termsofuse">

                        <?php if(isset($cms) && isset( $cms[0])){ $page = $cms[0]; ?>

                        <div class="termandcond-right-side">
                            <div class="termandcond-right-header">
                                <h4>{!! $page->title !!}</h4>
                            </div>
                            <div class="termandcond-right-txt-bg">
                                <p>{!! $page->desc !!}</p>
                            </div>
                        </div>

                        <?php } else{ ?>
                            <div class="termandcond-right-side">
                                <div class="termandcond-right-header">
                                    <h4>No Page Found</h4>
                                </div>
                                <div class="termandcond-right-txt-bg">
                                    <p>No Page Found</p>
                                </div>
                            </div>

                           <?php } ?>
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

        load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
        total("{{ route('total_price') }}");
        add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");

        product_categories("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}");

        load_wishlist("{{ route('add_to_wishlist') }}");

        signin("{{ route('signin') }}");
        //signup("{{ route('signup') }}");

        frequentAskedQuestions("{{ route('frequentAskedQuestions') }}");
        referAFriend("{{ route('refer_a_friend') }}");



        aboutBusiness("{{ route('aboutBusiness') }}")	;
        testimonial("{{ route('testimonial') }}")	;
        referAFriend("{{ route('refer_a_friend') }}");
        aboutBusiness("{{ route('aboutBusiness') }}")	;





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





    </script>

@endsection

