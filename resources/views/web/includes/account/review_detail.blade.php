<?php 
						
						//print_r($order_detail) ; exit; 
						?>
								<?php 
								
										if(isset($order_detail['star_rating']['option'])) 
										{
								?>	
											
												<div class="col-md-6 col-lg-4 singleReview">
													<div class="starRating">
														<?php 
																$score = $order_detail['star_rating']['option'];
																$less  = 5 - $order_detail['star_rating']['option']; 
																for ( $i=1;$i<=$score;$i++) 
																{
														?>
																	<span class="icon-tt-star-fill-icon"></span>
														<?php 
																}
														?>
														<?php 
																for ( $i=1;$i<=$less;$i++) 
																{
														?>
																	<span class="icon-tt-star-icon"></span>
														<?php 
																}
														?>
															(<?php echo $order_detail['star_rating']['option']; ?>)		
													</div>
													<p><?php echo $order_detail['reviews']; ?></p>
												</div>
											
								<?php 
										}
										else
										{
								?>
												<div class="star-rating">
													<span class="tt icon-tt-star-icon" data-rating="1"></span>
													<span class="tt icon-tt-star-icon" data-rating="2"></span>
													<span class="tt icon-tt-star-icon" data-rating="3"></span>
													<span class="tt icon-tt-star-icon" data-rating="4"></span>
													<span class="tt icon-tt-star-icon" data-rating="5"></span>
													<input type="hidden" name="whatever1" class="rating-value" value="0">
												</div>
											
												<div class="fluid-label">
													<textarea id="review" class="review" placeholder="Review*"></textarea>
													
												</div>
												<div class="submitBtnWrap">
													<input name="rating" class="rating" id="rating" type="hidden" />
													<input id="order_id" name="order_id" class="order_id"  type="hidden" value="<?php if(isset($order_detail['entity_id'])) echo $order_detail['entity_id']; ?>" />
													<input id="save_review" type="button" value="Submit your review" name="" class="signBtn"/>
												</div>
								<?php 
										}
								?>