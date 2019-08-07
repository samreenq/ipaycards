
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
					<td colspan="2"><img src="<?php echo $productItemsList['thumb'];?>" width="63"/></td>
					<td>
							<table width="100%">
								<tr>
										<td class="addItemRecipe">{{ $productItemsList['title'] }}</td>
										<td class="addItemWeight" align="right">{!! $productItemsList['product_code'] !!}
										</td>
										<td>
											<a href="#" >
												<span style="font-size:75%;color:#000;margin-left: 50%;margin-bottom: 57%;" onclick="deleteCartProduct('@if(isset($productItemsList['product_code'])){{$productItemsList['product_code']}}@endif','{{ route('add_to_cart') }}','{{ route('show_cart') }}','{{route('total_price')}}')" > <!--class="clancelItem" --> 
													<span class="icon-tt-close-icon"></span>
												</span>					  									
											</a>
										</td>
								</tr>
								<tr >
									<div class="row2" >
										<td class="addItemRate">
											<div class="left"><?php echo $currency; ?>  </div>
											<div class="right price{{ $n }}" > @if( isset($productItemsList['price']) && isset($productItemsList['product_quantity'])){{$productItemsList['price']*$productItemsList['product_quantity']}} @endif</div>
										</td>
										<td class="addItemMore" align="center">
											
											<div class="count-input space-bottom">		
										
												<a class="incr-btn incr-btn1  mrn text-right" data-action="decrease" href="#">
													<span class="icon-tt-minus-icon"></span>
												</a>
												
												<input class="product_code" type="hidden" name="code" value="@if( isset($productItemsList['product_code']) ){{$productItemsList['product_code']}}@endif"/>
												<input class="price_tmp" type="hidden" name="code" value="@if( isset($productItemsList['price']) && isset($productItemsList['product_quantity']) ) {{ $productItemsList['price'] * $productItemsList['product_quantity'] }} @endif"/>
												
												<input class="price_id" type="hidden" name="code" value="{{ $n }}"/>
												<input class="quantity{{ $n }}" type="number" name="quantity" value="@if(isset($productItemsList['product_quantity'])){{$productItemsList['product_quantity']}}@endif"/>
											
											
											
												<a class="incr-btn incr-btn1 mln text-left" data-action="increase"  href="#">
													<span class="icon-tt-plus-icon"></span>
												</a>

											</div>

										</td>


									</div>

								</tr>
							</table>


							<span style="display: block;font-weight: 400;color: #c2c5d1;font-size: 13px;"> <?php echo $currency; ?> @if(isset($productItemsList['price'])){{ $productItemsList['price']}}@endif each</span>




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
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  >Cart is empty</div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				You don't have any Cart items
			</div>
		</div>
<?php
	}
	
}
else
{
?>
		<div class="cart_empty nav nav-tabs" style="padding-top: 50%;">
			<div class="nav-link" style="padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;"  >Cart is empty</div>
			<div style="padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;"> 
				You don't have any Cart items
			</div>
		</div>
<?php
}

?>

