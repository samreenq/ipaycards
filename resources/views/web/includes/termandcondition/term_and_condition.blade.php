

	
	<?php 
	//print_r($termAndCondition); exit; 
			$a=1;
			if(isset($termAndCondition))
			{
				if(count($termAndCondition)>1)
				{
					foreach($termAndCondition as $attribute ) 
					{
				
	?>
						<div role="tabpanel" <?php if($a==1 ) echo 'class=" tab-pane active" aria-expanded="true"'; else echo 'class="tab-pane"';?> id="<?php echo $attribute['attributes']['slug']; ?>">
							<div class="termandcond-right-side">
								<div class="termandcond-right-header">
									<h4><?php if(isset($attribute['attributes']['title'])) echo $attribute['attributes']['title']; ?></h4>
								</div>
								<div class="termandcond-right-txt-bg">
									<p class="date-update">Last Updated: August 9, 2017</p>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>							
								</div>
							</div>
						</div>
		  
	<?php 
					$a++;
					}
				}
				else
				{
	?>
						<div role="tabpanel" <?php if($a==1 ) echo 'class=" tab-pane active" aria-expanded="true"'; else echo 'class="tab-pane"';?> id="<?php if(isset($attribute['attributes']['slug']))echo $attribute['attributes']['slug']; ?>">
							<div class="termandcond-right-side">
								<div class="termandcond-right-header">
									<h4>No Data Found</h4>
								</div>
								
							</div>
						</div>
		  
	<?php 
				}
			}
	?>