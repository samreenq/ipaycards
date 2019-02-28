
@section("refer_friend")

<!--Signin Modal -->
<div class="modal fade referfriendmodal signinModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Refer a Friend</h3>
			<center>
				<div class="fbBtnWrap">
								
				</div>
			</center>
				<?php 
					//&& !isset($_SESSION['fbUserProfile'])
				?>
				
				<input id="refer_entity_id" name="refer_entity_id" type="hidden"  value="<?php if (Session::has('users')  ){$users = Session::get('users'); echo $users[0]['entity_id'];}else{ echo "";}?>" />
				
				<div class="signinError">  </div>
				<div class="fluid-label">
				  <input id="refer_email" name="refer_email" type="email" placeholder="Email" />
				  <input id="url"	 name="url"	type="hidden" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>">
				  <label>Email</label>
				</div>
				<div class="submitBtnWrap">
					<div class="" > <!-- lodingBtn-->  
						<input style="cursor:pointer" type="submit" value="Start" name="" class="referBtn"/>
					</div>
				</div>
		
		  </div>
    </div>
  </div>
</div>

@show