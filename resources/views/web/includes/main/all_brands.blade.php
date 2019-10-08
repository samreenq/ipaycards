<?php
if(isset($brands)){

foreach($brands as $brand){

//Get image of product
$gallery = isset($brand['gallery'][0]) ? json_decode(json_encode($brand['gallery'])) : false;
$image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
?>
<div class="col-xs-12 col-sm-6 col-lg-3 d-flex">
    <div class="product-wrap whitebg">
        <a href="{!! url('/').'/product?brand_id='.$brand['entity_id'] !!}" >
        <img width="268px" height="221px"    src='<?php echo $image; ?>' class="img-responsive" />
        <div class="product-detail">
            <h4>

                    <?php echo $brand['attributes']['title'];?>

            </h4>
        </div>
        </a>
    </div>
</div>

<?php
}
}
