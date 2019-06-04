<script>


    $("a[href$='previous']").hide();

    var form = $("#topup-form");
    $("a[href$='previous']").hide();
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: 0,
        labels: {
            previous: 'Previous',
            next: 'Next',
            finish: 'Submit',
            current: ''
        },
        titleTemplate: '<div class="title"><span class="number">#index#</span>#title#</div>',
        onStepChanging: function (event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            // console.log(form.steps("getCurrentIndex"));
            console.log(currentIndex, newIndex);

            $("a[href$='previous']").hide();

            $('.success-msg2').hide();

            var move = true;
            if (currentIndex == 0) {

                $('.alert1').hide();

                if ($('#pnrNumber').val() == '') {
                    $('.alert1').show();
                    $('.alert1').text('');
                    $('.alert1').text('The account number field is required.');
                    return false;
                }

                var move = false;
                $('#customer_no').val($('#pnrNumber').val());

                $.ajax({
                    url: "<?php echo url('api/service/topup/service_check'); ?>",
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: {"service_type": $('#service_type').val(), "customer_no": $('#pnrNumber').val()},
                    beforeSend: function () {
                    }
                }).done(function (data) {

                    if (data.error == 1) {
                        $('.alert1').text('');
                        $('.alert1').text(data.message);
                        $('.alert1').show();
                        move = false;
                    } else {
                        $('#amount').val(data.data.amount);
                        $('#request_key').val(data.data.request_key);

                        var str = data.data.info;
                        var res = str.replace(/\n/g, "<br />");

                        console.log('updated', res);
                        $('#pnrNumberText').text('');
                        $('#pnrNumberText').text($('#customer_no').val());
                        $('#customerNameText').text('');
                        $('#customerNameText').text(data.data.customer_name);
                        $('#amountText').text('');
                        $('#amountText').text(data.data.amount);
                        $('#infoText').text('');
                        $('#infoText').html(res);

                        move = true;
                    }
                    console.log('step1', move);
                    // return move;
                });
            }
            if (currentIndex == 1) {

                $('.alert2').hide();

                if ($('#amount').val() == '' || $('#customer_no').val() == '' || $('#request_key').val() == '' || $('#service_type').val() == '') {
                    move = false;
                    $('.alert2').text('');
                    $('.alert2').text('Please proceed again few fields are missing');
                    $('.alert2').show();
                } else {
                    move = true;
                }
            }
            if (currentIndex == 2) {

                $('.alert3').hide();

                $.ajax({
                    url: "<?php echo url('service_topup/send'); ?>",
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: {
                        "_token": "{!! csrf_token() !!}",
                        "service_type": $('#service_type').val(),
                        "customer_no": $('#customer_no').val(),
                        "request_key": $('#request_key').val(),
                        "amount": $('#amount').val(),
                        "card_number": $('#card_number').val(),
                        "expiry_date": $('#expiry_date').val(),
                        "cvc": $('#cvc').val(),
                        "source" : "web"
                    },
                    beforeSend: function () {
                    }
                }).done(function (data) {

                    if (data.error == 1) {
                        move = false;
                        $('.alert3').text('');
                        $('.alert3').text(data.message);
                        $('.alert3').show();

                    } else {
                        move = true;
                    }
                    console.log('step3-', move);
                    // return move;
                });
            }

            return move;
            //

            // return form.valid();
        },

        saveState: true
    });






</script>