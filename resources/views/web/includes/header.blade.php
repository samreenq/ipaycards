
	
	@section('header')
	
<!-- Header -->	
	<header id="inner-header">
		<div class="container pageNavWrap">
			<div class="greedy-nav page-nav animationHover">
				<button type="buttonpull-right">More</button> 
				<ul class=" menus visible-links">
						<div style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);-moz-transform: translate(-50%, -50%);-ms-transform: translate(-50%, -50%);-o-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" id="LoadingImage" align="center" style="display: none">
							<div class="floatingCirclesG">
								<div class="f_circleG frotateG_01"></div>
								<div class="f_circleG frotateG_02"></div>
								<div class="f_circleG frotateG_03"></div>
								<div class="f_circleG frotateG_04"></div>
								<div class="f_circleG frotateG_05"></div>
								<div class="f_circleG frotateG_06"></div>
								<div class="f_circleG frotateG_07"></div>
								<div class="f_circleG frotateG_08"></div>
							</div>						  
						</div>
				</ul>
				<ul class='hidden-links hidden'></ul>
			</div>
		</div>
		
		<div class="container">
			<div class="inner-banner">
				<div class="row">
					<div class="bannerContWrap">
						<form class="form-horizontal" role="form" method="GET" action="{{ url('/product') }}">
							<div class=" toolbar-search">
								<input class="search-bar" required="requiredform-control"  name="title" placeholder="Search healthy food and more" type="text" value="">
								<button class="search-btn"  type="submit"><span class="icon-tt-right-arrow"></span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</header>	
	
	
	@show
	
	