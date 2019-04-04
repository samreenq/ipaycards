
	@section("testimonial")
	<!-- Testimonial -->

                @if(isset($categories))
                    @foreach($categories as $category)

                        <?php

                       // echo "<pre>"; print_r($category);
                        //Get image of product
                        $gallery = isset($category->image) ? json_decode(json_encode($category->image)) : false;
                        $image = \App\Libraries\Fields::getCategoryImage($gallery,'compressed_file','web');
                        ?>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="product-wrap whitebg">
                        <img width="268px" height="221px"    src='<?php echo $image; ?>' class="img-responsive" />
                        <div class="product-detail">
                            <h4>
                                <a href="{!! url('/').'/product?category_id='.$category->category_id !!}" >
                                    <?php echo $category->title; ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>

                    @endforeach
                @endif



	@show