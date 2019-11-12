@section("editYourDetailmodal")


<!--Edit Detail Modal -->
<div class="modal fade editYourDetailmodal editYourDetailModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Account Details</h3>
			<form>
				<input type="hidden" name="platform_type" id="platform_type" value="{!! isset($user['auth']['platform_type']) ? $user['auth']['platform_type'] : "" !!}" />
				<div class="alert-message" id="account_response">
				</div>
				
				<div class="row">
					<div class="col-md-6 cuspad">
						<div class="fluid-label">
						  <input id="account_first_name" value="{!! isset($user['attributes']['first_name']) ? $user['attributes']['first_name'] : "" !!}" name="account_first_name" type="text" required="required" class="form-control" placeholder="First Name" />
						  <label>First Name</label>
						</div>
					</div>
					<div class="col-md-6 cuspad">
						<div class="fluid-label">
						  <input id="account_last_name" value="{!! isset($user['attributes']['last_name']) ? $user['attributes']['last_name'] : "" !!}"  name="account_last_name" type="text" required="required" class="form-control" placeholder="Last Name" />
						  <label>Last Name</label>
						</div>
					</div>

					<div class="col-md-12">
						<div class="fluid-label">
						  <input id="account_mobile_no" name="account_mobile_no" type="text" value="{!! isset($user['auth']['mobile_no']) ? $user['auth']['mobile_no'] : "" !!}" required="required" class="form-control" placeholder="Mobile Number" />
						  <label>Mobile Number</label>
						</div>
					</div>

				</div>
				<!--<div class="clearfix forgotWrap">
					<div class="checkbox">
						<label class="checkbox-bootstrap">                                        
							<input id="term_and_condition" name="term_and_condition" type="checkbox" required="required" />             
							<span class="checkbox-placeholder"></span>           
							<p>I agree with <a target="_blank" href="<?php echo url('/').'/cms/terms_and_condition' ?>">Terms &amp; Conditions </a></p>
						</label>
					</div>
				</div>-->
				<div class="submitBtnWrap">
					<input id="save_your_account" type="button" value="Save" name="" class="save_your_account"/>
				</div>
			</form>
		  </div>
    </div>
  </div>
</div>

@show