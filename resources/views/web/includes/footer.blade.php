	

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
						<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal">How it Works</a></li>
						<li><a href="{{ route('mobileapp') }}">Mobile App</a></li>
						<li><a href="#">Refer a Friend</a></li>
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
						<li><a href="#" data-toggle="modal" data-target=".aboutUsmodal" id="deliver-info-model">Delivery Info</a></li>
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

@show