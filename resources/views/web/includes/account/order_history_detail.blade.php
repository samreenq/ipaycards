





<table width="100%" class="table table-striped table-hover table-responsive2">
	<tr class="dashboard-header">
		<th>Order Date</th>
		<th>Order Number</th>
		<th>Status</th>
		<th>Total</th>
		<th>Review/Rating</th>
		<th>View</th>
	</tr>
	
	<?php
		if($order && count($order) > 0)
		{
			foreach ( $order as $orderAttributes ) 
			{
				$created_at = \App\Libraries\CustomHelper::displayDateTime($orderAttributes['created_at']);
		?>		<input type="hidden" class="order_id" value="2" />
					<tr class="panelled whitebg">
						<td><?php if(isset($orderAttributes['created_at'])) echo  $created_at; ?></td>
						<td><?php if(isset($orderAttributes['order_number'])) echo $orderAttributes['order_number'] ?></td>
						<td><?php if(isset($orderAttributes['order_status']['value']) ) echo $orderAttributes['order_status']['value'] ; ?></td>
						<td><?php if(isset($orderAttributes['grand_total']) ) echo $orderAttributes['grand_total']?></td>

						<td>
								<input type="hidden" class="order_id" value="<?php if(isset($orderAttributes['entity_id'])) echo $orderAttributes['entity_id'] ?>" />
						<?php if(isset($orderAttributes['reviews']) && !empty($orderAttributes['reviews'])){ ?>
								<a href="#"  data-toggle="modal"  data-target=".orderReviewmodel" class="review reviewMore">Reviewed</a>
                            <?php }else{ ?>
                            <?php if(isset($orderAttributes['order_status']['detail']['keyword']) && trim($orderAttributes['order_status']['detail']['keyword']) == 'delivered_approved' ){ ?>
							<a href="#" class="review reviewMore">Write a review</a>
						<?php }  }?>
						</td>
						<td align="center">
								<input type="hidden" class="order_id" value="<?php if(isset($orderAttributes['entity_id'])) echo $orderAttributes['entity_id'] ?>" />
								
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