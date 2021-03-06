<!DOCTYPE html>
<html>

<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>AdminDesigns - A Responsive HTML5 Admin UI Framework</title>
  <meta name="keywords" content="HTML5 Bootstrap 3 Admin Template UI Theme" />
  <meta name="description" content="AdminDesigns - A Responsive HTML5 Admin UI Framework">
  <meta name="author" content="AdminDesigns">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font CSS (Via CDN) -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
  
  <!-- Marterial CSS -->
  <link rel="stylesheet" type="text/css" href="assets/fonts/material-design-icons/css/material-design-iconic-font.min.css"/><!--[if lt IE 9]>  

  <!-- Font CSS (Via CDN) -->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>

  <!-- Theme CSS -->
  <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">

  <!-- Admin Forms CSS -->
  <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/img/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

<body class="external-page external-alt sb-l-c sb-r-c">

  <!-- Start: Main -->
  <div id="main" class="animated fadeIn">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

      <!-- Begin: Content -->
      <section id="content">

        <div class="admin-form theme-primary mw600" style="margin-top: 3%;" id="register">

          <!-- Registration Logo -->
          <div class="row table-layout">
            <a href="dashboard.html" title="Return to Dashboard">
              <img src="assets/img/logos/logo.png" title="AdminDesigns Logo" class="center-block img-responsive" style="max-width: 275px;">
            </a>
          </div>

          <!-- Registration Panel/Form -->
          <div class="panel mt10">

            <form method="post" action="/" id="contact">
              <div class="panel-body bg-light p25 pb15">


                <!-- Social Login Buttons -->
                <div class="section row hidden">
                  <div class="col-md-4">
                    <a href="#" class="button btn-social facebook span-left btn-block">
                      <span>
                        <i class="fa fa-facebook"></i>
                      </span>Facebook</a>
                  </div>
                  <div class="col-md-4">
                    <a href="#" class="button btn-social twitter span-left btn-block">
                      <span>
                        <i class="fa fa-twitter"></i>
                      </span>Twitter</a>
                  </div>
                  <div class="col-md-4">
                    <a href="#" class="button btn-social googleplus span-left btn-block">
                      <span>
                        <i class="fa fa-google-plus"></i>
                      </span>Google+</a>
                  </div>
                </div>


                <!-- Divider -->
                <div class="section-divider mv30 hidden">
                  <span>OR</span>
                </div>

                <div class="section row">
                  <div class="col-md-6">
                    <label for="firstname" class="field prepend-icon">
                      <input type="text" name="firstname" id="firstname" class="gui-input" placeholder="First name...">
                      <label for="firstname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="col-md-6">
                    <label for="lastname" class="field prepend-icon">
                      <input type="text" name="lastname" id="lastname" class="gui-input" placeholder="Last name...">
                      <label for="lastname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->
                </div>
                <!-- end .section row section -->

                <div class="section">
                  <label for="email" class="field prepend-icon">
                    <input type="email" name="email" id="email" class="gui-input" placeholder="Email address">
                    <label for="email" class="field-icon">
                      <i class="fa fa-envelope"></i>
                    </label>
                  </label>
                </div>
                <!-- end section -->

                <div class="section hidden">
                  <div class="smart-widget sm-right smr-120">
                    <label for="username" class="field prepend-icon">
                      <input type="text" name="username" id="username" class="gui-input" placeholder="Choose your username">
                      <label for="username" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                    <label for="username" class="button">.envato.com</label>
                  </div>
                  <!-- end .smart-widget section -->
                </div>
                <!-- end section -->


             

                <div class="section">
                  <label for="password" class="field prepend-icon">
                    <input type="password" name="password" id="password" class="gui-input" placeholder="Create a password">
                    <label for="password" class="field-icon">
                      <i class="fa fa-unlock-alt"></i>
                    </label>
                  </label>
                </div>
                <!-- end section -->

                <div class="section">
                  <label for="confirmPassword" class="field prepend-icon">
                    <input type="password" name="confirmPassword" id="confirmPassword" class="gui-input" placeholder="Retype your password">
                    <label for="confirmPassword" class="field-icon">
                      <i class="fa fa-lock"></i>
                    </label>
                  </label>
                </div>
                <!-- end section -->


              </div>

              <div class="panel-footer clearfix">
                <button type="submit" class="button btn-primary mr10 pull-right">Register</button>

                

                <label class="switch block switch-primary mt10 hidden">
                  <input type="checkbox" name="remember" id="remember" checked>
                  <label for="remember" data-on="YES" data-off="NO"></label>
                  <span>Remember me</span>
                </label>
              </div>

            </form>
          </div>
		  
          <!-- Registration Links -->
          <div class="login-links">
            <p>
              <a href="pages_forgotpw(alt).html" class="active hidden" title="Sign In">Forgot Password?</a>
            </p>
            <p>Already registered?
              <a href="pages_login(alt).html" class="active" title="Sign In">Sign in here</a>
            </p>
          </div>


        </div>

      </section>
      <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->

  </div>
  <!-- End: Main -->
  
</body>

</html>
