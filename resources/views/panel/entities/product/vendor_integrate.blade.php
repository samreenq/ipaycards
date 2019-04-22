@include(config('panel.DIR').'header')
<?php
$fields = "App\Libraries\Fields";
$fields = new $fields();


?>
<!-- Begin: Content -->
<section id="content_wrapper" class="content">
    <section id="content" >
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-theme panel-border top mb25">
                    <div class="panel-heading">
                        <span class="panel-title">{!! $page_action !!}</span>
                    </div>
                    <form  name="data_form" method="post" id="data_form">
                        <div class="panel-body dark p20">
                            <div class="main admin-form ">
                                @include(config('panel.DIR').'flash_message')
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif

                                <div class="alert-message"></div>

                                <div class="row entity_wrap mb20" id="entity_data">

                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                                    <input type="hidden" name="do_post" value="1" />
                                    <input type="hidden" name="vendor_id" id="vendor_id" value="{!! $vendor_id !!}" />
                                    @if(isset($categories))
                                        <div class="section mb10 col-md-6 category_id_field ">
                                            <label data-toggle="tooltip"
                                                   class="field-label cus-lbl  field-label cus-lbl" title="">Category&nbsp;*</label>
                                            <label class="field">
                                                <select id="category_id"
                                                        class="field_dropdown form-control select2-field"
                                                        name="category_id" data-type_id="14" data-attribute_code="25"
                                                        style="display: none;">
                                                    <option value="">-Select Category-</option>
                                                    @foreach($categories as $category)
                                                        <option value="{!! $category->category_id !!}">{!! $category->category_name !!}</option>
                                                    @endforeach
                                                </select>
                                                <i class="arrow"></i></label>
                                        </div>
                                        @endif

                                    @if(isset($brands))
                                        <div class="section mb10 col-md-6 brand_id_field ">
                                            <label data-toggle="tooltip"
                                                   class="field-label cus-lbl  field-label cus-lbl" title="">Brands&nbsp;*</label>
                                            <label class="field">
                                                <select id="brand_id"
                                                        class="field_dropdown form-control select2-field"
                                                        name="brand_id" data-type_id="14" data-attribute_code="25"
                                                        style="display: none;">
                                                    <option value="">-Select Brands-</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{!! $brand->brand_id !!}">{!! $brand->brand_name !!}</option>
                                                    @endforeach
                                                </select>
                                                <i class="arrow"></i></label>
                                        </div>
                                    @endif

                                    <div class="section mb10 col-md-6 product_id_field ">
                                        <label data-toggle="tooltip"
                                               class="field-label cus-lbl  field-label cus-lbl" title="">Products&nbsp;*</label>
                                        <label class="field">
                                            <select id="product_id"
                                                    class="field_dropdown form-control select2-field"
                                                    name="product_id" data-type_id="14" data-attribute_code="25"
                                                    style="display: none;">
                                                <option value="">-Select Product-</option>
                                                @if(count($products)>0)
                                                    @foreach($products as $product)
                                                        <option value="{!! $product->denomination_id !!}">{!! $product->denomination_name !!}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                            <i class="arrow"></i></label>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
<!-- End: Content -->
<!-- Begin: Page Footer -->
@include(config('panel.DIR') . 'footer_bottom')
</section>
<!-- End: Page Footer -->

<script type="text/javascript">

    $(function () {

        $('#category_id').on('change',function(){

            $.ajax({
                type: "GET",
                url: "<?php echo url('vendor_products'); ?>?vendor_id="+$('#vendor_id').val(),
                dataType: "json",
                data: { "category_id": $(this).val()},
                success: function (data) {

                    if(data.error == 1){
                        $('.alert-message').html(alertMsg(data.message));
                    }
                    else{
                        $(data.data).each(function (index, ele) {
                            $('#brand_id').append('<option value="' + ele.brand_id + '">' + ele.brand_name + '</option>');
                        });
                        $("#brand_id").trigger("chosen:updated");

                    }
                }
            });
        });

        $('#brand_id').on('change',function(){

            $.ajax({
                type: "GET",
                url: "<?php echo url('brand_products'); ?>",
                dataType: "json",
                data: {"vendor_id": $('#vendor_id').val(), "brand_id": $(this).val() },
                success: function (data) {

                    if(data.error == 1){
                        $('.alert-message').html(alertMsg(data.message));
                    }
                    else{

                        $(data.data).each(function (index, ele) {
                            $('#product_id').append('<option value="' + ele.denomination_id + '">' + ele.denomination_name + '</option>');

                        });
                        $("#product_id").trigger("chosen:updated");

                    }
                }
            });
        });

    });

    </script>
@include(config('panel.DIR').'footer')