
<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog sign-out-popup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Signout</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               Are you sure you want to signout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="button" id="signout" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Overlay -->
<div class="overlay"></div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="js/jquery-3.1.1.min.js" ></script> -->
<script src='<?php echo url("/")."/public/web/js/jquery.min.js" ?>'></script>

<script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"><\/script>')</script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js'></script>

<script src="<?php echo url('/').'/public/web/js/popper.min.js';?>"></script>
<script src="<?php echo url('/').'/public/web/js/bootstrap.min.js';?>"></script>
<script src="<?php echo url('/').'/public/web/js/hamburgers.js';?>"></script>
<script type="text/javascript" src="<?php echo url('/').'/public/web/js/retina.min.js';?>"></script>
<script src="<?php echo url('/').'/public/web/js/hoverline.js';?>"></script>
<script src="<?php echo url('/').'/public/web/js/jquery.bxslider.min.js';?>"></script>
{{--owlCarousel--}}
<script src="<?php echo url('/').'/public/web/lib/owl-carousel/js/owl.carousel.js';?>"></script>

<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE').'assets/js/bootbox.js') !!}"></script>

{{--<script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>--}}
<script>

    var cart_empty_img = "{!! url('/').'/public/web/img/Cart-Empty.png' !!}";
    var user_loggedin = false;
            @if(Session::has('users')) var user_loggedin = true; @endif
    console.log(user_loggedin);


</script>

