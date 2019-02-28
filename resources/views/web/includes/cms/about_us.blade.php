
<div class="d-flex align-items-center about-popup-nav">
				<ul class="clearfix justify-content-start nav nav-tabs" role="tablist">
					<?php 
							if(isset($about_business[0]))
							{
								$a=1;
								foreach($about_business as $about_business_attributes ) 
								{
					?>
									<li role="presentation"><a href="#aboutTab-<?php echo $a;?>" class="nav-link <?php if($a==1 ) echo ' active'; ?>" aria-controls="aboutTab-<?php echo $a;?>" role="tab" data-toggle="tab"><?php echo $about_business_attributes['title'] ?></a></li>
					
					<?php 
									$a++;
								}
							}
					?>
			
								</ul>
								<!--
				<div class="shop-now-btn justify-content-between">
					<a href="#">Shop Now</a>
				</div>
				-->
			</div>
			<!-- Tab panes -->
			<div class="tab-content">
			
				<?php 
						if(isset($about_business[0]))
						{
							$a=1; 
							foreach($about_business as $about_business_attributes ) 
							{
							
				?>
									<div role="tabpanel" class="tab-pane in <?php if($a==1 ) echo ' active'; ?> " id="aboutTab-<?php echo $a;?>">
											<div class="aboutPopupHeader text-center">
												<h2><?php echo $about_business_attributes['sub_title'] ?></h2>
												<p><?php echo $about_business_attributes['description'] ?></p>
											</div>
										<div class="aboutPopupBody">
											<div class="row">
											
												<?php 
												
														foreach ( $about_business_attributes ['about_business_items'] as $about_business_items_attributes )
														{
												?>
												
																<div class="col-md-4 text-center">
																	<div class="roundBg">
																		<img src="<?php 
							
															if(isset($about_business_items_attributes['gallery'][0]['thumb']))
															{ 
																	$handle = @fopen($about_business_items_attributes['gallery'][0]['thumb'], "r");
																	if(strpos("$handle", "Resource id") !== false)
																	{
																			 
																			echo $about_business_items_attributes['gallery'][0]['thumb']; 
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
							
							
															?>" class="img-responsive" alt="img"/>
																	</div>
																	<h4><?php if(isset($about_business_items_attributes['title'])) echo $about_business_items_attributes['title']; ?></h4>
																	<p><?php if(isset($about_business_items_attributes['description'])) echo $about_business_items_attributes['description']; ?></p>
																</div>
												<?php 
														}
												?>
												
																	
											</div>
										</div>
									</div>
				
				<?php 
									$a++;
							}
						}
				?>
					
					
				
				
				
				<div role="tabpanel" class="tab-pane" id="aboutTab-4">Where We Deliver</div>
			</div>