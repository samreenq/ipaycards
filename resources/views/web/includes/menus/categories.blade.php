



<?php

	foreach ( $categories as $tmp ) 
	{
		if($tmp['category_id']==$category_id)
			if($tmp['parent_id']!=0 )
				$category_id = $tmp['parent_id'];
	}


	foreach ( $categories as $main_Categories ) 
	{
		if($main_Categories['parent_id']==$category_id)
		{
		    if($main_Categories['status'] != 1) continue;
?>
			<li class="vegePanel panel">
				<a <?php if(isset($_REQUEST['category_id'])) if($_REQUEST['category_id']==$main_Categories['category_id'] )echo "style='color:#72cbb1'" ?>href=" {{ url('/').'/product?entity_type_id=14&category_id='.$main_Categories['category_id'] }} "><?php echo $main_Categories['title']." ( ".$main_Categories['product_count']." ) "; ?> </a> 
			</li>
<?php 	
		}
		
	}
	?>
	

<?php 

exit;
$jsonString = '[{"id":1,"children":[{"id":3,"children":[{"id":9,"children":[{"id":8}]}]}]},{"id":10,"children":[{"id":11,"children":[{"id":13}]},{"id":12}]}]';
$jsonArray = json_decode($jsonString);



function buildTree($arr, $parent = 0, $indent = 0)
{
	
	echo '<ul class="abc">';
			foreach($arr as $item)
			{
				if ($item["parent_id"] == $parent)
				{
					echo '<li  class="  category_id'.$item["category_id"].'  parent_id'.$item['parent_id'].'" >';
						echo '<a href="'.url('/').'/product?entity_type_id=14&category_id='.$item['category_id'].'">'.$item['title'].'</a>';
					    echo "(".$item['product_count'].")";
							buildTree($arr, $item['category_id'], $indent + 2);


					echo '</li>';
				}
			}
	echo '</ul>';
}

buildTree($categories);
		
	?>
	
	

	
	
	
	
	
	
		<div class="fly-nav-inner">
			<div class="container">
				<button class="dropdown-toggle" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></button>
				<div id="productCateSideWrap" class="dropdown-menu mega-dropdown-menu">
					<ul class="vegeListWrap sidebar__inner p20" id="accordion1">
						
						<li class="vegePanel panel"> <a data-toggle="collapse" class="collapsed" data-parent="#accordion1" href="#flowers">Flowers<span> (25)</span></a>
							<ul id="flowers" class="collapse">
								<li class="li-active"><a href="#">Cucumbers & Zucchini</a></li>
								<li class="li-active"><a href="#">Tomatoes & Peppers</a></li>
								<li class="li-active"><a href="#">Broccoli & Celery</a></li>
								<li class="li-active"><a href="#">Spring Vegetables</a></li>
								<li class="li-active"><a href="#">Potatoes & Beets</a></li>
								<li class="li-active"><a href="#">Squash</a></li>
							</ul>
						</li>
						
					</ul>
				</div>
			</div>
		</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<!--
	
	<li class="vegePanel panel">
		<a data-toggle="collapse" class="collapsed" data-parent="#accordion1" href="#flowers">
				Flowers<span> (25)</span>
		</a>
		<ul id="flowers" class="collapse ">
			<li class="li-active"><a href="#">Cucumbers & Zucchini</a></li>
			<li class="li-active"><a href="#">Tomatoes & Peppers</a></li>
			<li class="li-active"><a href="#">Broccoli & Celery</a></li>
			<li class="li-active"><a href="#">Spring Vegetables</a></li>
			<li class="li-active"><a href="#">Potatoes & Beets</a></li>
			<li class="li-active"><a href="#">Squash</a>
			</li>
		</ul>
	</li>	
	
	<li class="vegePanel panel"> <a data-toggle="collapse" class="collapsed" data-parent="#accordion1" href="#herbs">Herbs <span> (225)</span></a>
											<ul id="herbs" class="collapse">
												<li class="li-active"><a href="#">Cucumbers & Zucchini</a></li>
											</ul>
										</li>
	-->	
