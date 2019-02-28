
@section('sidebar')
<?php
$general_setting = new \App\Libraries\GeneralSetting();
$general_settings = $general_setting->getSetting();

$minimum_order = '';
if($general_settings){
    //$minimum_order = $general_settings->currency.$general_settings->minimum_order;
}

?>
		<!--Your Basket & Wish List -->
		<div class="cart-list">
			<div class="cart-tabs">
				<div class="cartTabHeader">
					<a href="#" id="nav-close"><span class="icon-tt-close-icon"></span></a>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation"><a href="#yourbasket" class="nav-link active" aria-controls="yourbasket" role="tab" data-toggle="tab">@lang('web.sidebar_tab_1')</a></li>
					<li role="presentation"><a href="#wishlist1" aria-controls="wishlist1" class="nav-link" role="tab" data-toggle="tab">@lang('web.sidebar_tab_2')</a></li>
				  </ul>
				</div>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane in active" id="yourbasket">
						<div class="basketList" id="cart" >
							
						</div>
							<div class="cartTabFooterlandscape">
								<div class="basketOrderTotal">
									<table width="100%"> 
										<tr>
											<td class="summaryTitle">@lang('web.sidebar_delivery_charges')</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
										<tr>
											<td class="summaryTitle">@lang('web.sidebar_tax')</td>
											<td class="summaryPrice">$ 5.00</td>
										</tr>
										<tr>
											<td class="summaryTitle">@lang('web.sidebar_loyalty_points')</td>
											<td class="summaryPrice">50 Points</td>
										</tr>
										<tr class="borderB"><td colspan="2"><div></div></td></tr>
										<tr>
											<td class="summaryTitle">@lang('web.sidebar_order_total')</td>
											<td class="totalPrice">$76.99</td>
										</tr>
										<tr>
											<td colspan="2"  align="center"></td>
										</tr>
									</table>
									<div class="basketFooter text-center">
										<p class="text-center">$30 minimum — @lang('web.sidebar_continue_shopping')</p>
                                            <a href="checkout-1.html">@lang('web.sidebar_check_out')</a>
									</div>
								</div>
							</div>
					
						 <div class="cartTabFooter" style="height:305px;">
							<div class="basketOrderTotal">
								<table width="100%"> 
									<!--
											<tr>
												<td class="summaryTitle">Order price</td>
												<td class="summaryPrice subtotal">₦ 0.00</td>
											</tr>
											<tr class="borderB"><td colspan="2"><div></div></td></tr>
											<tr>
												<td class="summaryTitle">Coupons Discount</td>
												<td class="summaryPrice discount_amount">₦ 0.00</td>
											</tr>
											
											<tr>
												<td class="summaryTitle">Delivery Charges</td>
												<td class="summaryPrice delivery_charge">₦ 0.00</td>
											</tr>
											<tr>
												<td class="summaryTitle">Wallet Amount</td>
												<td class="summaryPrice customer_wallet">₦ 0.00</td>
											</tr>
											<tr>
												<td class="summaryTitle">@lang('web.sidebar_loyalty_points')</td>
												<td class="summaryPrice calculated_loyalty_points">0.00 Points</td>
											</tr>
								
									-->
									
									
											
											<tr>
												<td class="summaryTitle">@lang('web.sidebar_loyalty_points')</td>
												<td class="summaryPrice calculated_loyalty_points">0 Points</td>
											</tr>
											<tr class="borderB"><td colspan="2"><div></div></td></tr>
											<tr>
												<td class="summaryTitle">@lang('web.sidebar_order_total')</td>
												<td class="subtotal summaryPrice totalPrice"></td>
											</tr>
											<tr>
												<td colspan="2"  align="center"></td>
											</tr>
								</table>
								<div class="basketFooter text-center">
                                    @if($minimum_order != '')
									<p class="text-center"><?php echo $minimum_order; ?> minimum — @lang('web.sidebar_continue_shopping')</p>
									@endif
                                        <?php
									
										if (!Session::has('users') && !isset($_SESSION['fbUserProfile']) )
										{

									?>
											<a class="check_out" href="{{ route('checkout1') }}"  data-toggle="modal" data-target=".signupmodal"    >@lang('web.sidebar_check_out')</a>
								
									<?php 
										}
									?>
									<?php 
									
										if (isset($_SESSION['fbUserProfile']) )
										{
												
												
											if(isset($users['auth']['mobile_no']))
											{
												if($users['auth']['mobile_no']!="")
												{
									?>
													<a  href="{{ route('checkout1') }}"     >@lang('web.sidebar_check_out')</a>
													
									<?php 
												}
												else
												{
									?>
											
													<a  href="{{ route('checkout1') }}"  data-toggle="modal" data-target=".social_phone_verficationmodal"    >@lang('web.sidebar_check_out')</a>
								
								
									<?php				
												}
											}
											else 
											{
									?>
											
												<a  href="{{ route('checkout1') }}"  data-toggle="modal" data-target=".social_phone_verficationmodal"    >@lang('web.sidebar_check_out')</a>
								
									<?php					
											}
										
										}
										if (	Session::has('users')  )
										{
											
												
									?>
									
											<a class="check_out"  href="{{ route('checkout1') }}"  >@lang('web.sidebar_check_out')</a>
									<?php
										}
									?>
									
									
								
								
								
								
								
								
								
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="wishlist1">
						<div class="wishList" id="wishlist">
							
							
						</div>
					</div>
				</div>
			</div>
		</div>


@show