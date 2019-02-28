
@section("phone_verification")

<!--Phone Verification Modal -->
<div class="modal fade pVerfymodal PVerifyModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Phone Number Verification</h3>
			<p class="small-brief">We need your phone number so we can inform you about any delay or problem</p>
			<p class="small-brief-link">4 digit code sent to your phone <span class="phone_number">0012555656548</span></p>
			<input type="hidden" name="phone_number" id="phone_number" />
			<input type="hidden" name="entity_id" id="entity_id" />
			  <input type="hidden" name="url" id="url" value="{!! \URL::current(); !!}" />
			 <div id="error_msg_phone_verification" class="help-block text-left animated fadeInDown hide" ></div>
			<div class="verifyCode">
				<div class="col-12">
					<div class="row">
						<div class="fluid-label-inline col-3">
						  <input id="tel1" name="tel1"  required="required" type="tel"  maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="tel2" name="tel2"  required="required" type="tel"  maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="tel3" name="tel3"  required="required" type="tel"  maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
						<div class="fluid-label-inline col-3">
						  <input id="tel4" name="tel4"  required="required" type="tel"  maxlength="1" pattern="([0-9]|[0-9]|[0-9])"/>
						</div>
					</div>
				</div>
				<div class="forgotWrap">
					<p class="text-center"><a href="#" class="resend" >Resend Code</a></p>
				</div>
				<div class="submitBtnWrap">
					<input type="button" value="Done" name="" class="phone_verfication"/>
				</div>
			</div>
		  </div>
    </div>
  </div>
</div>

@show