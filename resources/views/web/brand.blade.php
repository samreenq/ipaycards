

@extends("web.templates.template2")

	@section("head")
		 @include("web/includes/head")
					<link href="<?php echo url('/').'/public/web/css/select2.css';?>" rel="stylesheet"/>
					<style >
						.abc{    padding-left: 12%;}
					</style>
	
	@endsection


	@section("navbar")
		@include("web/includes/navbar")
	@endsection


	@section("cartbar")
		@include("web/includes/cartbar")
	@endsection

	@section('header')
			<!-- Header -->	
		<?php 
				if(isset($_REQUEST['category_id']))
				{
					$cat_id =$_REQUEST['category_id'];
					foreach ( $categories as $tmp ) 
					{
						if($tmp['parent_id']==0)
						{
							if($tmp['category_id']==$_REQUEST['category_id']) 
							{
								if(isset($tmp['child'][0]['category_id']))
									$cat_id = $tmp['child'][0]['category_id'];
							}
						}
					}
				}
		?>
		
	<header id="inner-header">
		<div class="container pageNavWrap">
			<div class="greedy-nav page-nav">
				<button type="button" class="pull-right">More</button> 
				<ul class=" menus visible-links">
									<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													id="LoadingImageMenu" align="center" style="display: none">
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
					<div class="col-12">
						<div class="bannerContWrap">
							<form class="form-horizontal" role="form" method="GET" action="{{ url('/product') }}">
								<div class=" toolbar-search">
									<input class="search-bar"  required="required" class="form-control" name="title" placeholder="I’m looking for…" type="text" value="">
									<button class="search-btn"  type="submit"><span class="icon-tt-right-arrow"></span></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</header>
			
	@endsection
	
	
	@section("product")

			<section class="product-Section lightgreybg">
				
				<div class="fly-nav-inner">
					<div class="container">
						<button class="dropdown-toggle" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
						<div id="productCateSideWrap" class="dropdown-menu mega-dropdown-menu">
							
							<ul class=" vegeListWrap sidebar__inner p20" id="accordion1">
									
							</ul>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="proAdvSearchcBtn text-right">
						<input type="button" class="advance_search" value="Advance Search" />
					</div>	
					<div class="row">
						
						
							<?php 
							
							if(isset($_REQUEST['category_id']))
																{
																	
									?>
									
										
										<div class="prod-left-bar col-md-12 col-lg-3 affix">
											<div id="sidebar">
												<div class="sidebar__inner">

												<?php







													if(isset($_REQUEST['category_id']))
													{
														foreach ( $categories as $tmp )
														{
															if($_REQUEST['category_id']==$tmp['category_id'])
															{

																	if($tmp['is_parent']==1)
																	{
												?>
																			<div class="main_categeory"><h4><a style="color: #48494d !important;" href=" {{ url('/').'/product?entity_type_id=14&category_id='.$tmp['category_id']}}" ><?php if(isset($tmp['title'])) echo $tmp['title']; if(isset($tmp['product_count'])) echo '('.$tmp['product_count'].')'; ?></a></h4></div>
												<?php
																	}
																	else
																	{
																		foreach ( $categories_all as $tmp1 )
																		{

																			if($tmp1['category_id']==$tmp['parent_id'])
																			{

												?>
																			<div class="main_categeory"><h4><a style="color: #48494d !important;" href=" {{ url('/').'/product?entity_type_id=14&category_id='.$tmp1['category_id']}}" ><?php if(isset($tmp1['title'])){ echo $tmp1['title']; } if(isset($tmp1['product_count'])){ echo '('.$tmp1['product_count'].')'; } ?></a></h4></div>
												<?php
																			}
																		}
																	}

															}
														}
													}
												?>

													
												<ul class="categories vegeListWrap pl15" id="accordion">
													
																	<div style="
																					position: absolute;
																					top: 50%;
																					left: 50%;
																					margin-top: -50px;
																					margin-left: -50px;
																					width: 100px;
																					height: 100px;
																				"
																				id="LoadingImageCategories" align="center" style="display: none">
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
												<div class="productFiltSide" style="display:none">
													
													<div class="productSideFilter">
														<p>
														  <h4 for="amount">Price</h4>
														  <input type="hidden" id="low_price"  />
														  <input type="hidden" id="high_price" />
														  <input type="text" id="amount" readonly >
														</p>
														<div id="slider-range"></div>
													</div>
													
													<?php 
													
														
													
														
														//category_id
														//price
														//searchable_tags
														
														
													?>
													
													
													<input id="searchable_tags" name="searchable_tags" type="hidden" value="" />
													<input id="category_id" name="category_id" type="hidden" value="" />
													<input id="product_form" name="product_form" type="hidden" value="" />
													

													<div class="productSideFilter">
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
													<div class="productSideFilter">
														  <h4>Categories</h4>
														  <ul>
															<?php 
																	if(isset($category_id))
																		foreach($category_id as $category_id_attributes)
																		{
																		
															?>		
																			<li><a class="category_id search_filter" data-id="<?php echo $category_id_attributes['category_id'];?>" data-attr="category_id"   id="<?php echo $category_id_attributes['category_id'];?>"><?php echo $category_id_attributes['title'];?></a></li>
															<?php	
																		}
															
															?>
															
														  </ul>
													</div>
													
													<div class="productResetBtn">
													<br />
																<input type="button" class="reset" style="cursor: pointer;" value="Reset" />
																<input type="button" class="search" style="cursor: pointer;" value="Search" />
																<div 	style="
																					position: absolute;
																					margin: -32px 0px 0px 142px;
																
																			"
																		id="LoadingImageSearchProducts" align="center" style="display: none"
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
													
													
												</div>
												</div>
											</div>
										</div>
						
						<?php 
								}
									?>
								
						<div class="prod-right-bar col-md-12 <?php if(!isset($_REQUEST['category_id'])){ ?>col-lg-12 <?php }else { ?> col-lg-9<?php } ?>" >
							<div class="tab-pane in active" id="tab1default">
								
								
							
								<?php 
										if(isset($_REQUEST['featured_type']) || isset($_REQUEST['product_promotion_id']))
										{
								?>								
											<section class="lightgreybg">
													<div class="np-seasons">
														<div class="container">
															<div class="row align-items-baseline no-gutters mb30 stitle-wrap">
																<h2 class="mr-auto align-items-start">
																
																	<?php 
																		if(isset($_REQUEST['featured_type']))
																		{
																			if($_REQUEST['featured_type']==1) 
																				echo "Related Items";
																			
																			if($_REQUEST['featured_type']==2) 
																				echo "Our Featured Items";
																		}
																	
																		if(isset($_REQUEST['product_promotion_id']))
																			echo isset($list_heading) ? $list_heading :  "Promotions and Discounts";
																
																	?>
																</h2>
																
															</div>
														</div>
													</div>
											</section>	
								<?php 
										}
									
								?>
								<div id="brands"  class="row">
									
									<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
									
												"

											id="LoadingImageProducts" align="center" style="display: none"
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
								
								
							</div>	
						</div>
					</div>
					
					
				</div>
				
				<div class="container page_showcase" style="display:none">
					<nav aria-label="Page navigation" class="clearfix">
						<ul class="pagination cusPagination float-right" id="pagination"></ul>
					</nav>
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
		
		

		<script src="<?php echo url('/').'/public/web/js/enscroll.min.js';?>"></script>
		<script src="<?php echo url('/').'/public/web/js/select2.min.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/sticky-sidebar.js'?>"></script>
		<script src="<?php echo url('/').'/public/web/js/custom/product.js'?>"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<script src="<?php echo url('/').'/public/web/js/jquery.simplePagination.js';?>" type="text/javascript"></script>
		<script>
			

			$(document).ready(function(){

                $("#LoadingImageProducts").show();
                $.ajax ({
                    url: "{{ route('all_brand') }}",
                    type: 'get',
                    data:   {
                        offset				:	0,
                        limit				:	1000

                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        //$("#products").append(data);
                        $("#LoadingImageProducts").hide();
                        $("#brands").empty().append(data['products']);
                        $('#pagination').pagination('updateItems', data['items']);
                        $("#LoadingImageRecipes").hide();
                        if(data['items'] > 0){
                            $(".page_showcase").css({ 'display': "block" });
                        }
                    }

                });

               /* $('#pagination').pagination(
                    {
                        items: 5,
                        itemOnPage: 20,
                        currentPage: 1,
                        cssStyle: '',
                        prevText: '<span aria-hidden="true">&laquo;</span>',
                        nextText: '<span aria-hidden="true">&raquo;</span>',
                        onInit: function ()
                        {
                            // fire first page loading
                            limit = 20;
                            page = 1;
                            offset = (page  * limit) -  limit;



                            $("#LoadingImageProducts").show();
                            $.ajax ({
                                url: "{{ route('all_brand') }}",
                                type: 'get',
                                data:   {
                                    offset				:	offset,
                                    limit				:	limit

                                },
                                dataType: 'json',
                                success: function(data)
                                {
                                    //$("#products").append(data);
                                    $("#LoadingImageProducts").hide();
                                    $("#brands").empty().append(data['products']);
                                    $('#pagination').pagination('updateItems', data['items']);
                                    $("#LoadingImageRecipes").hide();
                                    if(data['items'] > 0){
                                        $(".page_showcase").css({ 'display': "block" });
                                    }
                                }

                            });


                        },
                        onPageClick: function (page, evt) {
                            // some code
                            limit = 12;
                            offset = (page * limit) - limit;

                            $("#LoadingImageProducts").show();
                            $.ajax ({
                                url: "{{ route('all_brand') }}",
                                type: 'get',
                                data:   {
                                    offset				:	offset,
                                    limit				:	limit

                                },
                                dataType: 'json',
                                success: function(data)
                                {
                                    //$("#products").append(data);
                                    $("#LoadingImageProducts").hide();
                                    $("#brands").empty().append(data['products']);
                                    $('#pagination').pagination('updateItems', data['items']);
                                    $("#LoadingImageRecipes").hide();
                                    if(data['items'] > 0){
                                        $(".page_showcase").css({ 'display': "block" });
                                    }
                                }

                            });
                        }

                    });*/
			});

        var category_id = "<?php if( isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; else echo '0';?>";
        menus("{{ route('menus') }}",category_id) ;
		load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");
		total("{{ route('total_price') }}");			
		add_to_Cart("{{ route('total_price') }}","{{ route('add_to_cart') }}");
		load_wishlist("{{ route('add_to_wishlist') }}");
	
		
		
		
		signin("{{ route('signin') }}");
		
		
		aboutBusiness("{{ route('aboutBusiness') }}")	;
		referAFriend("{{ route('refer_a_friend') }}");
		//topChefDeal("{{ route('top_chef_deals_list') }}");
				
				/*
				$(document).ready(function() {
				$(window).on('scroll',function(){
				  
						
						var scrollHeight = $(document).height();
					var scrollPosition = $(window).height() + $(window).scrollTop();
					
					console.log( scrollHeight +" , "+scrollPosition +" , " + (scrollPosition/scrollHeight)*100); 
					
					
					if ( (scrollPosition/scrollHeight)*100 >= 60  && (scrollPosition/scrollHeight)*100 >= 70) {
						// when scroll to bottom of the page
						

					}


				});
				});

				*/
				// Auto Adjust Height
				$(window).on('load', function() {
					
					//$('#flowers li').click(function(){
					//	$('.collapse').collapse('hide');
					//});
					//$(document).click(function(){
					//	$('.collapse').collapse('hide');
					//});
				

 		
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
					$('#nav-close').on('click',function(e){
						e.preventDefault();
						$('body').removeClass('nav-expanded');
					});
					/*$('.basketList').enscroll({
						showOnHover: true,
						verticalTrackClass: 'track3',
						verticalHandleClass: 'handle3'
					});*/
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
					

					
					
					
				});
				/*
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
				*/
			
			
		</script>


	@endsection

