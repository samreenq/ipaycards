<?php 

	foreach ( $menus as $row ) 
	{
		if($row['parent_id']==0)
		{

		    //request category is parent leave existing condition


		//if request category is not prent then match row category id with request category parent



?>
						
			<li <?php if(isset($category_id))  if($row['category_id']==$category_id ) echo 'class="active"'; else echo "asas"; ?>
				>
				<a href=" {{ url('/').'/product?entity_type_id=14&category_id='.$row['category_id']}} ">{{ $row['title'] }} </a></li>
<?php 		
		}
	}

	?>
{{--<li><a href=" {{ url('/').'/product?entity_type_id=14&category_id=7'}} ">Deals</a></li>--}}
		
								