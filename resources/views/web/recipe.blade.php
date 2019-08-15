


@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")

					<link href="<?php echo url('/').'/public/web/css/component.css';?>" rel="stylesheet"/>
			
	@endsection


	@section("navbar")
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@include("web/includes/cartbar")
	@endsection

	@section('header')
			<!-- Header -->	
	<header id="detail-header">
		<div class="flyout-overlay"></div>
		<div class="fly-nav-inner">
			<div class="container">
				<button class="dropdown-toggle" data-toggle="dropdown">More <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
				<div class="dropdown-menu mega-dropdown-menu">
					<ul class="row">
						<li class="col-sm-12">
							
							<ul class=" menus sidebar__inner" role="tablist">
										<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingImage" align="center" style="display: none">
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
						</li>
					</ul>
				</div>
			</div>
		</div>
	
	
		<div class="container pageNavWrap">
			<div class="greedy-nav page-nav">
				 <button type="button" class="pull-right">More</button> 
				<ul class="menus visible-links">
					<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingImage" align="center" style="display: none">
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
	</header>
			
	@endsection
	
	
	@section("recipe")		

			<div class="feature-bg" style="background:url(<?php echo url('/').'/public/web/img/product/recipe-feature-img-1.jpg';?>);">
			</div>
			<section class="recipe-chef-Section ">
				<div class="container">
					<div class="detailHeader">
						<div class="row">
							<div class="col-md-12 col-lg-6 pr-lg-0">
								<img src="<?php echo $recipe['image']; ?>" alt="img" width="573px" height="368px" class="recipeBigImg img-responsive"/>
							</div>
							<div class="col-md-12 col-lg-6 pl-lg-0">
								<div class="recipeWholeDetail whitebg">
									<div class="col-md-10 m-auto">
										<h2><?php echo $recipe['title']; ?></h2>
										<p><?php if(isset($recipe['description'])) echo $recipe['description']; ?></p>
										<a href="{{ route('recipe_detail') }}<?php echo '?entity_type_id='.$recipe['entity_type_id'].'&product_code='.$recipe['product_code'];?>" class="reviewMore">View Recipe</a>
									</div>
								</div>
							</div>
						</div>
						<div class="allChefRecipe">
								<div class="chefUpperFilter mb30">
									<div class="row">
										<div class="col-md-3">
											<p>
											  <h4 for="amount">Price</h4>
											   <input type="hidden" id="low_price"  />
												<input type="hidden" id="high_price" />
												<input type="text" id="amount" readonly />
											</p>
											<div id="slider-range"></div>
										</div>
										<input id="searchable_tags" name="searchable_tags" type="hidden" value="" />
										<input id="chef_ids_tags" name="chef_ids_tags" type="hidden" value="" />
										<input id="recipe_serving_tags" name="recipe_serving_tags" type="hidden" value="" />
								
										<div class="col-md-3">
											<h4>Chefs</h4>
											  <ul>
												<?php 
													if(isset($chef_ids_tags))
														foreach($chef_ids_tags as $chef_ids_tags_attributes)
														{
												?>	
															<li><a class="chef_ids_tags search_filter" data-id="<?php if(isset($chef_ids_tags_attributes['id'])) echo $chef_ids_tags_attributes['id'];?>" data-attr="chef_ids_tags"><?php if(isset($chef_ids_tags_attributes['value'])) echo $chef_ids_tags_attributes['value'];?></a></li>
												<?php	
														}
												
												?>
											  </ul>
										</div>
										<div class="col-md-3">
											<h4>Searchable tags</h4>
											<ul>
												<?php 
													if(isset($searchable_tags))
														foreach($searchable_tags as $searchable_tags_attributes)
														{
												?>	
															<li><a class="searchable_tags search_filter" data-id="<?php echo $searchable_tags_attributes['id'];?>" data-attr="searchable_tags"><?php echo $searchable_tags_attributes['value'];?></a></li>
												<?php	
														}
											
												?>
											
											</ul>
										</div>
										<div class="col-md-3 ">
											<h4>Serving</h4>
											<ul>
												<?php 
													if(isset($recipe_serving_tags))
														foreach($recipe_serving_tags as $recipe_serving_tags_attributes)
														{
												?>	
															<li><a class="recipe_serving_tags search_filter" data-id="<?php if(isset($recipe_serving_tags_attributes['value'])) echo $recipe_serving_tags_attributes['value'];?>" data-attr="recipe_serving_tags"><?php if(isset($recipe_serving_tags_attributes['option'])) echo $recipe_serving_tags_attributes['option'];?></a></li>
												<?php	
														}
											
												?>
											
											</ul>
										</div>		
										<div class="productResetBtn col-md-12 text-right mt20">
											<input style="cursor:pointer" type="button" class="reset" value="Reset" />
											<input style="cursor:pointer" type="button" class="search" value="Search" />
										</div>
										
									</div>
								</div>
							
								<div id="recipes"  class="row">
										
											<div 	style="
																position: absolute;
																top: 50%;
																left: 50%;
																margin-top: -50px;
																margin-left: -50px;
																width: 100px;
																height: 100px;
											
														"

													id="LoadingImageRecipes" align="center" style="display: none"
											>
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
								</div>
								<div class="container page_showcase" style="display:none" >
									<nav aria-label="Page navigation" class="clearfix">
										<ul class="pagination cusPagination float-right" id="pagination"></ul>
									</nav>
								</div>
						
						</div>
					</div>
				</div>
			</section>
			
			
	@endsection
	

	
	@section("footer")
		@include("web/includes/footer")
	@endsection

	
	
	
	
	
	{{--  Models   --}}
	

	@section("signin")
		@include("web/includes/models/signin")
	@endsection

	@section("signup")
		@include("web/includes/models/signup")
	@endsection
	
	@section("about_us")
		@include("web/includes/models/about_us")
	@endsection
	
	
	@section("refer_friend")
		@include("web/includes/models/refer_friend")
	@endsection
	
	@section("change_password")
		@include("web/includes/models/change_password")
	@endsection
	
	@section("forget_password")
		@include("web/includes/models/forget_password")
	@endsection
	
	
	
	@section("phone_verification")
		
		@include("web/includes/models/phone_verification")
	@endsection

	@section("social_phone_verification")
		
		@include("web/includes/models/social_phone_verification")
	@endsection

	@section("foot")
		@include("web/includes/foot")
		
		

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<script src="<?php echo url('/').'/public/web/js/jquery.simplePagination.js';?>" type="text/javascript"></script>
		<script>
			
									
			
		$(document).ready(function() {
			
			$(".reset").on("click", function () 
			{ 
				if ($('.search_filter').is('.tag'))
					$(".search_filter").removeClass('tag');
					
				$('#searchable_tags').val('');
				$('#chef_ids_tags').val('');
				$('#recipe_serving_tags').val('');
				
				$('#low_price').val('1');
				$('#amount').val('$1 - $<?php if(isset($price)) echo $price; ?>');
				$('#high_price').val('<?php if(isset($price)) echo $price; ?>');
				
				$( "#slider-range" ).slider({
				  range: true,
				  min: 1 ,
				  max:  <?php if(isset($price)) echo $price; ?>  ,
				  values: [ 1,<?php if(isset($price)) echo $price; ?> ]
				});
				
			}); 
			
			$(".search").on("click", function () { 
			
			
				
				chef_ids_tags = $('#chef_ids_tags').val();
				searchable_tags	 = $('#searchable_tags').val();
				recipe_serving_tags = $('#recipe_serving_tags').val();
				low_price = $('#low_price').val();
				high_price = $('#high_price').val();
				
				if( chef_ids_tags.length !==0 || searchable_tags.length !== 0 || recipe_serving_tags.length  !== 0 || low_price.length !==0 || high_price.length !==0 ) 
				{
					//alert('click');
					limit = 9;
					page = 1; 
					offset = (page  * limit) -  limit;

					recipe_all_list(22,2,"<?php if(isset($chef[0]['attributes']['name'])) echo  $chef[0]['attributes']['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",chef_ids_tags,searchable_tags,recipe_serving_tags,low_price,high_price,offset,limit);

				}
			});
		
				$(".search_filter").on("click", function () 
				{ 
			
					var id = $(this).data('id');
					var attr = $(this).data('attr');
					var searchable_tags = $('#'+attr).val();
					$(this).toggleClass( "tag" );
				
					if ( searchable_tags.indexOf(id) === -1 )
					{
							
						if(searchable_tags == '' || searchable_tags == 'undefined')
							var string = id; 
						else
							var string = searchable_tags+','+id; 	
							
						$('#'+attr).val(string);
						searchable_tags = $('#'+attr).val();
						var array = searchable_tags.split(',');
						var result=[] ; 
						$.each(array, function(i,e){ if($.inArray(e,result)===-1){  result.push(e);}}); 
						
						searchable_tags = result.join(',');
						$('#'+attr).val(searchable_tags);
						
					}
					else
					{
							
						result = [];
						var array = searchable_tags.split(',');
						for (var i = 0,len = array.length; i < len; i++) 
						{
							if ( array[i] != id ) 
							{ 
								result.push(array[i]);	
							}
							
						}
						searchable_tags = result.join(',');
						$('#'+attr).val(searchable_tags);
					}
					
					
					
					
				});
			
		});
		
		
		
		
		$( "#slider-range" ).slider({
				  range: true,
				  min: 1 ,
				  max:  <?php if(isset($price)) echo $price; ?>  ,
				  values: [ 1,<?php if(isset($price)) echo $price; ?> ],
				  slide: function( event, ui ) {
					  
					  
					$( "#low_price" ).val( ui.values[ 0 ] ); 
					$( "#amount" ).val( "<?php echo $currency; ?>" + ui.values[ 0 ] + " - <?php echo $currency; ?>" + ui.values[ 1 ] );
					$( "#high_price" ).val( ui.values[ 1 ] ); 

					}
		});
									
		var low = $( "#slider-range" ).slider( "values", 0 ); 	
		var high = $( "#slider-range" ).slider( "values", 1 ); 
		
		$( "#amount" ).val( "<?php echo $currency; ?>" + low  + " - <?php echo $currency; ?>" + high  );
		
		
		
		
		
		
		
		$('#pagination').pagination(
		{
			items: 5,
			itemOnPage: 9,
			currentPage: 1,
			cssStyle: '',
			prevText: '<span aria-hidden="true">&laquo;</span>',
			nextText: '<span aria-hidden="true">&raquo;</span>',
			onInit: function () 
			{
				// fire first page loading
				limit = 9;
				page = 1; 
				offset = (page  * limit) -  limit; 
				
				chef_ids_tags = $('#chef_ids_tags').val();
				searchable_tags	 = $('#searchable_tags').val();
				recipe_serving_tags = $('#recipe_serving_tags').val();
				low_price = $('#low_price').val();
				high_price = $('#high_price').val();
				if( chef_ids_tags.length ===0 && searchable_tags.length === 0 && recipe_serving_tags.length  === 0 ) 
				{
					//alert('pre intital ');
					recipe_all_list(22,2,"<?php if(isset($chef[0]['attributes']['name'])) echo  $chef[0]['attributes']['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",'','','','','',offset,limit);

				}
				else
				{
					//alert('initial');
					
					recipe_all_list(22,2,"<?php if(isset($chef[0]['attributes']['name'])) echo  $chef[0]['attributes']['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",chef_ids_tags,searchable_tags,recipe_serving_tags,low_price,high_price,offset,limit);

				}
				
										
				
			},
			onPageClick: function (page, evt) 
			{
				
				// some code
				limit = 9;
				offset = (page  * limit) -  limit;
				
				chef_ids_tags = $('#chef_ids_tags').val();
				searchable_tags	 = $('#searchable_tags').val();
				recipe_serving_tags = $('#recipe_serving_tags').val();
				low_price = $('#low_price').val();
				high_price = $('#high_price').val();
				if( chef_ids_tags.length ===0 && searchable_tags.length === 0 && recipe_serving_tags.length  === 0 ) 
				{
					recipe_all_list(22,2,"<?php if(isset($chef[0]['attributes']['name'])) echo  $chef[0]['attributes']['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",'','','','','',offset,limit);

				}
				else
				{
					//alert('page');
					
					recipe_all_list(22,2,"<?php if(isset($chef[0]['attributes']['name'])) echo  $chef[0]['attributes']['name'];  else echo ""; ?>", "{{ route('recipe_all_list') }}","{{ route('recipe_detail') }}",chef_ids_tags,searchable_tags,recipe_serving_tags,low_price,high_price,offset,limit);
					
				}
				
				
			}
		});


        var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
        menus("{{ route('menus') }}",category_id) ;
	
			load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
			total("{{ route('total_price') }}");			
			add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
			signin("{{ route('signin') }}");
			//signup("{{ route('signup') }}");
			load_wishlist("{{ route('add_to_wishlist') }}");
			
			referAFriend("{{ route('refer_a_friend') }}");
			aboutBusiness("{{ route('aboutBusiness') }}")	;
			topChefDeal("{{ route('top_chef_deals_list') }}");
			
			// Auto Adjust Height
			$(window).on('load', function() {
				function resize(selector, footer) {
					var totalheight = $(window).height();
					if(footer){
						var lessheight = $('.cart-tabs .cartTabHeader').height() + $('.tab-content .cartTabFooter').height();
						var docheight = totalheight - lessheight;
					}else{
						var lessheight = parseInt($('.cart-tabs .cartTabHeader').height());
						var docheight = totalheight - lessheight - parseInt(25);
					}			
								
					$('.tab-content ' + selector).css("height", docheight);		
					$('.tab-content ' + selector).css("min-height", '300px'); // i have given minimum height 
				}
				
				$(document).ready(function() {
					resize('.basketList',false); //basketList
					resize('.wishList',false); //wishList
				});
				
				$(window).resize(function() {
					resize('.basketList',false); //basketList
					resize('.wishList',false); //wishList
				});
					
			});

			// Modal Script
			$('#myModal').on('shown.bs.modal', function () {
				$('#myInput').focus()
			});
			
			// Add Cart Btn Animation
			$('.addtocart').click(function(){
				$(this).hide();
				var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
			});

			// All Small Script
			$(document).ready(function () {
				//Select2
				$(".js-example-basic-single").select2({
					minimumResultsForSearch: Infinity
				});
				
				//Sider Bar Fixed on Scroll
				$('#sidebar').stickySidebar({
					topSpacing: 20,
					containerSelector: '.container',
					innerWrapperSelector: '.sidebar__inner'
				});
			 
				// Field Style
				$(".fluid-label").focusout(function(){
					$(".focused").removeClass("focused");	
				});
				$('.fluid-label').fluidLabel({
					focusClass: 'focused'
				});
				
				//Navigation Menu Slider
				$('#cartList, #cartList2').on('click',function(e){
					e.preventDefault();
					$('body').toggleClass('nav-expanded');
				});
                $('.overlay').on('click', function (e) {
                    e.preventDefault();
                    $('body').toggleClass('nav-expanded');
                });
				$('#nav-close').on('click',function(e){
					e.preventDefault();
					$('body').removeClass('nav-expanded');
				});
				$('.basketList').enscroll({
					showOnHover: true,
					verticalTrackClass: 'track3',
					verticalHandleClass: 'handle3'
				});
				$('.wishList').enscroll({
					showOnHover: true,
					verticalTrackClass: 'track3',
					verticalHandleClass: 'handle3'
				});
				
				//Header Slider
				$('.headerSlider').bxSlider({
					mode: 'fade',
					speed: 1000,
					captions: true,
					pager: false,
					controls: false,
					auto: true
				});
				
				// Wizard Form
				
				
			});
			
			//Inc Dec Button----------------
			$(".incr-btn").on("click", function (e) {
				var $button = $(this);
				var oldValue = $button.parent().find('.quantity').val();
				$button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
				if ($button.data('action') == "increase") {
					var newVal = parseFloat(oldValue) + 1;
				} else {
					// Don't allow decrementing below 1
					if (oldValue > 1) {
						var newVal = parseFloat(oldValue) - 1;
					} else {
						newVal = 1;
						$button.addClass('inactive');
					}
				}
				$button.parent().find('.quantity').val(newVal);
				e.preventDefault();
			});
			
			// Nav Greedy First
			var $nav = $('.greedy-nav');
			var $btn = $('.greedy-nav button');
			var $vlinks = $('.greedy-nav .visible-links');
			var $hlinks = $('.greedy-nav .hidden-links');
			var breaks = [];
			function updateNav() {			  
			  var availableSpace = $btn.hasClass('hidden') ? $nav.width() : $nav.width() - $btn.width() - 30;
			  // The visible list is overflowing the nav
			  if($vlinks.width() > availableSpace) {
				// Record the width of the list
				breaks.push($vlinks.width());
				// Move item to the hidden list
				$vlinks.children().last().prependTo($hlinks);
				// Show the dropdown btn
				if($btn.hasClass('hidden')) {
				  $btn.removeClass('hidden');
				}
			  // The visible list is not overflowing
			  } else {
				// There is space for another item in the nav
				if(availableSpace > breaks[breaks.length-1]) {
				  // Move the item to the visible list
				  $hlinks.children().first().appendTo($vlinks);
				  breaks.pop();
				}
				// Hide the dropdown btn if hidden list is empty
				if(breaks.length < 1) {
				  $btn.addClass('hidden');
				  $hlinks.addClass('hidden');
				}
			  }
			  // Keep counter updated
			  $btn.attr("count", breaks.length);
			  // Recur if the visible list is still overflowing the nav
			  if($vlinks.width() > availableSpace) {
				updateNav();
			  }
			}

			// Window listeners
			$(window).resize(function() {
				updateNav();
			});
			$btn.on('click', function() {
			  $hlinks.toggleClass('hidden');
			});
			updateNav();
			
			
			// Nav Greedy Close When Other is Open
			$( "body" ).click(function(e) {
				if(!$(e.target).parent().hasClass("greedy-nav")){
					$(".greedy-nav .hidden-links").addClass("hidden");
				}
				if(!$(e.target).parent().hasClass("greedy-nav-second")){
					$(".greedy-nav-second .hidden-links").addClass("hidden");
				}
			});
			
			
		</script>


	@endsection

