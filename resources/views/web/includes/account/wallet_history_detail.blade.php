

<?php 


?>
			<table width="100%" class="table table-striped table-hover table-responsive2 walletTable">

				
				<tr class="panelled whitebg">
					<th>Date</th>
					<th>Type</th>
					<th>Source</th>
					<th>Order #</th>
					<th>Amount</th>
				</tr>
	<?php
                if($customer_wallet && count($customer_wallet) > 0)
                {

				foreach ( $customer_wallet as $raw )
				{
                $customer_wallet_attributes = $raw['attributes'];
			?>
						<tr class="panelled whitebg">
							<td><?php if(isset($raw['created_at'])) echo date(DATE_FORMAT_ADMIN, strtotime($raw['created_at'])); ?></td>
							<td><?php if(isset($customer_wallet_attributes['transaction_type']['option'])) echo $customer_wallet_attributes['transaction_type']['option']; ?></td>
							<td><?php if(isset($customer_wallet_attributes['wallet_source']['option'])) echo $customer_wallet_attributes['wallet_source']['option']; ?></td>
							<td><?php if(isset($customer_wallet_attributes['order_id']['detail']['attributes']['order_number'])) echo $customer_wallet_attributes['order_id']['detail']['attributes']['order_number']; else echo '-'; ?></td>

							<td>
								<?php 
										if(isset($customer_wallet_attributes['transaction_type'])) 
										{
											if($customer_wallet_attributes['transaction_type']['value']=="credit" || $customer_wallet_attributes['transaction_type']['value']=="refund")
											{
												if(isset($customer_wallet_attributes['credit']))
													echo $customer_wallet_attributes['credit'];
											}
											if($customer_wallet_attributes['transaction_type']=="debit")
											{
												if(isset($customer_wallet_attributes['debit']))
													echo $customer_wallet_attributes['debit'];
											}
										}	
								?></td>
						</tr>
	<?php 
				}
		}
		else 
		{
	?>
				<tr class="panelled whitebg">
					<td colspan="4">No Records Found</td>
				</tr>
				{{--	<section class="error404-Section lightgreybg">
						<div class="container">
							<div class="row">
								<div class="col-sm-12 m-sm-auto col-md-12 m-md-auto col-lg-12 m-lg-auto">
									<div class="error404img">
										<img class="img-responsive" src="{{url('/')}}/public/web/img/error404.png" alt="error404" width="309">
									</div>
									<div class="error404content text-center">
										<h2>No Wallet Transactions Found</h2>
										<p>We are sorry but the Wallet Transactions you are looking for does not exist.<br>You could return to the <a href="{{url('/')}}">homepage</a> </p>
									</div>
									
								</div>
							</div>
						</div>
					</section>--}}
	<?php 
		}
	?>

</table>