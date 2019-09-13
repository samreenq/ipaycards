

@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")
	@endsection


	@section("navbar")
		@parent
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@parent
		
		@include("web/includes/cartbar")
	@endsection
		
		
	
	@section("checkout2")

		<?php



		?>
			
		<section class="checkout-step-2 lightgreybg">
			<div class="container">
				<div class="checkout-header">
					<ul class="checkout-steps">
						<li class="active"><a ><span>1</span> Review your Order</a></li>
						<li class="active"><a ><span>2</span> Delivery Info</a></li>
						<li><a ><span>3</span> Order Confirm</a></li>
					</ul>
				</div>
				<div class="row clearfix recipeFixed">
					<div class="col-md-12 col-lg-8 deliveryInfoWrap ">

						
						<div class="deliveryInfo deliveryInstructions whitebg activeArrow">
							<div class="address-Header clearfix">
								<h4 class="pull-left collapsed"   role="button" href="#deliveryInstructions" aria-expanded="false" aria-controls="collapseExample">Delivery Instructions</h4>
							</div>
							<div id="deliveryInstructions" class="collapse show">
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>			
								
								<form>
									<div class="discount" ></div>
									<div class="row">
										<div class="col-md-9 cuspad" >
											<div class="fluid-label">
												<input type="text" id="coupon_code" name="coupon_code"  placeholder="Coupon Code" />
												{{--  <label>Add Note*</label>--}}
											</div>
										</div>
										<div class="col-md-3 cuspad" >
											<input  type="button" name="" role="button" data-toggle="collapse"  value="Apply" class="d-flex ml-auto calculateDiscount" style="cursor:pointer;background-color: #0f738d; color: #fff; border: none; padding: 10px 33px; text-transform: uppercase;" />
										</div>

                                        <?php  if(isset($login_customer->auth->platform_type) && $login_customer->auth->platform_type == 'facebook' && $login_customer->auth->mobile_no == ''){ ?>

										<div class="col-md-6 cuspad checkout_mobile_number">
											<div class="fluid-label">
												<input type="text" placeholder="Contact Number*" id="checkout_mobile_number" name="checkout_mobile_number"  value="{!! $login_customer->auth->mobile_no !!}">
											</div>
										</div>
                                        <?php } ?>

                                        <div class="col-md-6 cuspad recipient" style="display: none;">
                                            <div class="fluid-label">
                                                <input type="text" id="recipient_name" name="recipient_name" value="{!! isset($login_customer->auth->name) ? $login_customer->auth->name : "" !!}"  placeholder="Recipient Name" />
                                                {{--  <label>Add Note*</label>--}}
                                            </div>
                                        </div>
										<div class="col-md-6 cuspad recipient" style="display: none;">
											<div class="fluid-label">
												<input type="text" id="recipient_email" name="recipient_email" value="{!! isset($login_customer->auth->email) ? $login_customer->auth->email : "" !!}"  placeholder="Recipient Email" />
												{{--  <label>Add Note*</label>--}}
											</div>
										</div>

                                        <div class="col-md-12 cuspad recipient" style="display: none;">
                                            <div class="fluid-label">
                                                <textarea id="recipient_message" name="recipient_message" placeholder="Recipient Message*" ></textarea>
                                                {{--  <label>Add Note*</label>--}}
                                            </div>
                                        </div>

										<div class="col-md-12 cuspad">
											<div class="fluid-label">
											  <textarea id="order_notes" name="order_notes" required="required" placeholder="Add Note"></textarea>
											{{--  <label>Add Note*</label>--}}
											</div>
										</div>
										<div class="col-md-12 addAddressWrap">
												{{--<input  type="button" name="" role="button" data-toggle="collapse" href="#paymentinfo" aria-expanded="false" aria-controls="collapseExample" value="Next" class="d-flex ml-auto process_order" style="cursor:pointer;background-color: #0f738d; color: #fff; border: none; padding: 10px 33px; text-transform: uppercase;" />--}}
											<input  type="button" id="checknext" name="" role="button" value="Next" class="d-flex ml-auto process_order" style="cursor:pointer;background-color: #0f738d; color: #fff; border: none; padding: 10px 33px; text-transform: uppercase;" />
										</div>
										
									</div>
								</form>
							</div>
						</div>
						 
						<div class="paymentInfo whitebg">
							<div class="payment-Header clearfix">
								<h4 class="pull-left collapsed" role="button"  aria-expanded="true" aria-controls="collapseExample">Payment Info</h4>

							
							

							<div class="collapse show" id="paymentinfo">
								<div class="paymentInfoForm">
									<div class="payment-method">

										<input type="hidden" name="currency_conversion" id="currency_conversion" value="" />
										<input type="hidden" name="paid_amount" id="paid_amount" value="" />
										<div class="big-radio webpay cryptoCurrencyWrap noselect">
											<img src="<?php echo url('/').'/public/web/img/isw_logo_new_combined.png'?>" alt="bitcoin-logo" width="200"/>
										<input type="hidden" name="payment_method"  id="payment_method" value="cod" >
											<label for="crypto-currency">
												Master Card
											</label>
											<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
										</div>

										
										<!--<div class="big-radio wallet cryptoCurrencyWrap noselect">
											<img src="<?php echo url('/').'/public/web/img/isw_logo_new_combined.png'?>" alt="bitcoin-logo" width="200"/>
											<input type="radio" name="payment_method" id="credit-card" value="wallet" >
											<label for="credit-card">
												iPay Wallet
											</label>
											<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
										</div> -->
										
										
										<!--<div class="big-radio cash CashDeliveryWrap noselect">
											<img src="<?php echo url('/').'/public/web/img/volet-logo.svg'?>" alt="bitcoin-logo" width="35"/>
											<input type="radio" name="payment_method" id="cash-on-delivery" value="cod">
											<label for="cash-on-delivery">
												Cash On Delivery
											</label>
											<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
										</div>-->
										
									</div>

								</div>
							</div>


							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-4">
						<div id="sidebarCheckout">
							<div class="whitebg checkOrderWrap sidebar__inner">
								<h4>Summary</h4>
								
								<p>You will recieve your voucher codes after payment via email.</p>
								<!--<form role="form">
									<div class="fluid-label">
									   <span class="icon-tt-cupon-icon"></span>
									   <input id="coupon_code" type="text" placeholder="Coupon Code" />
									   <label>Coupon Code</label>
									</div>
									<input style="cursor:pointer;" type="button" name="" value="Apply" class="calculateDiscount coupon-btn"/>
								</form>-->

								<div class="checkOrderTotal">

									<table width="100%"> 
									
									
										<tr>
											<td class="summaryTitle">Order Price</td>
											<td class="summaryPrice subtotal">{!! $currency !!} 0.00</td>
										</tr>
										<tr class="borderB"><td colspan="2"><div></div></td></tr>
										<tr>
											<td class="summaryTitle">Coupon Discount</td>
											<td class="summaryPrice discount_amount">{!! $currency !!} 0.00</td>
										</tr>
										
										{{--<tr>
											<td class="summaryTitle">Delivery Charges</td>
											<td class="summaryPrice delivery_charge">{!! $currency !!} 0.00</td>
										</tr>--}}
										<tr>
											<td class="summaryTitle">Wallet Amount</td>
											<td class="summaryPrice customer_wallet">{!! $currency !!} 0.00</td>
										</tr>
										{{--<tr>
											<td class="summaryTitle">Loyalty Points</td>
											<td class="summaryPrice calculated_loyalty_points">0.00 Points</td>
										</tr>--}}
										
										
									<!--
										<tr>
											<td class="summaryTitle">Delivery Charges</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
										<tr>
											<td class="summaryTitle">Tax</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
									
									-->
										<tr class="borderB"><td colspan="2"><div></div></td></tr>
										<tr>
											<td class="summaryTitle">Order Total</td>
											<td class="paid_amount totalPrice">{!! $currency !!}</td>
										</tr>
										<tr>
											<td colspan="2"  align="center"></td>
										</tr>
									</table>
									<div class="checkFooter text-center">
									<?php
										/*$txn_ref			=	"74547408aaa".date("Y-m-d H:i:s");
										$product_id			=	"1076"	;
										$pay_item_id		=	"101";
										$amount				=	"20000";
										$currency			=	"566";
										$site_redirect_url	=	"http://localhost/web/todaytoday/checkout2";
										$cust_id			=	"000001";
										$site_name			=	"todaytoday";
										$cust_name			=	"zeeshan";
										$mackey 			=	"D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";
										$data = $txn_ref.$product_id.$pay_item_id.$amount.$site_redirect_url.$mackey; 
										$hash 				=	hash('sha512', $data );*/
									?>
									<form id="myform" name="myform" method="post" action="">
										<input id="order_coupon_id" name="order_coupon_id" type="hidden" value="" />
										<input id="checkout_mobile" 	name="checkout_mobile" type="hidden" value="{!! (isset($login_customer->auth->mobile_no)) ? $login_customer->auth->mobile_no: '' !!}" />
										<input id="auth_platform_type" name="auth_platform_type" type="hidden" value="{!! (isset($login_customer->auth->platform_type)) ? $login_customer->auth->platform_type: '' !!}" />
										{{ csrf_field() }}


										<button  type="button" disabled="disabled" class="add-to-cart"  style="width: 100%;border: none;margin: 20px 0 15px ;background-color:#8080808f;" >Process Order</button>
									</form>


										<div class="error-message"></div>
										<p class="text-center"><span class="icon-tt-lock-icon"></span> Secure SSL Checkout</p>
									</div>
								</div>
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
		<?php
        $setting_model = new \App\Http\Models\Setting();
        $google_key = $setting_model->getBy('key','google_api_key');

        $google_api_key = (isset($google_key->value)) ? $google_key->value : "";
				?>
		<script>

		</script>
		<script src="https://ap-gateway.mastercard.com/checkout/version/51/checkout.js"
				data-error="errorPayment"
				data-cancel="cancelPayment"
				data-complete="checkout3">
		</script>

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js';?>"></script>
		<script src="http://maps.googleapis.com/maps/api/js?key={!! $google_api_key !!}&amp;libraries=places"></script>
		<script src="<?php echo url('/').'/public/web/js/jquery.geocomplete.js'; ?>"></script>

		<script type="text/javascript">
	
		<?php 
			if(isset($_SESSION['fbUserProfile']) || Session::has('users') )
			{
		?>
				load_wishlist("{{ route('add_to_wishlist') }}");
			
		<?php 
			}
		?>
		
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				show_cart("{{ route('show_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				checkout("{{ route('checkout') }}","{{ route('checkout2') }}");
				discount("{{ route('discount') }}","{{ route('total_price') }}");
				
				signin("{{ route('signin') }}");
				//signup("{{ route('signup') }}");
				referAFriend("{{ route('refer_a_friend') }}");
				aboutBusiness("{{ route('aboutBusiness') }}")	;
			
				if(typeof(localStorage.coupon_code)!="undefined")
				{
					
					localStorage["coupon_code"] =" ";
					localStorage.setItem("coupon_code", " ");
				}

        $(document).ready(function() {
            console.log(localStorage.is_gift_card);

            if(localStorage.is_gift_card == 1){
                $('.recipient').show();
			}
        });

	function cancelPayment()
	{
	    window.location.href = "{!! url('/').'/checkout2' !!}";
	}

        function errorPayment(error)
        {
            console.log('Erorr Payment',error)
        }

        var payment_merchant = "{!! config('service.MASTER_CARD.merchant_id') !!}";

        $('.add-to-cart').on('click',function(){

        	var conversion_rate = "{{ $currency_conversion }}";
            if($('#paid_amount').val() > 0) {

                var amt = $("#paid_amount").val()*conversion_rate;
                var amount = parseFloat(amt / 100);

                localStorage.setItem('charge_type','master_card');

                $.ajax({
                    url: "{{ route('get_session') }}",
                    type: 'POST',
                    data: {
                        _token: "{!! csrf_token() !!}",
                        "lead_order_id": $("#entity_id").val(),
                        "amount": parseFloat($('#paid_amount').val()*conversion_rate).toFixed(2),
                    },
                    dataType: 'json',
                    success: function (data) {

                        Checkout.configure({
                            merchant: payment_merchant,
                            order: {
                                amount: parseFloat($('#paid_amount').val()*conversion_rate).toFixed(2),
                                currency: "{!! config('service.MASTER_CARD.currency') !!}",
                                description: 'iPayCards Gift Cards',
                                id: $("#entity_id").val()
                            },
                            session: {
                                id: data.data.session.id
                            },
                            interaction: {
                                merchant: {
                                    name: 'iPayCards - Transaction Order ID: '+$("#entity_id").val(),

                                },
                                displayControl: {
                                    billingAddress  : 'HIDE',
                                    shipping        : 'HIDE'
                                }

                            }
                        });


                        setTimeout(
                            function () {
                                Checkout.showLightbox();
                            }, 1000
                        )

                    },
                    error: function (xhr, statusText, err) {
                        //alert("Error:" + xhr.status);
                        console.log("Error:" + xhr.getAllResponseHeaders());
                    }
                });
            }
            else{
                localStorage.setItem('charge_type','cod');
                window.location.href = "{!! url('/').'/checkout3' !!}"
			}
        });
  
      $(function(){
		  
	/*
		$(".old_address").click(function(){
				$("#deliveryAddress").hide();
			});

		$(".new_address").click(function(){
				$("#deliveryAddress").show();
		});
				  
		 $(".address_book_next").click(function(){
			$(".deliveryInstructions").toggleClass("activeArrow");
		});*/

		$("input.process_order").click(function(){
			//$(".paymentInfo").toggleClass("activeArrow");
		});



		  function testOrder(test)
		  {
		      console.log("Payment Complete",test);
		      return;
		  }
		  
		  function processFinalOrder()
		  {
              console.log($('#paid_amount').val() );

              if($('#paid_amount').val() == 0){
                  $("input[name='payment_method']").val('cod');
                  $('#myform').attr('action', "confirmation");
              }else{
                  $("input[name='payment_method']").val('cod');
                  //$('#myform').attr('action', "https://sandbox.interswitchng.com/collections/w/pay");
                  $('#myform').attr('action', "confirmation");
              }
              console.log($("input[name='payment_method']").val());


              if($('#myform').attr('action') == '' || $('#myform').attr('action') == undefined){
                  //  $('.add-to-cart').attr('disabled','disabled');
                  $('.error-message').html('');
                  $('.error-message').append('<div class="alert alert-danger">Please select all information to process order.</div>');
              }
              else{



                  console.log($('input[name="payment_method"]').val());
                  if($('input[name="payment_method"]').val() != 'stripe'){

                      $('.add-to-cart').attr('disabled','disabled');
                      $.ajax ({
                          url: "{{ route('confirmation') }}",
                          type: 'post',
                          data:  $('#myform').serialize(),
                          dataType: 'json',
                          success: function(data)
                          {
                              if(data.error == 0){
                                  localStorage.removeItem('products');
                                  window.location = site_url+'/checkout3/'+data.data.order_id;
                              }
                              else{
                                  $('.add-to-cart').removeAttr('disabled');
                                  $('.error-message').html('');
                                  $('.error-message').append('<div class="alert alert-danger">'+data.message+'</div>');
                                  return false;
                              }
                          }

                      });


                  }else{
                      $('.add-to-cart').removeAttr('disabled');
                      $('.alert-danger').remove();
                      localStorage.removeItem('products');
                      $('#myform').submit();
                  }



              }
		  }
		  
		  
		  
        /*$("#geocomplete").geocomplete({
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
		*/
   
        
      /*  $("#reset").click(function(){
          $("#geocomplete").geocomplete("resetMarker");
          $("#reset").hide();
          return false;
        });
        
        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        }).click();
		
		
		var myButtonClasses = document.getElementById("deliveryAddress").classList;
		
		setTimeout(function(){myButtonClasses.add("collapse");},2000);*/
		
      });


	
		/*
				initMap();
				
					function initMap() 
					{
								var input = document.getElementById('street');
								//var autocomplete = new google.maps.places.Autocomplete(input); 
								var autocomplete = new google.maps.places.Autocomplete(input);
								// After the user selects the address
						google.maps.event.addListener(autocomplete, 'place_changed', function() 
						{
								var place = autocomplete.getPlace();
								$('input[id=longitude]').val(place.geometry.location.lng());
								$('input[id=latitude]').val(place.geometry.location.lat());
								
								console.log(place.geometry.location.lng()); 
								
						});
					}
		
		*/
				 $(document).ready(function(){

				     console.log(JSON.parse(localStorage.products));
					
					$("input[type='radio']").click(function(){
						var payment_method = $("input[name='payment_method']:checked").val();
						
						console.log(payment_method);
						/*if(payment_method=="webpay")
							$('#myform').attr('action', "https://sandbox.interswitchng.com/collections/w/pay");
						
						if(payment_method=="wallet")
							$('#myform').attr('action', "confirmation");
						
						if(payment_method=="cod")
							$('#myform').attr('action', "confirmation");*/

						$('.add-to-cart').prop("disabled", false); // Element(s) are now enabled.
					//	$('.add-to-cart').css('background-color','#0f738d');
					});


        
					});
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				show_cart("{{ route('show_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				process_order("{{ route('saveorder') }}","{{ route('get_session') }}","{{ csrf_token() }}");
				
				signin("{{ route('signin') }}");
				//signup("{{ route('signup') }}");
		
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
					
					// Sticky sidebar Checkout
					$('#sidebarCheckout').stickySidebar({
						topSpacing: 20,
						containerSelector: '.recipeFixed',
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
					setTimeout(updateNav,1); //updateNav();
				  }
				}

				// Window listeners
				$(window).resize(function() {
					setTimeout(updateNav,1); //updateNav();
				});
				$btn.on('click', function() {
				  $hlinks.toggleClass('hidden');
				});
				setTimeout(updateNav,1); //updateNav();
				
				
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


