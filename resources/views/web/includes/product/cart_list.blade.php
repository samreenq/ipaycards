<?php


if(isset($products))
{
			
	if($products!=null) 	
	{	

		echo '<table  width="100%">';	
		$n=1;

foreach ( $products  as $productItemsList )
{
	if(isset($productItemsList['entity_id']) && !empty($productItemsList['entity_id'])){
?>

<tr>
	<td><img class="basketListImage" src="<?php echo $productItemsList['thumb'];?>" width="63"/></td>
	<td>
		<div class="addItemRecipe addItemRecipeTitle">{{ $productItemsList['title'] }}</div>
		<div class="addItemRate addItemRateAed">
			<div class="left"><?php echo $currency; ?>  </div>
			<div class="right price{{ $n }}" > @if( isset($productItemsList['price']) && isset($productItemsList['product_quantity'])){{$productItemsList['price']*$productItemsList['product_quantity']}} @endif</div>
		</div>
		<div class="aedEach" style="display: block;font-weight: 400;color: #c2c5d1;font-size: 13px;"> <?php echo $currency; ?> @if(isset($productItemsList['price'])){{ $productItemsList['price']}}@endif each</div>
	</td>
	<td>
		<a class="cross_wrap reciptClose" href="javascript:void(0)" >
			<span style="font-size:75%;color:#000;margin-left: 50%;margin-bottom: 57%;" onclick="deleteCartProduct('@if(isset($productItemsList['product_code'])){{$productItemsList['product_code']}}@endif','{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}')" > <!--class="clancelItem" -->
				<span class="icon-tt-close-icon"></span>
			</span>
		</a>
		<div class="addItemMore" align="center">
			<div class="count-input space-bottom ipayCountInput">
				<a class="incr-btn incr-btn1  mrn text-right" data-action="decrease" href="javascript:void(0)">
					<span class="icon-tt-minus-icon"></span>
				</a>
				<input class="product_code" type="hidden" name="code" value="@if( isset($productItemsList['product_code']) ){{$productItemsList['product_code']}}@endif"/>
				<input class="price_tmp" type="hidden" name="code" value="@if( isset($productItemsList['price']) && isset($productItemsList['product_quantity']) ) {{ $productItemsList['price'] * $productItemsList['product_quantity'] }} @endif"/>
				<input class="price_id" type="hidden" name="code" value="{{ $n }}"/>
				<input class="quantity{{ $n }}" type="number" readonly name="quantity" value="@if(isset($productItemsList['product_quantity'])){{$productItemsList['product_quantity']}}@endif"/>
				<a class="incr-btn incr-btn1 mln text-left" data-action="increase"  href="javascript:void(0)">
					<span class="icon-tt-plus-icon"></span>
				</a>
			</div>
		</div>
	</td>
</tr>



				<tr class="borderB"><td colspan="3"><div></div></td></tr>
<?php 
			$n++;
		}
		}
		echo '</table>';
	}
	else
	{
?>
		<div class="cart_empty nav nav-tabs" style="padding-top: 50%;">
            <img src="{!! url('/').'/public/web/img/Cart-Empty.png' !!}" />
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  >

			</div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;">

			</div>
		</div>
<?php
	}
	
}
else
{
?>
		<div class="cart_empty nav nav-tabs" style="padding-top: 50%;">
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  ><img src="{!! url('/').'/public/web/img/Cart-Empty.png' !!}" /></div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;">
				{{--You don't have any Cart items--}}

			</div>
		</div>
<?php

}

?>

