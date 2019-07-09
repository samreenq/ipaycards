	

	@section('footer')
	<?php
    $cms_flat = new \App\Http\Models\SYSTableFlat('cms');
    $where_condition = 'status = 1';
    $cms_raw = $cms_flat->getDataByWhere($where_condition);
	?>

	<!-- Footer -->
<footer class="footer whitebg">
	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-4">
					<h4 class="light-heading">#{!! APP_NAME !!}</h4>
					<p>A product built to provide, an end to end e-commerce solution, sighting the needs of online marketplace requirements. We want to empower each and every shop owner to have their own presence online.</p>
					<ul class="social-media">
						<li><a href="{!! $general_setting_raw->facebook_url !!}"><span class="icon-tt-facebook-icon"></span></a></li>
						<li><a href="{!! $general_setting_raw->twitter_url !!}"><span class="icon-tt-twitter-icon"></span></a></li>
						<li><a href="{!! $general_setting_raw->instagram_url !!}"><span class="icon-tt-instagram-icon"></span></a></li>
						<li><a href="{!! $general_setting_raw->youtube_url !!}"><span class="icon-tt-youtube-icon"></span></a></li>
					</ul>
				</div>
				<div class="ftrlinks col-sm-4 col-md-3 col-lg-2 ml-lg-auto">
					<h4>Shop With Us</h4>
					<ul>
						<!--<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal">How it Works</a></li>-->
						<li><a href="{{ route('mobileapp') }}">Mobile App</a></li>

                        <?php

                        if (isset($_SESSION['fbUserProfile']) )
                        {
                        ?>
						<li><a href="#" data-toggle="modal" data-target=".referfriendmodal" >@lang('web.navbar_menu_name_3')</a></li>

                        <?php
                        }

                        if (Session::has('users')  )
                        {

                        ?>
						<li><a href="#" data-toggle="modal" data-target=".referfriendmodal" >@lang('web.navbar_menu_name_3')</a></li>


                        <?php
                        }
                        if (!Session::has('users') && !isset($_SESSION['fbUserProfile']) )
                        {

                        ?>

						<li><a href="#" data-toggle="modal" data-target=".siginmodal" class="tooltip1" >@lang('web.navbar_menu_name_3')</a></li>

                        <?php
                        }


                        ?>
					</ul>
				</div>
				<div class="ftrlinks col-sm-4 col-md-2 col-lg-2">
					<h4>Info</h4>
					<ul>
						<?php if($cms_raw){
						    foreach($cms_raw as $cms){
						    ?>
								<li><a href="{!! url('/').'/cms/'.$cms->slug !!}">{!! $cms->title !!}</a></li>
							<?php }
							} ?>
					</ul>
				</div>
				<div class="ftrlinks col-sm-4 col-md-1 col-lg-2">
					<h4>Help</h4>
					<ul>
						<!--<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal" id="deliver-info-model">Delivery Info</a></li>-->
						<li><a href="{{ route('faq') }}">FAQs</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<p>&copy; Copyright 2018 {!! APP_NAME !!}. All rights reserved.</p>
		</div>
	</div>
</footer>
	<!-- Start of salmancubix Zendesk Widget script -->
	<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=cb6b19b8-fca9-402f-8523-79d21b509697"> </script>
	<!-- End of salmancubix Zendesk Widget script -->

	<!-- Google Analytics -->
	<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('send', 'pageview');
	</script>
	<!-- End Google Analytics -->
@show