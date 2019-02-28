<?php 

	foreach ( $menus as $row ) 
	{
		if($row['parent_id']==0 && $row['product_count'] > 0)
		{
			
?>
						
			<li <?php if(isset($category_id))  if($row['category_id']==$category_id ) echo 'class="active"'; else echo "asas"; ?>
				>
				<a href=" {{ url('/').'/product?entity_type_id=14&category_id='.$row['category_id']}} ">{{ $row['title'] }} </a></li>
<?php 		
		}
	}
	
	?>
		
								