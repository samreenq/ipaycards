
@section("signin")

<!--Signin Modal -->
<div id="signinmodal" class="modal fade siginmodal signinModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button id="signinbtn" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<h3>Sign In</h3>
			  <div class="signinError" >  </div>
			<div class="fbBtnWrap">
					<?php
							if(Session::has('message2'))
							{
								//$message = Session::get('message2'); 
								//echo "<center>".$message[0]."</center>";
								
							}
							else
							{
								//if(isset($_SESSION['loginurl']))
								//{
					?>
						{{--<a href="javascript:void(0);" class="contFb" onclick="facebookLogin()">Connect With Facebook</a>--}}
                        <a href="{!! url('/').'/login/facebook' !!}" class="contFb" >Connect With Facebook</a>
					<?php
								//}
							}
							//print_r($_SERVER);								
					?>
							
							
			</div>

			  <div class="g-signin2" data-theme="dark" data-width="445px" data-height="50px" onclick="gmailLogin()"></div>

				<div class="fluid-label">
				  <input id="login_id" name="login_id" type="email" placeholder="Email" />
				  <input id="url"	 name="url"	type="hidden" value="<?php  echo url()->full(); ?>">
				  <label>Email</label>
				</div>
				<div class="fluid-label">
				  <input id="password" name="password" type="password" placeholder="Password" />
				  <label>Password</label>
				</div>
				<div class="d-sm-flex forgotWrap">
					<p class="mr-auto align-items-start"><a class="open_sigupmodal">Register New User?</a></p>
					<p class="align-items-end"><a class="open_forPassmodal" >Forgot Password?</a></p>
				</div>
				<div class="submitBtnWrap">
					<div class="btnLoader" > <!-- lodingBtn-->  
						<input type="submit" value="Login" name="" style="cursor:pointer;" class="signBtn signIn"/>
					</div>
				</div>
		
		  </div>
    </div>
  </div>
</div>

@show
