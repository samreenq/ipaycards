
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
				<td colspan="2"><img src='<?php echo $wishlistItems['thumb']; ?>' width="63px" height="63px"/></td>
				<td>
						<table width="100%" Class="wishlistWrapper" id="wishlist-{!! $wishlistItems["entity_id"] !!}">
							<input type="hidden" name="entity_id" id="entity_id" value="{!! $wishlistItems["entity_id"] !!}" />
							<input type="hidden" name="title" id="title" value="{!! $wishlistItems["title"] !!}" />
							<input type="hidden" name="product_code" id="product_code" value="{!! $wishlistItems["product_code"] !!}" />
							<input type="hidden" name="price" id="price" value="{!! $wishlistItems["price"] !!}" />
							<input type="hidden" name="thumb" id="thumb" value="<?php echo $wishlistItems["thumb"] ?>" />
							<input type="hidden" name="item_type" id="item_type" value="<?php echo isset($wishlistItems["item_type"]['value']) ? $wishlistItems["item_type"]['value'] : $wishlistItems["item_type"] ?>" />
								<tr>
									<td class="addItemRecipe"><?php echo $wishlistItems['title'];?></td>
									{{--<td class="addItemWeight" align="right">--}}
											<?php 
												// if(isset( $wishlistItems["product_code"])  && isset( $wishlistItems["product_code"]))
												//	echo $wishlistItems["product_code"];
											?>
									{{--</td>--}}
									<td class="addItemMore" align="center">
										<a class="cross_wrap" href="#" >
											<span style="font-size:75%;color:#000;margin-left: 50%;margin-bottom: 57%;" onclick="deleteWishlistProduct('{{ $wishlistItems['entity_id'] }}','{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}','{{route('add_to_wishlist')}}','{{route('delete_to_wishlist')}}' )" > <!--class="clancelItem" -->
												<span class="icon-tt-close-icon"></span>
											</span>
										</a>
									</td>
								</tr>
								<tr>
									<td class="addItemRate"><?php echo $currency; ?>  <?php if(isset( $wishlistItems["price"])) echo $wishlistItems["price"];   ?></td>
									<td><a href="javascript:void(0);" class="wishlist-cart" data-wishlist-id="{!! $wishlistItems["wishlist_entity_id"] !!}" data-id="{!! $wishlistItems["entity_id"] !!}">Add to Cart</a></td>
								</tr>
								
						</table>
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





