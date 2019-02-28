

<?php
				foreach( $testimonials as $testimonials_attributes ) 
				{
?>
					<div class="col-md-6 col-sm-12">
											<img width="554px" height="394px" src='<?php 
											
																								if(isset($testimonials_attributes['gallery'][0]['file']))
																								{ 
																										$handle = @fopen($testimonials_attributes['gallery'][0]['file'], "r");
																										if(strpos("$handle", "Resource id") !== false)
																										{
																												 
																												echo $testimonials_attributes['gallery'][0]['file']; 
																										} 
																										else 
																										{ 
																												echo url("/")."/public/web/img/image_not_found_all.jpg";
																										} 
																								}  
																								else
																								{
																										echo url("/")."/public/web/img/image_not_found_all.jpg"; 
																								}
											
											
											
											
											
											
																				?>' class="img-responsive" width="554"/>
					</div>
					<div class="col-md-6 col-sm-12">
							<span class="icon-tt-coma-icon test-coma"></span>
							<p><?php echo $testimonials_attributes['description']; ?></p>
							<h4><?php echo $testimonials_attributes['name']; ?></h4>
					</div>				
<?php 
				}
?>