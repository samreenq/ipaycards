<?php
    if(isset($brands)){
?>
<div class="col-md-12 owl-carousel owl-theme brands_slide">
<?php
        foreach($brands as $brand){

//Get image of product
$gallery = isset($brand['gallery'][0]) ? json_decode(json_encode($brand['gallery'])) : false;
$image = \App\Libraries\Fields::getGalleryImage($gallery,'product','compressed_file');
        ?>


    <div class="product-wrap whitebg">
        <img width="268px" height="221px"    src='<?php echo $image; ?>' class="img-responsive" />
        <div class="product-detail">
            <h4>
                <a href="{!! url('/').'/product?brand_id='.$brand['entity_id'] !!}" >
                    <?php echo $brand['attributes']['title'];?>
                </a>
            </h4>
        </div>
    </div>

<?php
        } ?>
</div>
    <?php


    }


