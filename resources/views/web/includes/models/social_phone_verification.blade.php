
@section("social_phone_verfication")


<!--social_phone_verficationmodal Modal -->





<!--Phone Verification Modal -->
<div class="modal fade social_phone_verficationmodal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Phone Number Verification</h3>
			<input type="hidden" name="phone_number" id="phone_number" />
			<input type="hidden" name="social_entity_id" id="social_entity_id" />
			<input type="hidden" name="social_verification_token" id="social_verification_token" />
			<input type="hidden" name="social_phone_number_verification" id="social_phone_number_verification" />
			  <input id="social_url" name="url"	type="hidden" value="<?php echo URL::to('/'); ?>">

			 <div id="error_msg_social_phone_verification" class="help-block text-left animated fadeInDown hide" style="color:red"></div>
			
			<p class="small-brief">Mobile Number verification is required to place order*</p>
			<br />
			
			<div class="verifyCode">
			
				<div class="col-12">
					<div class="row">
						<div class="fluid-label-inline col-12">
							<input id="phone" class="phone_number" name="phone"  type="text" placeholder="Phone Number ( +000-00000000 ) " />
						</div>
						
					</div>
				</div>
				
				<div class="forgotWrap">
					<p class="text-center"><a href="javascript:void(0)" class="sendcode" >Send Code</a></p>
				</div>
				
			<p class="small-brief-link">4 digit code sent to your phone number <span class="social_phone_number"></span></p>
			<br />
			
				
				<div class="col-12">
					<div class="row">
						<div class="fluid-label-inline col-3">
						  <input id="social_tel1" name="social_tel1"  type="tel" value="" maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="social_tel2" name="social_tel2"  type="tel" value="" maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="social_tel3" name="social_tel3"  type="tel" value="" maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="social_tel4" name="social_tel4"  type="tel" value="" maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
					</div>
				</div>
				<!--
				<div class="forgotWrap">
					<p class="text-center"><a href="#" class="resend" >Resend Code</a></p>
				</div>
				-->
				<div class="submitBtnWrap">
					<input type="button" value="Done" name="" class="phone_verfication social_phone_verfication"/>
				</div>
			</div>
		  </div>
    </div>
  </div>
</div>



@show