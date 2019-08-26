<?php

	foreach ( $menus as $row ) 
	{
		if($row['parent_id']==0)
		{
			$class = '';

			if(isset($category_id)){
				//request category is parent leave existing condition//
				if(isset($requested_category)){
					if($requested_category->is_parent == 1 && $row['category_id']==$category_id ){
						$class = 'class="active"';
					}
					//if request category is not prent then match row category id with request category parent
					elseif($requested_category->is_parent == 0 && $row['category_id']==$requested_category->parent_id){
						$class = 'class="active"';
					}
				}
			}




?>
						
			<li <?php echo $class; ?>
				>
				<a href=" {{ url('/').'/product?entity_type_id=14&category_id='.$row['category_id']}} ">{{ $row['title'] }} </a></li>
<?php 		
		}
	}

	?>
{{--<li><a href=" {{ url('/').'/product?entity_type_id=14&category_id=7'}} ">Deals</a></li>--}}
		
								