
<?php 
			
		if(isset($slots))
		{
			if(count($slots) >=1 ) 
			{
				foreach ($slots as $slotsAttributes ) 
				{

				    if(isset($slotsAttributes['status']['value']) && $slotsAttributes['status']['value'] != 1){
                        continue;
					}
						
?>
					<option value="<?php echo $slotsAttributes['entity_id'];?>" ><?php echo date("G:i a",strtotime($slotsAttributes['start_time']))." - ".date("G:i a ",strtotime($slotsAttributes['end_time'])); ?>   </option>
<?php 					
				}
			}
			else
			{
				
?>
					<option value="" >NA</option>

<?php 
			}
			
		}
		else
		{
?>
					<option value="" >NA</option>
<?php 
		}
?>