<script src="<?php echo url('/') . '/public/web/js/custom/product.js'?>"></script>
<script>


    <?php if(!empty($customerId)){  ?>
    getCustomerCart("{{ route('get_cart') }}");
    <?php } ?>

    $(document).on('click', function(divclose){

            if($(divclose.target).closest("cart-list").length == 0){

                $("cart-list").hide();

            }

        }
    );

    $('.signupmodal').on('hide.bs.modal', function () {

        $('.signupbtn').css("color","rgb(0, 0, 0) !important;");

        $('#email').val("");
        $('#password2').val("");

    });


    $('#signinmodal').on('hide.bs.modal', function () {
        console.log('signinmodal');
        $('.signinbtn').css("color","rgb(0, 0, 0) !important;");
        $('#login_id').val("");
        $('#password').val("");

    });


    var currency = "{!! $general_setting_raw->currency !!}";

    $(document).ready(function () {
        referAFriend("{{ route('refer_a_friend') }}");

        $(document).on("click", ".cart-list .check_out", function (e) {
            $('body').removeClass('nav-expanded');
        });

        /* Verification */
        $("#verifyForm .verify-code").keyup(function (e) {
            if(e.keyCode == 8){
                var $prev = $(this).prev('.verify-code');
                if ($prev.length)
                {
                    $(this).prev('.verify-code').focus();
                }
                return true;
            }
            if (this.value.length == this.maxLength) {
                var $next = $(this).next('.verify-code');
                if ($next.length)
                    $(this).next('.verify-code').focus();
                else
                    $(this).blur();
            }
        });

        //// navbar fixed mobile view code ////
        $(function() {
            $(window).scroll(function(event) {
                if ($(window).scrollTop() > 150) {
                    console.log('$(window).scrollTop()', $(window).scrollTop());
                    $('.mobile-view-position').addClass('scrolled-down');
                    $('.fly-nav-inner').addClass('moreButtonFixed');
                } else {
                    $('.mobile-view-position').removeClass('scrolled-down');
                    $('.fly-nav-inner').removeClass('moreButtonFixed');
                }
            });
        });
        //// navbar fixed mobile view code ////

    });



    $(document).ajaxComplete(function () {


        $('.brands_slide').owlCarousel({
            loop: false,
            slideBy: 1,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
        $('.game_slide').owlCarousel({
            loop: false,
            slideBy: 1,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
        $('.smBannerSlider').bxSlider({
            controls: true,
            touchEnabled: false,
            auto: true,
            minSlides: 1,
            maxSlides: 3,
            moveSlides: 1,
            slideWidth: 360,
            slideMargin: 10,
            captions: true,
            autoDelay: 1500
        });

        $(window).resize(function() {
            //do something
            var width = $(document).width();
            if (width < 991) {
                $('.smBannerSlider').bxSlider({
                    maxSlides: 1,
                    slideWidth: 500
                });
            } else {
                $('.smBannerSlider').bxSlider({
                    maxSlides: 3
                });
            }
        });

        $(".bx-prev").html("");
        $(".bx-next").html("");

        /* 	$('#animationHover').hoverline(); */

        $('.addressScroll, .oldAddressScroll').enscroll({
            showOnHover: true,
            verticalTrackClass: 'track3',
            verticalHandleClass: 'handle3'
        });


    });

    var crsf_token = "{{ csrf_token() }}";
    var site_url = "{!! url('/') !!}";
    // console.log(site_url);


    /*
                window.fbAsyncInit = function () {
                FB.init({
                    appId: "{!! $fb_config->app_id !!}",
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v2.12'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));*/


    // Only works after `FB.init` is called
    /* function facebookLogin() {

         FB.getLoginStatus(function (fbResponse) {

             if (fbResponse.status === 'connected') {
                 //console.log(fbResponse);
                 var userID = fbResponse.authResponse.userID;
                 // console.log(userID); return false
                 fbSocialLogin();

             } else {

                 FB.login(function (response) {

                     if (response.status === 'connected') {

                         fbSocialLogin();
                     } else {
                         // The person is not logged into this app or we are unable to tell.
                         window.location = site_url;
                     }

                 }, {scope: 'public_profile,email'});
             }
         });


     }*/

    /* function fbSocialLogin() {

         if ($(".signinError").hasClass('alert-danger')) {
             $(".signinError").removeClass('alert-danger')
         }

         FB.api('/me?fields=id,name,first_name,last_name,email,gender,locale', function (response) {
             console.log('Successful login for: ' + response.name);
             // console.log(response);

             $.ajax({
                 url: "{{ route('facebookLogin') }}",
                    type: 'post',
                    data: {
                        _token: crsf_token,
                        platform: 'facebook',
                        cart_item: localStorage.products,
                        data: response,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.error == 0) {


                            if (data.data.total > 0) {
                                //console.log(JSON.stringify(data.data.products));
                                var cart_product = [];

                                $.each(data.data.products, function (k, v) {
                                    //console.log(v);
                                    var string = v;
                                    string.product_quantity = parseInt(v.product_quantity)
                                    cart_product.push(string);

                                });

                                //console.log(cart_product);
                                localStorage.setItem("products", JSON.stringify(cart_product));
                            } else {
                                localStorage.removeItem('products');
                            }

                            window.location = site_url;
                        } else {
                            $(".signinError").addClass('alert alert-danger');
                            $(".signinError").empty().append(data['message']);
                        }
                    }

                });

            });
        }

        function onLoadCallback() {
            $('span[id^="not_signed_"]').html('CONNECT WITH GOOGLE');
            $('span[id^="connected"]').html('CONNECT WITH GOOGLE');
        }

        function gmailLogin() {
            gapi.auth2.getAuthInstance().signIn().then(
                function (success) {
                    // Login API call is successful
                    var profile = success.getBasicProfile();
                    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                    console.log('Name: ' + profile.getName());
                    //  console.log('Image URL: ' + profile.getImageUrl());
                    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
                    // This is null if the 'email' scope is not present.

                    $.ajax({
                        url: "{{ route('gmailLogin') }}",
                        type: 'post',
                        data: {
                            _token: crsf_token,
                            platform: 'gplus',
                            cart_item: localStorage.products,
                            data: {id: profile.getId(), name: profile.getName(), email: profile.getEmail()},
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.error == 0) {


                                if (data.data.total > 0) {
                                    //console.log(JSON.stringify(data.data.products));
                                    var cart_product = [];

                                    $.each(data.data.products, function (k, v) {
                                        //console.log(v);
                                        var string = v;
                                        string.product_quantity = parseInt(v.product_quantity)
                                        cart_product.push(string);

                                    });

                                    //console.log(cart_product);
                                    localStorage.setItem("products", JSON.stringify(cart_product));
                                } else {
                                    localStorage.removeItem('products');
                                }

                                $('.siginmodal').toggle();
                                window.location = site_url;
                            } else {
                                $(".signinError").addClass('alert alert-danger');
                                $(".signinError").empty().append(data['message']);
                            }
                        }

                    });


                },
                function (error) {

                    //var message = 'Please use correct credential to sign in.';
                    // $(".signinError").addClass('alert alert-danger');
                    // $(".signinError").empty().append(message);
                    // Error occurred
                    console.log(error.error) //to find the reason
                }
            );
        }*/

/*    function fbLogin()
    {
        $.ajax
        ({

            url: "",
            type: 'get',
            data: {
            },
            dataType: 'json',
            success: function (data) {

            }
        });
    }*/


    $(document).ready(function () {


        $("#how-work").on("click", function (e) {
            $('.nav-tabs a[href="#aboutTab-1"]').tab('show');
        });

        $("#delivery-info-model, #deliver-info-model").on("click", function (e) {
            $('.nav-tabs a[href="#aboutTab-3"]').tab('show');
        });

        $("#signup").on("click", function (e) {

            var terms_condition = '';

            if ($('#term_condition').is(":checked")) {
                terms_condition = 1;
            }

            $.ajax
            ({

                url: "{{ route('signup') }}",
                type: 'post',
                data: {
                    email: $('#email').val(),
                    password: $('#password2').val(),
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    mobile_no: $('#mobile_no').val(),
                    refer_friend_code_applied: $('#refer_friend_code_applied').val(),
                    _token: crsf_token,
                    term_condition: terms_condition,
                    url: ''
                },
                dataType: 'json',
                success: function (data) {
                    if (data['error'] == 1) {
                        $(".signupError").addClass('alert alert-danger');
                        //$("#error_msg_phone_verification").css("color", "red");
                        $(".signupError").empty().append(data['message']);

                    } else {
                        var phone_number = $('#mobile_no').val();
                        $(".phone_number").empty().append(phone_number);
                        $("#phone_number").val(phone_number);
                        $('.signupmodal').modal('hide');
                        $('.pVerfymodal').modal('toggle');
                        $("#entity_id").val(data['entity_id']);
                        $(".phone_verfication").on("click", function (e) {
                            var code = $('#tel1').val() + $('#tel2').val() + $('#tel3').val() + $('#tel4').val();
                            if ($('#tel1').val() == '' || $('#tel2').val() == '' || $('#tel3').val() == '' || $('#tel4').val() == '') {
                                $("#error_msg_phone_verification").addClass('alert alert-danger');
                                //$("#error_msg_phone_verification").css("color", "red");
                                //$("#error_msg_phone_verification").css("background-color",'#f8d7da');
                                //$("#error_msg_phone_verification").css("border-color",'#f5c6cb');
                                $("#error_msg_phone_verification").empty().append('Please enter verification code');

                            } else {
                                $.ajax
                                ({
                                    url: "{{ route('phoneVerification') }}",
                                    type: 'post',
                                    data: {
                                        mobile_no: $('#mobile_no').val(),
                                        verification_token: data['auth']['verification_token'],
                                        verification_mode: 'signup',
                                        entity_type_id: 11,
                                        authy_code: code,
                                        _token: crsf_token,
                                    },
                                    dataType: 'json',
                                    success: function (data) {

                                        if (data['error'] == 1) {
                                            $("#error_msg_phone_verification").addClass('alert alert-danger');
                                            //$("#error_msg_phone_verification").css("color", "red");
                                            $("#error_msg_phone_verification").empty().append(data['message']);
                                            //$('.signupmodal').modal('hide');
                                            //$('.pVerfymodal').modal('hide');
                                        } else {

                                            $("#error_msg_phone_verification").addClass('alert alert-success');
                                            //	$("#error_msg_phone_verification").css("color", "white");
                                            $("#error_msg_phone_verification").empty().append(data['message']);

                                            //$('.signupmodal').modal('hide');
                                            // $('.siginmodal').modal('hide');
                                            $('.pVerfymodal').modal('hide');
                                            // setTimeout(function() {/*do something special*/}, 2000);
                                            window.location = $('#url').val();
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        });


        $(".resend").on("click", function (e) {


            /* alert("The verification has been resend to your phone.");*/

            $("#error_msg_phone_verification").removeClass('alert alert-danger');
            $("#error_msg_phone_verification").addClass('alert alert-success');

            $.ajax
            ({
                url: "{{ route('resendCode') }}",
                type: 'post',
                data: {

                    mobile_no: $('#phone_number').val(),
                    new_login_id: $('#phone_number').val(),
                    mode: 'signup',
                    entity_type_id: 11,
                    entity_id: $('#entity_id').val(),
                    _token: crsf_token,
                },
                dataType: 'json',
                success: function (data) {

                    if (data['error'] == 1) {
                        $("#error_msg_phone_verification").addClass('alert alert-danger');
                        //$("#error_msg_phone_verification").css("color", "red");
                        $("#error_msg_phone_verification").empty().append(data['message']);
                    } else {

                        $("#error_msg_phone_verification").addClass('alert alert-success');
                        //$("#error_msg_phone_verification").css("color", "white");
                        //$("#error_msg_phone_verification").css("background-color",'#d4edda');
                        //$("#error_msg_phone_verification").css("border-color",'#d4edda');
                        $("#error_msg_phone_verification").empty().append('The verification code has been resend to your phone.');
                    }


                }
            });

            //window.location = $('#url').val();
        });

        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn1');

        allWells.hide();

        navListItems.click(function (e) {

            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-visible').addClass('btn-default');
                $item.addClass('btn-visible');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function () {

            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url']"),
                isValid = true;

            $(".fluid-label").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".fluid-label").addClass("has-error");
                }
            }

            if (isValid) {

                if($(".signup_error").hasClass('alert')){
                    $(".signup_error").removeClass('alert alert-danger')
                }

                //if email is empty
                if($('#step-1 input[name="email"]').val() == ''){
                    $(".signup_error").addClass('alert alert-danger');
                    $(".signup_error").empty().append("Email field is required");
                    return false;
                }


                //if password is empty
                if($('#step-1 input[name="password"]').val() == ''){
                    $(".signup_error").addClass('alert alert-danger');
                    $(".signup_error").empty().append("Password field is required");
                    return false;
                }


                //var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{!! url('/').'/validateSignUp' !!}",
                    data: {
                        entity_type_id: 11,
                        email: $('#step-1 input[name="email"]').val(),
                        password: $('#step-1 input[name="password"]').val(),
                        _token: crsf_token,
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.error);
                        if (data.error == 1) {
                            $(".signup_error").addClass('alert alert-danger');
                            $(".signup_error").empty().append(data.message);
                        } else {
                            $(".signup_error").empty();
                            $('.stepwizard-step a[href="#step-1"]').attr('disabled', 'disabled');
                            nextStepWizard.removeAttr('disabled').trigger('click');
                        }
                    }
                });

                // nextStepWizard.removeAttr('disabled').trigger('click');
            }

        });

        $('div.setup-panel div a.btn-visible').trigger('click');

        $(document).on("click", "#save_review", function (e) {

            $(".order_review_Error").css('display', 'none');
            var Order_id = $('#order_id').val();
            var Rating = $('#rating').val();
            var Review = $('#review').val();


            if (Rating == '' || Review == '') {
                if (Rating == '') {
                    $(".order_review_Error").css('display', 'block');
                    $(".order_review_Error").addClass('alert alert-danger');
                    /*$(".order_review_Error").css("color", "red");
                    $(".order_review_Error").css("background-color",'#f8d7da');
                    $(".order_review_Error").css("border-color",'#f5c6cb');*/
                    $(".order_review_Error").empty().append('Please give rating before submission!');
                } else if (Review == '') {
                    $(".order_review_Error").css('display', 'block');
                    $(".order_review_Error").addClass('alert alert-danger');
                    /*$(".order_review_Error").css("color", "red");
                    $(".order_review_Error").css("background-color",'#f8d7da');
                    $(".order_review_Error").css("border-color",'#f5c6cb');*/
                    $(".order_review_Error").empty().append('Please fill review before submission!');
                }
            } else {
                $.ajax({
                    url: "{{ route('get_order_review_detail') }}",
                    type: 'get',
                    data: {
                        order_id: Order_id,
                        rating: Rating,
                        review: Review
                    },
                    dataType: 'text',
                    success: function (data) {
                        $(".order_review_Error").css('display', 'none');
                        $(".orderReviewPopupBody").empty().append('<div  class="alert alert-success"> Thanks for feedback!</div>');

                        if (Rating != '' && Review != '') {
                            timeR = setInterval(function () {
                                $('.orderReviewmodel').modal('hide');
                                clearInterval(timeR);
                            }, 2000);
                        }


                    }

                });
            }


        });


        @if(Session::has('users'))

        if (typeof (localStorage.products) == "undefined") {
            $.ajax({

                url: site_url + '/updateCart',
                type: 'post',
                data: {
                    products: '',
                    _token: crsf_token
                },
                dataType: 'json',
                success: function (data) {

                }
            });

        }

        @endif

        //console.log('loggedin' + user_loggedin);

        $("#forget_your_account_password").click(function () {

            $.ajax({
                url: site_url + '/forgotPassword',
                data: {
                    _token: crsf_token,
                    current_email: $("#current_email").val(),
                },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data['error'] == 1) {
                        $("#account_forget_response").addClass('alert alert-danger');
                        $("#account_forget_response").empty().append(data['message']);

                    }
                    if (data['error'] == 0) {
                        if ($("#account_forget_response").hasClass('alert-danger')) {
                            $("#account_forget_response").removeClass('alert alert-danger');
                        }
                        $("#account_forget_response").addClass('alert alert-success');
                        $("#account_forget_response").empty().append(data['message']);

                        forgotUser = setInterval(function () {
                            $('#current_email').val('');

                            if ($("#account_forget_response").hasClass('alert-success')) {
                                $("#account_forget_response").removeClass('alert alert-success');
                                $("#account_forget_response").text('');
                            }

                            $('.forPassmodal ').modal('hide');
                            clearInterval(forgotUser);
                        }, 2000);
                    }

                }
            });

        });

        $("#signout").on('click', function () {
            signout();
        });


        $('.socialBtn').on('click',function(){

            var platform_id = $(this).data('id');
            $.ajax({
                url: site_url + '/social/login',
                type: 'POST',
                dataType: 'json',
                data:{
                    _token: crsf_token,
                    platform: $(this).data('id'),
                    cart_item: localStorage.products,
                    redirect_to: "{!! url()->full() !!}"
                },
                success: function (data) {

                    window.location.href = "{!! url('/').'/login/' !!}"+platform_id;
                }
            });

        });

        $(document).on("click", ".wishlist-cart", function (e) {
          //  alert($(this).data('id'));

            var element_id = $(this).data('id');
            var wishlist_id = $(this).data('wishlist-id');
            var $button = $('#wishlist-'+element_id);
            var newVal = 1;
            var entity_id = $button.find('#entity_id').val();
            var product_code = $button.find('#product_code').val();
            var title = $button.parent().find('#title').val();
            var thumb = $button.parent().find('#thumb').val();
            var price = $button.parent().find('#price').val();
            var item_type = $button.parent().find('#item_type').val();


            //$button.parent().find('.quantity').val(newVal);
           var product_quantity = newVal;

            if (product_quantity == 1) {
                if (typeof (localStorage.products) == "undefined") {
                    var string = '[{"entity_id":' + entity_id + ',"product_code":"' + product_code + '","title":"' + title + '","thumb":"' + thumb + '","item_type":"' + item_type + '","price":"' + price + '","product_quantity":' + parseInt(product_quantity) + '}]';
                    localStorage.products = string;
                    console.log('sam', localStorage.products);
                }

                else if (typeof (localStorage.products) !== "undefined") {
                    var products = JSON.parse(localStorage.products);
                    var products1 = [];
                    n = 0;
                    for (var i = 0; i < products.length; i++) {
                        if (product_code === products[i].product_code) {
                           products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                          //  products[i].product_quantity = parseInt(product_quantity);
                            n = 0;
                            break;
                        } else {
                            n = 1;
                        }
                    }
                    if (n == 1) {
                        var len = products1.length;
                        var string = {
                            "entity_id": entity_id,
                            "product_code": product_code,
                            "title": title,
                            "thumb": thumb,
                            "price": price,
                            "item_type": item_type,
                            /*"weight":weight,
                            "unit_option":unit_option,
                            "unit_value":unit_value,*/
                            "product_quantity": parseInt(product_quantity)
                        };
                        products.push(string);
                    }
                    localStorage.setItem("products", JSON.stringify(products));
                    total("{{ route('total_price') }}");
                }
            }
            load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
            deleteWishlistProduct(element_id,'{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}','{{route('add_to_wishlist')}}','{{route('delete_to_wishlist')}}')
            e.preventDefault();

        });



    });



    function signout() {
        $.ajax({
            url: site_url + '/signout',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                if (data.error == 0) {
                    localStorage.removeItem('products');
                    window.location = site_url;
                }
            }
        });
    }


</script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo url('/').'/public/web/js/ie10-viewport-bug-workaround.js';?>"></script>

<!-- Field Style -->
<script src="<?php echo url('/').'/public/web/js/fluid-labels.js';?>"></script>

<?php
if (Session::has('message1'))
{
?>
<script type="text/javascript" >    $('.signupmodal').modal('show'); </script>
<?php
Session::flush();
}
?>

<?php
if ( Session::has('message2'))
{
?>
<script type="text/javascript" >    $('.siginmodal').modal('show'); </script>
<?php
Session::flush();
}
?>
