





<table width="100%" class="table table-striped table-hover table-responsive2">
	<tr class="dashboard-header">
		<th>Order Date</th>
		<th>Order Number</th>
		<th>Status</th>
		<th>Total</th>
		{{--<th>Review/Rating</th>--}}
		<th>View</th>
	</tr>
	
	<?php
		if($order && count($order) > 0)
		{
			foreach ( $order as $raw )
			{
    			$orderAttributes = $raw['attributes'];
				$created_at = \App\Libraries\CustomHelper::displayDateTime($raw['created_at']);
		?>		<input type="hidden" class="order_id" value="2" />
					<tr class="panelled whitebg">
						<td><?php if(isset($raw['created_at'])) echo  $created_at; ?></td>
						<td><?php if(isset($orderAttributes['order_number'])) echo $orderAttributes['order_number'] ?></td>
						<td><?php if(isset($orderAttributes['order_status']['value']) ) echo $orderAttributes['order_status']['value'] ; ?></td>
						<td><?php if(isset($orderAttributes['grand_total']) ) echo "AED ";echo $orderAttributes['grand_total']?></td>


						<td align="center">
								<input type="hidden" class="order_id" value="<?php if(isset($raw['entity_id'])) echo $raw['entity_id'] ?>" />
								
								<a href="#" class="reorder" data-toggle="modal" data-target=".orderDetailmodal"  ><span class="icon-tt-more-menu-icon"></span></a>
								<!--<a href="#"><span class="icon-tt-delet-icon"></span></a>-->
						</td>
					</tr>
	<?php 
			}
		}else{
		    ?>
	<tr class="panelled whitebg">
		<td colspan="6">No Records Found</td>
	</tr>
	<?php }
	?>

</table>