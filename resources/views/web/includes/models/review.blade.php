

@section("review")


<div class="modal fade reviewmodal reviewModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3><?php if(isset($recipe['title'])) echo $recipe['title']; ?></h3>	
			<div id="error_msg_review_verification" class="help-block text-left animated fadeInDown hide" style="color:red"></div>
			
			<div class="star-rating">
				<span class="tt icon-tt-star-icon" data-rating="1"></span>
				<span class="tt icon-tt-star-icon" data-rating="2"></span>
				<span class="tt icon-tt-star-icon" data-rating="3"></span>
				<span class="tt icon-tt-star-icon" data-rating="4"></span>
				<span class="tt icon-tt-star-icon" data-rating="5"></span>
				<input type="hidden" name="whatever1" class="rating-value" value="0">
			</div>
		
				<input name="rating" class="rating" id="rating" type="hidden" />
				<input name="product_id" class="product_id" id="product_id" type="hidden" value="<?php if(isset($recipe['entity_id'])) echo $recipe['entity_id']; ?>" />
				<input name="recipe_url" class="recipe_url" id="recipe_url" type="hidden" value="<?php echo URL::to('/').'/recipe_detail?entity_type_id='.$recipe['entity_type_id'].'&product_code='.$recipe['product_code']; ?>" />
				
				
				<div class="fluid-label">
				  <textarea name="review" id="review" class="review" placeholder="Review*"></textarea>
				  <label>Review*</label>
				</div>
				<div class="submitBtnWrap">
					<input id="recipe_save_review" type="submit" value="Submit your review" name="" class="reviewBtn"/>
						
				</div>

		  </div>
    </div>
  </div>
</div>

@show