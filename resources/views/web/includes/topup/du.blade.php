@extends("web.templates.template2")

@section("head")
    @parent

    @include("web/includes/head")

    <link href="<?php echo url('/').'/public/web/css/select2.css'; ?>" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/css/intlTelInput.css'>

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
    @include("web/includes/topup_head")
@endsection

@section("faq")

    <section class="dashboard-Section lightgreybg">
        <div class="flyout-overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-12 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
                    <div class="dashboard-content etisalat_dashboard panelled whitebg">
                        <form role="form" method="post" id="topup-form" class="signup-form etisalat_form">
                            <input type="hidden" name="service_type" id="service_type" value="du" />
                            <input type="hidden" name="dial_code" id="dial_code" value="" />
                            <input type="hidden" name="number" id="number" value="" />
                            <input type="hidden" name="amount" id="amount" value="" />
                            <input type="hidden" name="recharge_type" id="recharge_type" value="" />
                            <input type="hidden" name="wallet" id="wallet" value="0" />
                            <input type="hidden" name="paid_amount" id="paid_amount" value="0" />
                            <h3>
                                <span class="title_text">Information</span>
                            </h3>
                            <fieldset class="add_content_padding">
                                <h2 class="mt-4">Enter Your Personal details</h2>
                                <div class="fieldset-content">
                                    <div class="alert alert1 alert-danger" style="display: none;"></div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-4">
                                            <label for="mobileNumber" class="form-label m-0"><b>Enter mobile number:</b></label>
                                        </div>
                                        <div class="input-group col-sm-8">
                                            <input type="tel" name="mobileNumber" class="form-control w-100" id="mobileNumber" placeholder="(###) ###-####" />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-4">
                                            <label for="amount" class="form-label m-0"><b>Enter amount (AED):</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" name="customerAmount" class="form-control" id="customerAmount" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                         <label for="amount" class="form-label mb-3"><b>More options:</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" id="customRadio1" name="chargeType" value="8" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio1">More International</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" id="customRadio2" name="chargeType" value="5" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio2">More Credit</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" id="customRadio3" name="chargeType" value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio3">More Time</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio4" name="chargeType" value="9" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio4">More Data</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="fieldset-footer">
                                    <span>Step 1 of 4</span>
                                </div>
                            </fieldset>

                            <h3>
                                <span class="title_text">Verification</span>
                            </h3>
                            <fieldset class="add_content_padding">

                                <h2 class="mt-4">Verify Your Phone Number</h2>
                                <div class="fieldset-content">
                                    <div class="alert alert2 alert-danger" style="display: none;"></div>
                                    <div class="alert alert-success success-msg2" style="display: none;"></div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-4">
                                            <label for="mobileNumber" class="form-label m-0"><b>Mobile number:</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <span>+<b id="selectedMobile">+0012258888</b></span>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-4">
                                            <label for="amount" class="form-label m-0"><b>Amount:</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <span><b id="selectedAmount">350</b> AED</span>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-4">
                                            <label class="form-label mb-0"><b>Selected Option:</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="custom-control custom-radio m-0">
                                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadio1" id="selectedType">More International</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label class="form-label mb-0"><b>Enter OTP:</b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div id="form">
                                                <div class="d-flex align-items-center" id="form">
                                                    <input class="form-control ml-0 optField"  name="otp[]" type="text" maxLength="1" size="1" />
                                                    <input class="form-control optField" type="text"  name="otp[]" maxLength="1" size="1" />
                                                    <input class="form-control optField" type="text"  name="otp[]" maxLength="1" size="1"  />
                                                    <input class="form-control optField" type="text"  name="otp[]" maxLength="1" size="1"  />
                                                </div>
                                                <span>Enter OTP you recieved on the above number. <a href="javascript:void(0);" id="resend_otp">Resend OTP</a></span>
                                                <span id="time" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="fieldset-footer">
                                    <span>Step 2 of 4</span>
                                </div>

                            </fieldset>

                            <h3>
                                <span class="title_text">Payment</span>
                            </h3>
                            <fieldset class="add_content_padding">
                                <h2 class="mt-4">Payment Detail</h2>
                                <div class="fieldset-content">
                                    <div class="alert alert3 alert-danger" style="display: none;"></div>
                                    <div class="alert alert-success success-msg3" style="display: none;"></div>

                                    @if(isset($login_customer))
                                    <div id="walletWrap">
                                        <h5>Gift Card</h5>
                                        <p>iPay allows you to accept payments via gift card, you can use your wallet to recharge</p><br>
                                     </div>
                                    @endif

                                    <div id="credit">
                                        <h5>Master Card</h5>
                                        <p>iPay allows you to accept payments with Mastercard, Please wait while payment process is starting</p><br>
                                        <img class="set-image-size" src="{!! url('/').'/public/web/img/payment.png' !!}" /></p><br>
                                    </div>

                                    <div id="finalAmount">
                                        @if(isset($login_customer))
                                        <p>Pay via iPay Wallet: {!! $general_setting_raw->currency !!}&nbsp;<span id="pay_wallet">{!! isset($login_customer->attributes->wallet) ? $login_customer->attributes->wallet : 0.00 !!}</span></p>
                                        @endif
                                         <p>Pay via Mastercard: {!! $general_setting_raw->currency !!}&nbsp;<span id="pay_paid_amount">0.00</span>

                                    </div>
                                   {{-- <div id="credit">
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-4">
                                                <label for="credit_card" class="form-label m-0"><b>Card number:</b></label>
                                                  </div>
                                            <div class="col-sm-8">
                                                <input class="form-control cc-number" maxlength="19" id="card_number" name="card_number" pattern="\d*" placeholder="Card Number" type="tel" />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-4">
                                                <label for="cvc" class="form-label m-0"><b>Card Expiry:</b></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input class="form-control cc-expires" maxlength="7" id="expiry_date" name="expiry_date" pattern="\d*" placeholder="MM / YY" type="tel" />
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-4">
                                                <label for="cvc" class="form-label m-0"><b>CVC:</b></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input class="form-control cc-cvc" maxlength="4" id="cvc" name="cvc" pattern="\d*" placeholder="CVC" type="tel" />
                                            </div>
                                        </div>--}}
                                    </div>

                                <div class="fieldset-footer">
                                    <span>Step 3 of 4</span>
                                </div>
                            </fieldset>

                            <h3>
                                <span class="title_text">Confirmation</span>
                            </h3>
                            <fieldset class="add_content_padding">
                                 <div class="fieldset-content">
                                     <div class="alert alert4 alert-danger" style="display: none;"></div>
                                     <div class="row">
                                         <div class="col-md-6 offset-md-3 text-center">
                                             <span class="mt-3 mb-5 d-block check-circle"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                             <p class="mb-2">Your payment has been processed successfully and you booking is confirmed.</p>
                                             <p>Please check your email for booking details.</p>
                                         </div>
                                     </div>
                                 </div>

                                <div class="fieldset-footer">
                                    <span>Step 4 of 4</span>
                                </div>
                            </fieldset>
                        </form>
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
    <script src="<?php echo url('/').'/public/web/js/jquery.validate.min.js'?>"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.0.1/jquery.payment.min.js'></script>
    <script src="<?php echo url('/').'/public/web/js/verification-code.js'?>"></script>
    <script src="<?php echo url('/').'/public/web/js/jquery.steps.min.js'?>"></script>
    <script src="<?php echo url('/').'/public/web/js/wiz-form.js'?>"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/intlTelInput.min.js'></script>

    @include("web/includes/topup/topup_js")
    <script>

        menus("{{ route('menus') }}",<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';  ?>) ;


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
            /*$('.basketList').enscroll({
                showOnHover: true,
                verticalTrackClass: 'track3',
                verticalHandleClass: 'handle3'
            });*/
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

