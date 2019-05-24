$(function() {
  'use strict';

    $("#form .form-control").keyup(function (e) {
        if(e.keyCode == 8){
            var $prev = $(this).prev('.form-control');
            if ($prev.length)
            {
                $(this).prev('.form-control').focus();
            }
              return true;
        }
        if (this.value.length == this.maxLength) {
            var $next = $(this).next('.form-control');
            if ($next.length)
                $(this).next('.form-control').focus();
            else
                $(this).blur();
        }
    });

    // Set up formatting for Credit Card fields
    $('#credit .cc-number').formatCardNumber();
    $('#credit .cc-expires').formatCardExpiry();
    $('#credit .cc-cvc').formatCardCVC();

});