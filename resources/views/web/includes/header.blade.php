
	
	@section('header')
	
<!-- Header -->	
	<header id="inner-header">
		@include("web/includes/secondry_header")
		
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
	
	