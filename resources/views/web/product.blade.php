

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
//echo "<pre>"; print_r($categories); exit;

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
					@if(!empty($cat_id))
					<div class="proAdvSearchcBtn text-right">
						<input type="button" class="advance_search" value="Advanced Search" />
					</div>
					@endif

					<div class="row">
						<div class="prod-left-bar col-md-12 col-lg-3 affix">
							<div id="sidebar">
								<div class="sidebar__inner">

						@if(!empty($cat_id))

										<div class="main_categeory"><h4><a style="color: #48494d !important;" href=" {{ url('/').'/product?entity_type_id=14&category_id='.$categories->category_id }}" ><?php if(isset($categories->title)) echo $categories->title; if(isset($categories->product_count)) echo '('.$categories->product_count.')'; ?></a></h4></div>
									@if($categories->child && count($categories->child)>0)
											<ul class="categories vegeListWrap pl15" id="accordion">
												@foreach($categories->child as $category_raw)
													<?php
                                                    $text_color = '#48494d';
														if($cat_id == $category_raw->category_id){
														    $text_color = '#EF9B9B';
														    }
													?>
													<li class="vegePanel panel"><a style="color: {!! $text_color !!} !important;" href=" {{ url('/').'/product?entity_type_id=14&category_id='.$category_raw->category_id }}" ><?php if(isset($category_raw->title)) echo $category_raw->title; if(isset($category_raw->product_count)) echo '('.$category_raw->product_count.')'; ?></a></li>
											@endforeach
												</ul>
										@endif
									@endif
											<div class="productFiltSide" style="display:none">

													<div class="productSideFilter">
														<p>
														  <h4 for="amount">Price</h4>
														  <input type="hidden" id="low_price" value="1" />
														  <input type="hidden" id="high_price" value="{!! $price !!}" />
														  <input type="text" id="amount" readonly >
														</p>
														<div id="slider-range"></div>
													</div>

													<?php




														//category_id
														//price
														//searchable_tags


													?>


													<div class="productSideFilter">
														  <h4>Searchable tags</h4>
														  <ul>
															<?php
                                                              $selected_tags = array();

																	if(isset($searchable_tags))
																		foreach($searchable_tags as $searchable_tags_attributes)
																		{
																		    $selected_tags[] = $searchable_tags_attributes['id'];
															?>
																				<li><a class="searchable_tags search_filter tag" data-id="<?php echo $searchable_tags_attributes['id'];?>" data-attr="searchable_tags"><?php echo $searchable_tags_attributes['value'];?></a></li>
															<?php
																		}

															?>

														  </ul>
													</div>
													<div class="productSideFilter">
														  <h4>Categories</h4>
														  <ul>
															<?php
                                                              $selected_categories = array();
																	if(isset($category_id))
																		foreach($category_id as $category_id_attributes)
																		{
																		    $selected_categories[] = $category_id_attributes['category_id'];

															?>
																				<li><a class="category_id search_filter tag" data-id="<?php echo $category_id_attributes['category_id'];?>" data-attr="category_id"   id="<?php echo $category_id_attributes['category_id'];?>"><?php echo $category_id_attributes['title'];?></a></li>
															<?php
																		}

															?>

														  </ul>
													</div>

												<div class="productSideFilter">
													<h4>Brands</h4>
													<ul>
                                                        <?php
                                                        $selected_brands = array();

                                                        if(isset($brand_ids))
															foreach($brand_ids as $brand_id)
															{
																$selected_brands[] = $brand_id['id'];
																?>
																<li><a class="brand_id search_filter tag" data-id="<?php echo $brand_id['id'];?>" data-attr="brand_id"   id="<?php echo $brand_id['id'];?>"><?php echo $brand_id['value'];?></a></li>
																<?php
															}

                                                        ?>

													</ul>
												</div>

												<input id="searchable_tags" name="searchable_tags" type="hidden" value="" />
												<input id="category_id" name="category_id" type="hidden" value="" />
												<input id="product_form" name="product_form" type="hidden" value="" />
												<input id="brand_id" name="brand_id" type="hidden" value="" />

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



						<div class="prod-right-bar col-md-12 <?php if(!isset($_REQUEST['category_id'])){ ?>col-lg-12 <?php }else { ?> col-lg-9<?php } ?>" >
							<div class="tab-pane in active" id="tab1default">



								<?php
										if(isset($_REQUEST['featured_type']) || isset($_REQUEST['product_promotion_id']))
										{
								?>
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
								<?php
										}

								?>

                                    <?php
                                    if(isset($brand))
                                    {
                                    ?>
										<div class="np-seasons">
											<div class="container">
												<div class="row align-items-baseline mb30 stitle-wrap">
													<h2 class="mr-auto align-items-start">
														{!! $brand->title !!}
													</h2>
												</div>
											</div>
										</div>
								<?php
                                    }

                                    ?>
									<div id="products"  class="row">

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
			
		$(document).ready(function() {


			
			$(".advance_search").on("click", function () 
			{ 
				 
				$('.categories').css('display','none');
				$('.productFiltSide').css('display','block');
				
				data = '<div class="error404Wrap ml-auto mr-auto mt70 mb70">	<div class="error404img mt50 mb50"></div><div class="error404content text-center"><h2>No Product Found</h2><p>The product you are looking for doesn\'t exist. Try another keyword or return to <a href="<?php echo url('/');?>">home</a></p></div></div>';
				
				
				$("#products").empty().append(data);
				$(".main_categeory").empty();

				$('#searchable_tags').val("{!! (count($selected_tags)) ?  implode(',',$selected_tags) : '' !!}");
                $('#category_id').val("{!! (count($selected_categories)) ?  implode(',',$selected_categories) : '' !!}");
                $('#brand_id').val("{!! (count($selected_brands)) ?  implode(',',$selected_brands) : '' !!}");

               searchAdvance();
				
				
			}); 
			
			$(".reset").on("click", function () 
			{ 
				if ($('.search_filter').is('.tag'))
					$(".search_filter").removeClass('tag');
					
				$('#searchable_tags').val('');
				$('#category_id').val('');
				$('#product_form').val('');
                $('#brand_id').val('');
				
				$('#low_price').val('1');
				$('#amount').val("{!! $currency !!}"+'1 - $<?php if(isset($price)) echo $currency." ".$price; ?>');
				$('#high_price').val('<?php if(isset($price)) echo $price; ?>');
				
				$( "#slider-range" ).slider({
				  range: true,
				  min: 1 ,
				  max:  <?php if(isset($price)) echo $price; ?>  ,
				  values: [ 1,<?php if(isset($price)) echo $price; ?> ]
				});
				
			}); 
			
			$(".search").on("click", function () {
                searchAdvance();

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
				  max:  <?php  if(isset($price)) echo $price; ?>  ,
				  values: [ 1,<?php if(isset($price)) echo $price; ?> ],
				  slide: function( event, ui ) {
					  
					  
					$( "#low_price" ).val( ui.values[ 0 ] ); 
					$( "#amount" ).val( "{!! $currency.' ' !!}" + ui.values[ 0 ] + " - {!! $currency.' ' !!}" + ui.values[ 1 ] );
					$( "#high_price" ).val( ui.values[ 1 ] ); 

					}
		});
									
		var low = $( "#slider-range" ).slider( "values", 0 ); 	
		var high = $( "#slider-range" ).slider( "values", 1 ); 
		
		$( "#amount" ).val( "{!! $currency !!} " + low  + " - {!! $currency !!} " + high  );
		
		<?php 
		
		if( isset($_REQUEST['category_id']) || isset($_REQUEST['product_promotion_id']) || isset($_REQUEST['featured_type']) || isset($_REQUEST['title']) || isset($_REQUEST['brand_id']))
		{

		?>
		$('#pagination').pagination(
		{
			items: 5,
			itemOnPage: 12,
			currentPage: 1,
			cssStyle: '',
			prevText: '<span aria-hidden="true">&laquo;</span>',
			nextText: '<span aria-hidden="true">&raquo;</span>',
			onInit: function () 
			{
				// fire first page loading
				limit = 12;
				page = 1; 
				offset = (page  * limit) -  limit; 
				<?php 
						if( isset($_REQUEST['category_id']) ) 
						{
				?>
							
							category_id = $('#category_id').val();
							searchable_tags	 = $('#searchable_tags').val();
							
							if($('#product_form').val().includes(","))
								product_form=' ';
							else 
								product_form = $('#product_form').val();
							
							low_price = $('#low_price').val();
							high_price = $('#high_price').val();
							if( category_id.length ===0 && searchable_tags.length === 0 && product_form.length  === 0 ) 
							{
								//alert('pre intital ');
								product_list1("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",14,<?php echo $cat_id; ?>,"{{ route('product_list') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",'','','','',offset,limit);
	
							}
							else
							{
								//alert(category_id);
								product_list1("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",14,category_id,"{{ route('product_list') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",product_form,searchable_tags,low_price,high_price,offset,limit);
							}
				
				<?php 
						}
						if(isset($_REQUEST['product_promotion_id']))
						{
				?>
							promoted_product_list(14,<?php echo $_REQUEST['product_promotion_id']; ?>,"{{ route('product_promotion') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);
				<?php
						}
						if(isset($_REQUEST['featured_type']))
						{
				?>
							feature_product_list(14,<?php echo $_REQUEST['featured_type']; ?>,"{{ route('featured_type') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",1,offset,limit);
				
				<?php 
						}
			
				?>
                        <?php if(isset($_REQUEST['brand_id'])){ ?>
                            brand_product_list(14,<?php echo $_REQUEST['brand_id']; ?>,"{{ route('brand_products') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);
                        <?php } ?>

                <?php   if( isset($_REQUEST['title']) ) {
                        $title = addslashes($_REQUEST['title']);
                    ?>
                    product_list_by_title(14,"<?php echo $title ?>", "{{ route('product_title') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);

                // Add Cart Btn Animation
                $('.addtocart').click(function(){

                    $(this).hide();
                    var abc = $(this).parent().find('.pro-inc-wrap').toggle("slide");

                });


                //Inc Dec Button----------------
                $(".addtocart").on("click", function ()
                {
                    var $button = $(this);
                    var oldValue = $button.parent().find('.quantity').val();
					//alert(oldValue);

                    var entity_id 			= $button.parent().find('.entity_id').val();
                    var product_code 		= $button.parent().find('.product_code').val();
                    var	title 		 		= $button.parent().find('.title').val();
                    var	thumb 		 		= $button.parent().find('.thumb').val();
                    var	price   			= $button.parent().find('.price').val();
                    var	item_type   			= $button.parent().find('.item_type').val();
                   /* var	weight 		 		= $button.parent().find('.weight').val();
                    var	unit_option  		= $button.parent().find('.unit_option').val();
                    var	unit_value 	 		= $button.parent().find('.unit_value').val();*/

                    $button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');

                    if(oldValue=="0")
                    {
                        //var oldValue = parseFloat(oldValue) + 1;
                        //	var newVal	= oldValue;
                    }
                    if ($button.data('action') == "increase") {
                        var newVal = parseFloat(oldValue) + 1;
                    }
                    if ($button.data('action') == "decrease")
                    {
                        // Don't allow decrementing below 1
                        if (oldValue > 1) {
                            var newVal = parseFloat(oldValue) - 1;
                        } else {
                            newVal = 1;
                            $button.addClass('inactive');
                            $('.pro-inc-wrap').hide();
                            $('.addtocart').show();
                            deleteCartProduct(product_code,"{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('total_price') }}");
                        }
                    }


                    if(oldValue=="1")
                    {
                        oldValue = parseFloat(oldValue);
                        var newVal	= oldValue;
                    }

                    //$button.parent().find('.quantity').val(newVal);
                    product_quantity  = newVal;

                    if(product_quantity==1)
                    {
                        if(typeof(localStorage.products)=="undefined")
                        {
                            var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
                            localStorage.products =string;
                            console.log('sam',localStorage.products)
                        }

                        if(typeof(localStorage.products)!=="undefined")
                        {
                            var products = JSON.parse(localStorage.products);
                            var products1 = [];
                            n = 0 ;
                            for (var i = 0; i <products.length; i++)
                            {
                                if(product_code === products[i].product_code)
                                {
                                    //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                                    products[i].product_quantity  =  parseInt(product_quantity);
                                    n=0;
                                    break;
                                }
                                else
                                {
                                    n=1;
                                }
                            }
                            if ( n==1 )
                            {
                                var len = products1.length;
                                var string = {
                                    "entity_id":entity_id,
                                    "product_code":product_code ,
                                    "title":title,
                                    "thumb":thumb,
                                    "price":price,
                                    "item_type":item_type,
                                  /*  "weight":weight,
                                    "unit_option":unit_option,
                                    "unit_value":unit_value,*/
                                    "product_quantity":parseInt(product_quantity)
                                };
                                products.push(string);
                            }
                            localStorage.setItem("products", JSON.stringify(products));
                            total("{{ route('total_price') }}");
                        }
                    }

                    load_cart("{{ route('add_to_cart') }}","{{ route('total_price') }}");

                });






			<?php	} ?>
						
			},
			onPageClick: function (page, evt) 
			{
				// some code
				limit = 12;
				offset = (page  * limit) -  limit; 
				<?php 
						if( isset($_REQUEST['category_id']) ) 
						{
				?>
							category_id = $('#category_id').val();
							searchable_tags	 = $('#searchable_tags').val();
                            product_form=' ';
							/*if($('#product_form').val().includes(","))
								product_form=' ';
							else 
								product_form = $('#product_form').val();*/
							
							low_price = $('#low_price').val();
							high_price = $('#high_price').val();
							if( category_id.length !==0 && searchable_tags.length !== 0 && product_form.length  !== 0 ) 
							{
								product_list1("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",14,<?php echo $cat_id; ?>,"{{ route('product_list') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",'','','','',offset,limit);
	
							}
							else
							{
								//alert('page');
										
								product_list1("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",14,category_id,"{{ route('product_list') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",product_form,searchable_tags,low_price,high_price,offset,limit);
								
								//product_categories("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",<?php if(isset($_REQUEST['category_id'])) echo $_REQUEST['category_id'] ?>);
					
							}
				
				<?php 
						}
						if(isset($_REQUEST['product_promotion_id']))
						{
				?>
                			promoted_product_list(14,<?php echo $_REQUEST['product_promotion_id']; ?>,"{{ route('product_promotion') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);
				<?php
						}
						if(isset($_REQUEST['featured_type']))
						{
				?>
                feature_product_list(14,<?php echo $_REQUEST['featured_type']; ?>,"{{ route('featured_type') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",1,offset,limit);
				
				<?php } ?>

                <?php if(isset($_REQUEST['brand_id'])){ ?>
                brand_product_list(14,<?php echo $_REQUEST['brand_id']; ?>,"{{ route('brand_products') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);
                <?php } ?>

                <?php   if( isset($_REQUEST['title']) ) {
                $title = addslashes($_REQUEST['title']); ?>
                product_list_by_title(14,"<?php echo $title ?>", "{{ route('product_title') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",offset,limit);
                <?php	} ?>

			}
		});
		<?php 
		}
		?>




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

				function searchAdvance(){

                    category_id = $('#category_id').val();
                    searchable_tags	 = $('#searchable_tags').val();
                    brand_id	 = $('#brand_id').val();

                    if($('#product_form').val().includes(","))
                        product_form=' ';
                    else
                        product_form = $('#product_form').val();

                    low_price = $('#low_price').val();
                    high_price = $('#high_price').val();

                    //alert(low_price.length);
                    if( category_id.length !==0 || searchable_tags.length !== 0 || product_form.length  !== 0 || low_price.length !==0 || high_price.length !==0 || brand_id.length !== 0)
                    {
                        //alert('click');
                        limit = 12;
                        page = 1;
                        offset = (page  * limit) -  limit;


                        product_list2("{{ route('categories') }}","{{ route('total_price') }}","{{ route('add_to_cart') }}","{{ route('show_cart') }}",14,category_id,"{{ route('product_list') }}","{{ route('product_detail') }}","{{ route('add_to_wishlist') }}",product_form,searchable_tags,low_price,high_price,brand_id,offset,limit);



                    }
				}
			
		</script>


	@endsection

