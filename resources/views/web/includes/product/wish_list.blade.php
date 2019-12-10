
<?php 


if(isset($wishlist))
{
	if($wishlist!=null) 	
	{
	   // echo '<pre>'; print_r($wishlist); exit;
		echo '<table  width="100%">';
		$n=1;
		foreach ( $wishlist  as $wishlistItems )
		{
?>


<tr>
	<td>
		<img src='<?php echo $wishlistItems['thumb']; ?>' width="63px" height="63px"/>
	</td>
	<td class="setWidthRow">
		<div class="addItemRecipe addItemRecipeWishList"><?php echo $wishlistItems['title'];?></div>
		<div class="addItemRate addItemRateWishList"><?php echo $currency; ?>  <?php if(isset( $wishlistItems["price"])) echo $wishlistItems["price"];   ?></div>
	</td>
	<td class="wishListButtons">
		<a href="javascript:void(0);" class="wishlist-cart wishListCartIcon" data-wishlist-id="{!! $wishlistItems["wishlist_entity_id"] !!}" data-id="{!! $wishlistItems["entity_id"] !!}">
			<button class="addtocart wishListButton">
				<span class="icon-tt-cart-Icon"></span>
			</button>
		</a>
		<a class="cross_wrap wishListCrossIcon" href="#" >
			<span style="font-size:75%;color:#000;margin-left: 50%;margin-bottom: 57%;" onclick="deleteWishlistProduct('{{ $wishlistItems['entity_id'] }}','{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}','{{route('add_to_wishlist')}}','{{route('delete_to_wishlist')}}' )" > <!--class="clancelItem" -->
				<span class="icon-tt-close-icon"></span>
			</span>
		</a>
	</td>
</tr>

			<tr class="borderB"><td colspan="3"><div></div></td></tr>
			

<?php
		 $n++ ;
		}
		echo '</table>';
	}
	else
	{
?>		
		<div class="wishlist_empty nav nav-tabs" style="padding-top: 50%;">
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  ><img src="{!! url('/').'/public/web/img/Wishlist-Empty.png' !!}" /></div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				{{--You don't have any Wishlist items--}}
			</div>
		</div>
<?php
	}
	
}
else
{
?>
		<div class="wishlist_empty nav nav-tabs" style="padding-top: 50%;">
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  ><img src="{!! url('/').'/public/web/img/Wishlist-Empty.png' !!}" /></div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				{{--You don't have any Wishlist items--}}
			</div>
		</div>
		
<?php
}

?>





