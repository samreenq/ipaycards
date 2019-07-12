<script src="https://ap-gateway.mastercard.com/checkout/version/51/checkout.js"
        data-error="errorPayment"
        data-cancel="cancelPayment"
            data-complete="{!! url('/') !!}/topup/checkout">
    </script>
<script>

    function restoreFormFields(fields)
    {
        console.log(fields)
    }



    var form = $("#topup-form");

    $("a[href$='previous']").hide();


    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        labels: {
            previous: 'Previous',
            next: 'Next',
            finish: 'Submit',
            current: ''
        },
        isFinishing: false,
        titleTemplate: '<div class="title"><span class="number">#index#</span>#title#</div>',
        onStepChanging: function(event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            // console.log(form.steps("getCurrentIndex"));
            console.log(currentIndex,newIndex);

            $('.success-msg2').hide();

            var service_type = $('#service_type').val();

            var move = true;
            if (currentIndex == 0) {

                $('.alert1').hide();

                if($('#mobileNumber').val() == ''){
                    $('.alert1').show();
                    $('.alert1').text('');
                    $('.alert1').text('The phone number field is required.');
                    return false;
                }

                if($('#customerAmount').val() == ''){
                    $('.alert1').show();
                    $('.alert1').text('');
                    $('.alert1').text('The amount field is required.');
                    return false;
                }

                if(service_type == 'du'){
                    if($('input[name="chargeType"]:checked').length == 0){
                        $('.alert1').show();
                        $('.alert1').text('');
                        $('.alert1').text('Please select recharge type');
                        return false;
                    }
                }

                var move = false;
                $('#number').val($('#mobileNumber').val());
                $('#amount').val($('#customerAmount').val());


                var countryData = $("#mobileNumber").intlTelInput("getSelectedCountryData");
                var dial_code = countryData.dialCode;
                console.log(dial_code);

                $('#dial_code').val(dial_code);


                $('#selectedMobile').text(''); $('#selectedMobile').text(dial_code+$('#mobileNumber').val());
                $('#selectedAmount').text(''); $('#selectedAmount').text($('#customerAmount').val());


                if(service_type == 'du'){
                    var selected_type = $('input[name="chargeType"]:checked').next('label').text();
                    $('#recharge_type').val($('input[name="chargeType"]:checked').val());
                    $('#selectedType').text(''); $('#selectedType').text(selected_type);
                }


                $.ajax({
                    url: "<?php echo url('api/service/otp/send'); ?>",
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: {"vendor": "authy","country_code":dial_code,"phone_number":$('#mobileNumber').val()},
                    beforeSend: function () {
                    }
                }).done(function (data) {

                    if(data.error == 1){
                        $('.alert1').text('');
                        $('.alert1').text(data.message);
                        $('.alert1').show();
                        move = false;
                    }else{
                        move = true;
                    }
                    console.log('step1',move);
                    // return move;
                });
            }
            if (currentIndex == 1) {

                $('.alert2').hide();

                var otp = '';
                $('input[name^="otp"]').each(function() {
                    // alert($(this).val());
                    otp += $(this).val();
                    console.log(otp);
                });

                $.ajax({
                    url: "<?php echo url('api/service/otp/verify'); ?>",
                    type: "GET",
                    async: false,
                    dataType: "json",
                    data: {"vendor": "authy","country_code":$('#dial_code').val(),"phone_number":$('#mobileNumber').val(),"verification_code":otp},
                    beforeSend: function () {
                    }
                }).done(function (data) {

                    if(data.error == 1){
                        move = false;
                        $('.alert2').text('');
                        $('.alert2').text(data.message);
                        $('.alert2').show();
                    }else{
                        move = true;


                        var payment_merchant = "{!! config('service.MASTER_CARD.merchant_id') !!}";

                        var recharge_type = '';
                        if(service_type == 'du'){
                            recharge_type = $('#recharge_type').val();
                        }

                        $.ajax({
                            url: "{{ route('topup_session') }}",
                            type: 'POST',
                            data: {
                                _token: "{!! csrf_token() !!}",
                                "amount": $('#amount').val(),
                                "data" :{
                                    "service_type": $('#service_type').val(),
                                    "customer_no":$('#dial_code').val()+$('#mobileNumber').val(),
                                    "recharge_type":recharge_type,
                                    "amount": $('#amount').val(),
                                    "source": "web",
                                }
                            },
                            dataType: 'json',
                            success: function (data) {

                                if(data.error == 0){

                                    localStorage.setItem('lead_topup_id',data.lead_topup_id);


                                    Checkout.configure({
                                        merchant: payment_merchant,
                                        order: {
                                            amount: $('#amount').val(),
                                            currency: "{!! config('service.MASTER_CARD.currency') !!}",
                                            description: 'Recharge '+$('#service_type').val(),
                                            id: data.lead_topup_id
                                        },
                                        session: {
                                            id: data.data.session.id
                                        },
                                        interaction: {
                                            merchant: {
                                                name: 'iPayCards - Transaction Order ID: '+data.lead_topup_id,
                                            }
                                        }
                                    });

                                    setTimeout(
                                        function () {
                                            Checkout.showLightbox();
                                        }, 500
                                    )
                                }
                                else{
                                    $('.alert3').text('');
                                    $('.alert3').text(data.message);
                                    $('.alert3').show();
                                    move = false;

                                }


                            },
                            error: function (xhr, statusText, err) {
                                //alert("Error:" + xhr.status);
                                console.log("Error:" + xhr.getAllResponseHeaders());

                                $('.alert3').text('');
                                $('.alert3').text(statusText);
                                $('.alert3').show();
                                move = false;
                            }
                        });


                    }
                    console.log('step2-',move);
                    // return move;
                });
            }
            if (currentIndex == 2) {

                $('.alert3').hide();

                /*var recharge_type = '';
                if(service_type == 'du'){
                    recharge_type = $('#recharge_type').val();
                }

                $.ajax({
                    url: "<?php // echo url('topup/send'); ?>",
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: {
                        "_token": "{!! csrf_token() !!}",
                        "service_type": $('#service_type').val(),
                        "customer_no":$('#dial_code').val()+$('#mobileNumber').val(),
                        "recharge_type":recharge_type,
                        "amount": $('#amount').val(),
                        "card_number":$('#card_number').val(),
                        "expiry_date":$('#expiry_date').val(),
                        "cvc":$('#cvc').val(),
                        "source": "web",
                    },
                    beforeSend: function () {
                    }
                }).done(function (data) {

                    if(data.error == 1){
                        move = false;
                        $('.alert3').text('');
                        $('.alert3').text(data.message);
                        $('.alert3').show();

                    }else{
                        move = true;
                    }
                    console.log('step3-',move);
                    // return move;
                });*/


            }

            return move;
            //

            // return form.valid();
        },
        saveState: true
    });


    var handler = function(e){
        //code here
        $('.success-msg2').hide();

        $.ajax({
            url: "<?php echo url('api/service/otp/send'); ?>",
            type: "POST",
            async: false,
            dataType: "json",
            data: {"vendor": "authy","country_code":$('#dial_code').val(),"phone_number":$('#mobileNumber').val()},
            beforeSend: function () {
            }
        }).done(function (data) {

            if(data.error == 1){
                $('.alert2').text('');
                $('.alert2').text(data.message);
                $('.alert2').show();


            }else{
                $('.success-msg2').show();
                $('.success-msg2').text('');
                $('.success-msg2').text('Code successfully sent');

                $('#time').show();
                e.preventDefault();
                $('#resend_otp').removeAttr('href');

                var timeLeft = 60;
                var elem = document.getElementById('time');
                var timerId = setInterval(countdown, 1000);

                function countdown() {
                    if (timeLeft == -1) {
                        clearTimeout(timerId);
                        doSomething();
                    } else {

                        elem.innerHTML = timeLeft + ' seconds remaining';
                        timeLeft--;
                    }
                }

                function doSomething() {
                    $('#time').hide();

                    $('#resend_otp').on("click",handler);
                    $('#resend_otp').attr('href','javascript:void(0)');
                }

                $('#resend_otp').off("click",handler);
            }
            // return move;
        });
    }

    $('#resend_otp').on("click",handler);
    $('#resend_otp').on('click',function(e){


    });


    function cancelPayment()
    {
        window.location.href = "{!! url('/').'/topup/' !!}"+$('#service_type').val();
    }

    function errorPayment(error)
    {
        console.log('Erorr Payment',error);
        window.location.href = "{!! url('/').'/topup/' !!}"+$('#service_type').val();
    }

</script>