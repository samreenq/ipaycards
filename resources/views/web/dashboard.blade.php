

@extends("web.templates.template2")

	@section("head")
		
	    @include("web/includes/head")
		 
					<link href="<?php echo url('/').'/public/web/css/select2.css'; ?>" rel="stylesheet">
					
					<link href="<?php echo url('/').'/public/web/css/fluid-labels.css'; ?>" rel="stylesheet">
					
					<script src="<?php echo url('/').'/public/web/js/ie-emulation-modes-warning.js'; ?>"></script>
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
		@include("web/includes/header")
	@endsection	
	
	@section("dashboard")
		
		<section class="dashboard-Section lightgreybg">
				<div class="container">
					<div class="row">
						<div class="col-md-2 col-sm-3">
							<aside>
								<ul class="sidebar__inner" role="tablist">
									<li class="li-active"><a href="{{ route('your_account') }}">Your Account</a></li>
									<!--<li class="li-active active"><a href="{{ route('payment') }}">Payment</a></li>-->
									<li class="li-active"><a href="{{ route('order_history') }}">Order History</a></li>
									<li class="li-active"><a href="{{ route('address_book') }}">Address Book</a></li>
									<li class="li-active"><a href="{{ route('customer_wallet') }}">Wallet</a></li>
									<?php
							
											if (isset($_SESSION['fbUserProfile']) )
											{
									?>
												
												<li ><a href="<?php echo $_SESSION['logoutURL']; ?>">Logout</a></li>
									
									<?php
											}

											if (Session::has('users')  )
											{
										
									?>
												
												<li ><a href="{{ route('signout') }}">Logout</a></li>
									
									<?php 
											}
											

									?>
							
								</ul>
							</aside>
						</div>
						<div class="col-md-10 col-sm-9">
						<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="your-account">
									<div class="tab-header">
										<h4>Your Account</h4>
									</div>
									<div class="panelled whitebg">
										<div class="editSec">
											<h4>Your Account <a href="javascript:void(0)" data-toggle="modal" data-target=".editYourDetailmodal"><span class="icon-tt-edit-icon"></span></a></h4>
											<ul>
												<li>Adam Johnson</li>
												<li>Adam.johnson@gmail.com</li>
												<li>202-555-0103</li>
												<li>Ginger Hill Rd, Thomson GA,</li>
											</ul>
										</div>
										<div class="editSec">
											<h4>Password <a href="javascript:void(0)" data-toggle="modal" data-target=".chgPassmodal"><span class="icon-tt-edit-icon"></span></a></h4>
											<p>Change your current password</p>
										</div>
										<div class="editSec">
											<h4>Payment <a href="javascript:void(0)" data-toggle="modal" data-target=".editYourDetailmodal"><span class="icon-tt-edit-icon"></span></a></h4>
											<p>You don't have a payment method yet.</p>
										</div>
										<div class="editSec">
											<h4>Order Preferences </h4>
											<div class="checkbox">
												<label class="checkbox-bootstrap">                                        
													<input type="checkbox">             
													<span class="checkbox-placeholder"></span>           
													<p>Allow Substitutions</p>
												</label>
											</div>
											<p><span>Note: setting does not apply to produce.</span>
											Regardless of your selection here, if we’re not able to deliver the exact produce item that you ordered we will do our best to find an equal or better quality substitute.</p>
										</div>
										<div class="editSec updateOrder">
											<h4>When there is an update to your order. </h4>
											<div class="checkbox">
												<label class="checkbox-bootstrap">                                        
													<input type="checkbox">             
													<span class="checkbox-placeholder"></span>           
													<p>Send an SMS Message</p>
												</label>
												<p>We will send you a delivery reminder text right before your delivery.</p>
											</div>
											<div class="checkbox">
												<label class="checkbox-bootstrap">                                        
													<input type="checkbox">             
													<span class="checkbox-placeholder"></span>           
													<p>Call Before Checkout</p>
												</label>
												<p>We’ll only call if there are pending changes</p>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="payment">
									<div class="tab-header">
										<h4>Payment</h4>
									</div>
									<div class="panelled whitebg">
										<div class="payment-method">
											<div class="big-radio cryptoCurrencyWrap noselect">
												<img src="<?php echo url('/').'/public/web/img/bitcoin-logo.svg'?>" alt="bitcoin-logo" width="78"/>
												<input type="radio" name="radio2" id="crypto-currency" value="option1" >
												<label for="crypto-currency">
													Crypto Currency
												</label>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
											</div>
											<div class="big-radio CreditCardWrap">
												<img src="<?php echo url('/').'/public/web/img/all-card-icon.svg'?>" alt="bitcoin-logo" width="156"/>
												<input type="radio" name="radio2" id="credit-card" value="option2" checked=""/>
												<label for="credit-card">Credit Card</label>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
												<div class="select-card">
													<div class="radio">
														<input type="radio" name="radio3" id="card-1" value="option1" checked="">
														
														<label for="card-1">
															<img src="<?php echo url('/').'/public/web/img/creadt-card-icon-1.svg'?>" alt="card-icon" width="37"/>
															*************123
														</label>
													</div>
													<div class="radio">
														<input type="radio" name="radio3" id="card-2" value="option2">
														
														<label for="card-2">
															<img src="<?php echo url('/').'/public/web/img/creadt-card-icon-2.svg'?>" alt="card-icon" width="37"/>
															*************123
														</label>
													</div>
												</div>
												<div class="addCardWrap">
												<form class="clearfix">
													<h4>Add Card</h4>
													<div class="row">
														<div class="col-md-12 cuspad">
															<div class="fluid-label">
															  <input type="text" placeholder="Credit/Debit Card Number*" />
															  <label>Credit/Debit Card Number*</label>
															</div>
														</div>
														<div class="col-md-4 cuspad">
															<div class="fluid-label">
															  <input type="text" placeholder="CVC Code*" />
															  <label>CVC Code*</label>
															</div>
														</div>
														<div class="col-md-4 cuspad">
															<div class="fluid-label">
															  <input type="text" placeholder="MM/YY" />
															  <label>Expiry*</label>
															</div>
														</div>
														<div class="col-md-4 cuspad">
															<div class="fluid-label">
															  <input type="text" placeholder="Name on card*" />
															  <label>Name on card*</label>
															</div>
														</div>
														<div class="col-md-12">
															<p class="pull-left">We use SSL encryption to protect your information</p>
															<input type="submit" name="" value="Save" class="pull-right"/>
														</div>
													</div>
												</form>
												</div>
											</div>
											<div class="big-radio CashDeliveryWrap noselect">
												<img src="<?php echo url('/').'/public/web/img/volet-logo.svg'?>" alt="bitcoin-logo" width="35"/>
												<input type="radio" name="radio2" id="cash-on-delivery" value="option2">
												<label for="cash-on-delivery">
													Cash On Delivery
												</label>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade orderHistory" id="order-history">
									<table width="100%">
										<tr class="tab-header">
											<th>Order History</th>
											<th>Order ID</th>
											<th>Total</th>
											<th>Status</th>
											<th></th>
											<th></th>
										</tr>
										<tr class="panelled whitebg">
											<td>4-3-2017</td>
											<td>562548</td>
											<td>$50.90</td>
											<td>Pending</td>
											<td><a href="javascript:void(0)" class="reorder">Reorder</a></td>
											<td align="center"><a href="javascript:void(0)"><span class="icon-tt-delet-icon"></span></a></td>
										</tr>
										<tr class="panelled whitebg">
											<td>4-3-2017</td>
											<td>562548</td>
											<td>$50.90</td>
											<td>Received</td>
											<td><a href="javascript:void(0)" class="reorder">Reorder</a></td>
											<td align="center"><a href="javascript:void(0)"><span class="icon-tt-delet-icon"></span></a></td>
										</tr>
										<tr class="panelled whitebg">
											<td>4-3-2017</td>
											<td>562548</td>
											<td>$50.90</td>
											<td>Pending</td>
											<td><a href="javascript:void(0)" class="reorder">Reorder</a></td>
											<td align="center"><a href="javascript:void(0)"><span class="icon-tt-delet-icon"></span></a></td>
										</tr>
										<tr class="panelled whitebg">
											<td>4-3-2017</td>
											<td>562548</td>
											<td>$50.90</td>
											<td>Cancelled</td>
											<td><a href="javascript:void(0)" class="reorder">Reorder</a></td>
											<td align="center"><a href="javascript:void(0)"><span class="icon-tt-delet-icon"></span></a></td>
										</tr>
										<tr class="panelled whitebg">
											<td>4-3-2017</td>
											<td>562548</td>
											<td>$50.90</td>
											<td>Received</td>
											<td><a href="javascript:void(0)" class="reorder">Reorder</a></td>
											<td align="center"><a href="javascript:void(0)"><span class="icon-tt-delet-icon"></span></a></td>
										</tr>
									</table>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="address-book">
									<div class="tab-header">
										<h4>Address Book</h4>
									</div>
									<div class="panelled whitebg clearfix">
										<div class="orderAddress col-md-10 col-md-offset-1 ">
											<div class="radio">
												<input type="radio" name="radio1" id="radio1" value="option1" checked="">
												<label for="radio1">
													Plot 8c MetalBox road,off Acme road Ogba,Ikeja Lagos
												</label>
											</div>
											<div class="radio">
												<input type="radio" name="radio1" id="radio2" value="option2">
												<label for="radio2">
													Plot 8c MetalBox road,off Acme road Ogba,Ikeja Lagos
												</label>
											</div>
											<div class="fluid-label">
												<textarea placeholder="Street Address*"></textarea>
												<label>Street Address*</label>
											</div>
											<input type="submit" name="" value="Save" class="btn-xs btn-theme pull-right"/>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade refund" id="wallet">
									<div class="tab-header clearfix">
										<h4 class="pull-left">Refund History</h4>
										<h4 class="pull-right">Current Balance $58.00</h4>
									</div>
									<div class="whitebg">
										<table width="100%" class="panelled">
											<tr>
												<th>Date</th>
												<th>Cash Back</th>
												<th>Type</th>
												<th></th>
											</tr>
											<tr>
												<td>4-3-2017</td>
												<td>562548</td>
												<td>$50.90</td>
												<td align="center"><a href="javascript:void(0)" class="btn-theme btn-sm">View</a></td>
											</tr>
											<tr class="panelled whitebg">
												<td>4-3-2017</td>
												<td>562548</td>
												<td>$50.90</td>
												<td align="center"><a href="javascript:void(0)" class="btn-theme btn-sm">View</a></td>
											</tr>
											<tr class="panelled whitebg">
												<td>4-3-2017</td>
												<td>562548</td>
												<td>$50.90</td>
												<td align="center"><a href="javascript:void(0)" class="btn-theme btn-sm">View</a></td>
											</tr>
											<tr class="panelled whitebg">
												<td>4-3-2017</td>
												<td>562548</td>
												<td>$50.90</td>
												<td align="center"><a href="javascript:void(0)" class="btn-theme btn-sm">View</a></td>
											</tr>
											<tr class="panelled whitebg">
												<td>4-3-2017</td>
												<td>562548</td>
												<td>$50.90</td>
												<td align="center"><a href="#" class="btn-theme btn-sm">View</a></td>
											</tr>
										</table>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="logout">
									<div class="tab-header">
										<h4>Logout</h4>
									</div>
									<div class="panelled whitebg">
										
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
		
		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js';?>"></script>
		<script src="<?php echo url('/').'/public/web/js/waypoints.min.js';?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
		<script>
					
				load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
				show_cart("{{ route('show_cart') }}","{{ route('total_price') }}");
				total("{{ route('total_price') }}");			
				add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
				checkout("{{ route('checkout') }}","{{ route('checkout2') }}");
				discount("{{ route('discount') }}","{{ route('total_price') }}");
				aboutBusiness("{{ route('aboutBusiness') }}")	;
				
			
			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
			referAFriend("{{ route('refer_a_friend') }}");
			
			
			$('.addtocart').click(function(){
				$(this).hide();
				$('.pro-inc-wrap').toggle( "slide");
			});
			
			//
			$(document).ready(function () {
			  $(".fluid-label").focusout(function(){
				$(".focused").removeClass("focused");	
			  });
			  $('.fluid-label').fluidLabel({
				focusClass: 'focused'
			  });
			});
			
			//
			$(document).ready(function(){												
			   //Navigation Menu Slider
				$('#cartList').on('click',function(e){
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
				
			});
			
			
			$(document).ready(function(){	
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
	 
			//---------------------------------------------------
			// Wizard Form
			
			// Select2 Js
			$(document).ready(function() {
				$(".js-example-basic-single").select2();
			  
				// Sticky sidebar
				$('#sidebar').stickySidebar({
					topSpacing: 20,
					containerSelector: '.container',
					innerWrapperSelector: '.sidebar__inner'
				});
				
			});
			
			// Nav -------------------------------------------
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
			
			
		</script>
	@endsection

