
<?php

		if(isset($message) && !empty($message)){
		    ?>
		<div class="alert alert-warning">{!! $message !!}</div>
<?php
		}
?>

<ul>

	<?php 
	
	 $n=1 ;
	if(isset($products[0]))
	{
		foreach ( $products as $productItems ) 		
		{

	?>
			<li class="item">
				<div class="item-main clearfix vam">
					<div class="item-block ib-info clearfix">
						<img class="product-img" src='<?php echo $productItems['thumb'];?>' alt="product" />
						<div class="ib-info-meta">
							<span class="checkItemRecipe">@if(isset( $productItems["title"])) {{ $productItems["title"] }} @endif</span>
							<span class="itemno">
									<?php 			
									
											if(isset( $productItems["weight"])  && isset( $productItems["unit_option"]))
												if($productItems["weight"]=="" && $productItems["unit_option"]) 
													echo '('.$productItems["weight"].' '.$productItems["unit_option"].' )';
									?>			
							</span>
						</div>
					</div>
					<div class="item-block ib-qty">
						<div class="count-input space-bottom">
							<a class="incr-btn incr-btn2" data-action="decrease" >
								<span class="icon-tt-minus-icon"></span>
							</a>
							<input class="product_code" type="hidden" name="product_code" value="@if(isset($productItems['product_code'])){{$productItems['product_code']}}@endif"/>
							
							<input class="price_tmp" type="hidden" name="price_tmp" value="@if(isset($productItems['price'])&&isset($productItems['product_quantity'])){{$productItems['price']}}@endif"/>
							
							
							
							<input class="price_id" type="hidden" name="price_id" value="{{ $n }}"/>
							<input class="quantity{{ $n }}" type="number" name="quantity" value="@if(isset($productItems['product_quantity'])){{$productItems['product_quantity']}}@endif"/>
						
							<a class="incr-btn incr-btn2" data-action="increase" >
								<span class="icon-tt-plus-icon"></span>
							</a>
						</div>
					</div>
					
					
					
					<div class="item-block ib-total-price">
						<span class="addItemRate">
							<div class="price"><?php echo $currency; ?><div class="price{{ $n }}" >  @if(isset($productItems['price']) && isset($productItems['product_quantity']) ){{$productItems['price']*$productItems['product_quantity']}}@endif </div>
								</div>
							<span><?php echo $currency; ?> @if(isset($productItems['price'])){{$productItems['price']}}@endif each</span>
						
						</span>
					</div>
					<span onclick="deleteCartProduct('@if(isset($productItems['product_code'])){{$productItems['product_code']}}@endif','{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}')" class="clancelItem">
						
							<span class="icon-tt-close-icon">
							</span>
					</span>					  									
									
				</div> 
			</li>
			
	<?php 
			 $n++;
		}
	}
	?>
</ul>