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

$(document).ready(function () {
    let telInput = $("#mobileNumber");

// initialize
    telInput.intlTelInput({
        initialCountry: 'auto',
        preferredCountries: ['us','gb','br','ru','cn','es','it'],
        autoPlaceholder: 'off',
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js",
        geoIpLookup: function(callback) {
            fetch('https://ipinfo.io/json', {
                cache: 'reload'
            }).then(response => {
                if ( response.ok ) {
                return response.json()
            }
            throw new Error('Failed: ' + response.status)
        }).then(ipjson => {
                callback(ipjson.country)
        }).catch(e => {
                callback('us')
        })
        }
    });
});