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


    <div class="product-wrap lightgreybg">
        <a href="{!! url('/').'/product?brand_id='.$brand['entity_id'] !!}" >
        <img src='<?php echo $image; ?>' class="img-responsive" />
        </a>
        <div class="product-detail br_p_d">
            <h4>
                <a href="{!! url('/').'/product?brand_id='.$brand['entity_id'] !!}" >
                    <?php echo $brand['attributes']['title'];?>
                    <span class="lnr lnr-arrow-right"></span>
                </a>
            </h4>

        </div>
    </div>

<?php
        } ?>
</div>
    <?php


    }


