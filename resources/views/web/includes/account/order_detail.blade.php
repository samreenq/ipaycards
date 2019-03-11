	
	<?php
    $general_setting = new \App\Libraries\GeneralSetting();

	?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true" class="icon-tt-close-icon"></span>
		</button>
		<div class="modal-body">
			<div class="d-flex align-items-center order-popup-nav">
				<ul class="d-flex mr-4 justify-content-start odrdetail-steps">
					<?php if(count($order_statuses) > 0){
					    $i = 1;
					    foreach($order_statuses as $display_order_status){
					    ?>
							<li <?php if(isset($order_detail['order_status']['value']) && $order_detail['order_status']['value'] == $display_order_status ) echo 'class="active"' ; ?> ><span>{!! $i !!}</span> {!! $display_order_status !!}</li>
                        <?php  $i++; }
                         }
                        ?>
				</ul>
				
			</div>
			<div class="tab-pane">
				<div class="orderPopupBody">
						<div class="odrDetailHeader">
								<div class="row">
									<div class="col-12">
											<h3>Order #<?php  if(isset($order_detail['order_number'])) echo $order_detail['order_number']; ?> </h3>
									</div>
									{{--<div class="odcont col-sm-6 col-md-6 col-lg-3">
											<h4>Delivery Info</h4>
											<p>Rider Id: -</p>
											<p>Rider Name: -</p>
									</div>--}}
									<div class="odcont col-sm-6 col-md-6 col-lg-3">
											<h4>Delivery Address</h4>
											<p><?php if(isset($order_detail['shipping_address']['detail']['first_name'])) echo $order_detail['shipping_address']['detail']['first_name']; ?> </p>
											<p><?php if(isset($order_detail['shipping_address']['detail']['street'])) echo $order_detail['shipping_address']['detail']['street']; ?></p>
									</div>
									<div class="odcont col-sm-6 col-md-6 col-lg-3">
											<h4>Payment</h4>
											<p><?php if(isset($order_detail['payment_method_type']['option'])) echo $order_detail['payment_method_type']['option']; ?></p>
									
											
									</div>
									<div class="odcont col-sm-6 col-md-6 col-lg-3">
											<h4>Time and Date</h4>
											<p>Delivery Date: <?php if(isset($order_detail['user_delivery_date'])) echo date("M d, Y",strtotime($order_detail['user_delivery_date'])); ?></p>
											<p>Delivery Time:<?php if(isset($order_detail['user_delivery_time'])) echo date("g:i A",strtotime($order_detail['user_delivery_time'])); ?><?php if(isset($order_detail['user_delivery_time_end']) && $order_detail['user_delivery_time_end'] != '') echo ' - '.date("g:i A",strtotime($order_detail['user_delivery_time_end'])); ?></p>
										
									</div>
								</div>
						</div>
						<div class="orderDetailListView">
								<table width="100%">
									<tr class="borderB"><td colspan="3"><div></div></td></tr>
									<?php 
											
											foreach ( $order_detail['order_item'] as $products ) 
											{
                                                //Get image of product
                                                $gallery = isset($products['product_id']['detail']['gallery'][0]) ? json_decode(json_encode($products['product_id']['detail']['gallery'])) : false;
                                                $product_image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
									?>
												<tr> 
														<td class="prodImg"><img src="<?php echo $product_image; ?>" width="63"/></td>
														<td>
															<table width="100%">
																	<tr>
																			<td class="addItemRecipe"><?php if(isset($products['product_id']['detail']['title'])) echo $products['product_id']['detail']['title']; ?></td>
																			<td rowspan="2" class="addItemQty" ><?php if(isset($products['quantity'])) echo $products['quantity']; ?></td>
																			<td class="addItemRate" align="right">{!! $currency !!} <?php if(isset($products['price'])) echo $products['price']; ?></td>
																	</tr>
																	<tr>
																				<td class="addItemWeight"><?php if(isset($products['product_id']['detail']['title'])) echo $products['product_id']['detail']['weight']; ?></td>
																				<td class="deliveryRate" align="right">{!! $currency !!} each</td>
																	</tr>
															</table>
														</td>
												</tr>
												<tr class="borderB"><td colspan="3"><div></div></td></tr>
									<?php 
											}
									?>
									
								</table>
						</div>
						<div class="orderDetailFooter">
							<div class="OrderDetailTotal">
								<table width="100%"> 
									<tr class="borderB"><td colspan="2"><div></div></td></tr>
									<tr>
										<td class="summaryTitle">Sub total</td>
										<td class="summaryPrice">{!! $general_setting->getPrettyPrice($order_detail['subtotal']) !!}</td>
									</tr>
									<tr>
										<td class="summaryTitle">Discount</td>
										<td class="summaryPrice">{!! $general_setting->getPrettyPrice($order_detail['discount_amount']) !!}</td>
									</tr>
									<tr>
											<td class="summaryTitle">Delivery Charges</td>
											<td class="summaryPrice">{!!  $general_setting->getPrettyPrice($order_detail['delivery_charge']) !!}</td>
									</tr>

									<!--<tr>
											<td class="summaryTitle">Loyalty Points</td>
											<td class="summaryPrice"><?php if(isset($order_detail['loyalty_points'])) echo $order_detail['loyalty_points']; ?> Points</td>
									</tr>-->
									<tr class="borderB">
											<td colspan="2">
												<div></div>
											</td>
									</tr>
									<tr>
											<td class="summaryTitle">Order Total</td>
											<td class="totalPrice">{!!  $general_setting->getPrettyPrice($order_detail['grand_total']) !!}</td>
									</tr>
									<tr>
										<td class="summaryTitle">Wallet</td>
										<td class="summaryPrice">{!!  $general_setting->getPrettyPrice($order_detail['wallet']) !!}</td>
									</tr>
									<tr>
										<td class="summaryTitle">Paid Remaining Amount</td>
										<td class="summaryPrice">{!!  $general_setting->getPrettyPrice($order_detail['paid_amount']) !!}</td>
									</tr>
									<tr>
											<td colspan="2"  align="center"></td>
									</tr>
								</table>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>