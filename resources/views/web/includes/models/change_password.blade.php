
@section("change_password")
	
<!--Change Password Modal -->
<div class="modal fade chgPassmodal chgPassModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Change Password</h3>	
			<div class="" id="account_change_response"></div>
			<form role="form">
				
				<div class="fluid-label">
				  <input id="current_password"name="current_password" type="password" placeholder="Current Password" />
				  <label>Current Password</label>
				</div>
				<div class="fluid-label">
				  <input id="new_password" name="new_password" type="password" placeholder="New Password" />
				  <label>New Password</label>
				</div>
				<div class="fluid-label">
				  <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" />
				  <label>Confirm Password</label>
				</div>
				<div class="submitBtnWrap">
					<input id="change_your_account_password" type="button" value="Save" name="" class="signBtn"/>
				</div>
			</form>
		  </div>
    </div>
  </div>
</div>

@show