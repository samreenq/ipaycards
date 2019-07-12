
@section("forget_password")
	
<!--Change Password Modal -->
<div class="modal fade forPassmodal chgPassModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Forgot Password</h3>	
			<div class="row" id="account_forget_response"></div>
			<form role="form">
				
				<div class="fluid-label">
				  <input id="current_email"name="current_email" type="email" placeholder="Email" />
				  <label>Email</label>
				</div>
				<div class="submitBtnWrap">
					<input id="forget_your_account_password" type="button" value="Submit" name="" class="signBtn"/>
				</div>
			</form>
		  </div>
    </div>
  </div>
</div>

@show