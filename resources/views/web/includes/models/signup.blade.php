
@section("signup")


<!--Signup Modal -->




<div class="modal fade signupmodal signupModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button id="sigupbtn" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="icon-tt-close-icon"></span>
        </button>
		  <div class="modal-body">
			<div class="stepwizard">
				<div class="stepwizard-row setup-panel">
				  <div class="stepwizard-step">
					<a href="#step-1" type="button" class="btn btn-circle btn-visible"></a>
				  </div>
				  <div class="stepwizard-step">
					<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"></a>
				  </div>
				</div>
			 </div>


				<div class="row setup-content" id="step-1">
					<div class="col-md-12">
					    <h3>Account</h3>
						<div class="signup_error" style=""></div>
					    <p class="small-brief">Sign up to {!! APP_NAME !!} with your favourite social media account or using your email ID. </p>
						<div class="fbBtnWrap">

						</div>

						<a href="javascript:void(0);"  data-id="facebook" class="contFb socialBtn" >Connect With Facebook</a>
						<a href="javascript:void(0);"  data-id="google" class="contGM socialBtn" >Connect With Google</a>

						{{--<div class="g-signin2" data-theme="dark" data-width="445px" data-height="50px" onclick="gmailLogin()"></div>--}}
						<div class="fluid-label">
						  <input id="email" name="email" type="email" required="required" class="form-control" placeholder="Email" />
						   <input id="url"  name="url"	type="hidden" value="<?php  echo url()->current(); ?>">
							<input id="url1"  name="url1"	type="hidden" value="<?php echo url('/').'/signin_step1'; ?>">

						 <label>Email</label>
						</div>
						<div class="fluid-label">
						  <input id="password2" name="password" type="password" required="required" class="form-control" placeholder="Password" />
						  <label>Password</label>
						</div>
						<div class="clearfix forgotWrap">
							<p>Already a member? <a class="open_siginmodal" >Login</a></p>
						</div>
						<div class="submitBtnWrap">
							<button class="nextBtn nextBtn1" style="cursor:pointer;" type="button">Next</button>
						</div>
					</div>
				</div>
				<div class="row setup-content" id="step-2">
					<div class="col-md-12">
					    <h3>Profile</h3>
						<p class="small-brief">Please create your Profile to help us offer you promotions in future.  </p>
					    <div class="fbBtnWrap">
							<?php
									if(Session::has('message1'))
									{
										//$message = Session::get('message1'); 
										//echo "<center>".$message[0]."</center>";
									}
									else
									{
										
										//if(isset($_SESSION['loginurl']))
											//{

							?>
								<a href="javascript:void(0);" class="contFb" onclick="facebookLogin()">Connect With Facebook</a>
							<?php
											//}
									}
							?>
							
						</div>

						<div class="signupError" style="" >  </div>
					
					    <div class="row">
							<div class="col-md-6 cuspad">
								<div class="fluid-label">
								  <input id="first_name" name="first_name" type="text" required="required" class="form-control" placeholder="First Name" />
								  <label>First Name</label>
								</div>
							</div>
							<div class="col-md-6 cuspad">
								<div class="fluid-label">
								  <input id="last_name" name="last_name" type="text"  class="form-control" placeholder="Last Name" />
								  <label>Last Name</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="fluid-label">
								  <input id="mobile_no" name="mobile_no" type="text" required="required" class="form-control"  placeholder="Mobile Number (+000-00000000)" />
								  <label>Mobile Number</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="fluid-label">
								  <input id="refer_friend_code_applied" name="refer_friend_code_applied" type="text"  class="form-control" placeholder="Referral Code (Optional)" />
								  <label>Referral Code</label>
								</div>
							</div>
						</div>
						<div class="clearfix forgotWrap">
							<div class="checkbox">
								  <label class="checkbox-bootstrap">                                        
									  <input id="term_condition" name="term_condition" required="required"  class="form-control" type="checkbox" />             
									  <span class="checkbox-placeholder"></span>           
									  <p>I agree with <a target="_blank" href="<?php echo url('/').'/cms/terms_of_services' ?>">Terms &amp; Conditions </a></p>
								  </label>
							 </div>
						</div>
						<div class="submitBtnWrap">
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<button id="signup"  class="nextBtn" type="submit" >Sign Up</button>
						</div>

					</div>
				</div>
				
			  
		  </div>
    </div>
  </div>
</div>



@show