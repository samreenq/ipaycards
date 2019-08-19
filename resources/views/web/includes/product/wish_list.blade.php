
<?php 


if(isset($wishlist))
{
	if($wishlist!=null) 	
	{
		echo '<table  width="100%">';
		$n=1;
		foreach ( $wishlist  as $wishlistItems )
		{
			
?>
			
			<tr> 
				<td colspan="2"><img src='<?php 
														if(isset($wishlistItems['thumb']))
															{ 
																	$handle = @fopen($wishlistItems['thumb'], "r");
																	if(strpos("$handle", "Resource id") !== false)
																	{
																			 
																			echo $wishlistItems['thumb']; 
																	} 
																	else 
																	{ 
																			echo url("/")."/public/web/img/image_not_found_all.jpg";
																	} 
															}  
															else
															{
																	echo url("/")."/public/web/img/image_not_found_all.jpg"; 
															}
				
										?>' width="63px" height="63px"/></td>
				<td>
						<table width="100%">
								<tr>
									<td class="addItemRecipe"><?php echo $wishlistItems['title'];?></td>
									{{--<td class="addItemWeight" align="right">--}}
											<?php 
												 if(isset( $wishlistItems["product_code"])  && isset( $wishlistItems["product_code"]))
													echo $wishlistItems["product_code"];
											?>
									</td>	
								</tr>
								<tr>
									<td class="addItemRate"><?php echo $currency; ?>  <?php if(isset( $wishlistItems["price"])) echo $wishlistItems["price"];   ?></td>
									<td class="addItemMore" align="center">
											<a href="#" >
											<span style="font-size:75%;color:#000;margin-left: 50%;margin-bottom: 57%;" onclick="deleteWishlistProduct(<?php if(isset($wishlistItems['entity_id']))echo $wishlistItems['entity_id']; ?>,'{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}','{{route('add_to_wishlist')}}','{{route('delete_to_wishlist')}}' )" > <!--class="clancelItem" --> 
												<span class="icon-tt-close-icon"></span>
											</span>					  									
										</a>
									</td>
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
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  >Wishlist is empty</div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				You don't have any Wishlist items
			</div>
		</div>
<?php
	}
	
}
else
{
?>
		<div class="wishlist_empty nav nav-tabs" style="padding-top: 50%;">
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  >Wishlist is empty</div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				You don't have any Wishlist items
			</div>
		</div>
		
<?php
}

?>





