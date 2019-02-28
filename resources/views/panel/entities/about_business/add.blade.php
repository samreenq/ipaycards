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
                        <span class="panel-title">{!! $page_action !!} {!! isset($entity_data->title) ? $entity_data->title : $module !!}</span>
                    </div>
                    <form  name="data_form" method="post" id="data_form">
                        <div class="panel-body dark">
                            <div class="main admin-form ">
                                @include(config('panel.DIR').'flash_message')
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                <div class="alert-message"></div>

                                @if(isset($entity_data->show_gallery) && $entity_data->show_gallery == 1)
                                    @include(config('panel.DIR').'entities/template/add_gallery')
                                    @else
                                    @include(config('panel.DIR').'entities/template/add_basic')
                                @endif

                                <?php if($entity_data->depend_entity_type > 0){ ?>

                                <input type="hidden" id="depend_entity_exist" name="depend_entity_exist" value="1" />

                                <div class="bulk_entity_wrap">

                                    <?php for($di= 0; $di <= 2; $di++){ ?>

                                    <div class="bulk_entity_raw border-wrap mb30" id="bulk_entity_raw_{!! $di !!}">

                                        <?php /*if($di != 0){ */?><!--
                                        <a style="float:right" class="fa fa-times delete-depend-entity" id="delete-depend-entity-{!! $di !!}" href="javascript:void(0);"></a>
                                            --><?php /*} */?>
                                       
                                        <input type="hidden" name="entity_type_id" id="entity_type_id" value="{!! $depend_entity_type_data->entity_type_id !!}" />
                                        <?php

                                        /*add hidden fields*/
                                        if(isset($depend_entity_hidden_records) && count($depend_entity_hidden_records)>0){
                                            foreach($depend_entity_hidden_records as $hidden_record){
                                                if($hidden_record->is_entity_column == 1){
                                                    echo $fields->randerEntityFields($hidden_record,$depend_entity_type_data,$depend_entity_type_data->entity_type_id);
                                                }else{
                                                    echo $fields->randerFields($hidden_record,$depend_entity_type_data,$depend_entity_type_data->entity_type_id);
                                                }
                                            }
                                        }?>

                                            @if(isset($depend_entity_type_data->show_gallery) && $depend_entity_type_data->show_gallery == 1)
                                                @include(config('panel.DIR').'entities/template/depend_add_gallery')
                                            @else
                                                @include(config('panel.DIR').'entities/template/depend_add_basic')
                                            @endif



                                    </div>
                                    <?php } ?>

                                </div>

                                <?php  } ?>

                                <div class="pull-right">
                                    <button type="submit" class="btn ladda-button btn-theme btn-wide" data-style="zoom-in"> <span class="ladda-label">Submit</span> </button>
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

        $('form[name="data_form"]').submit(function(e) {
            e.preventDefault();
            setFullName();
            Common.jsonValidation('<?=Request::url()?>', this,'',"<?php echo $entity_data->identifier ?>");
        });


         @if((isset($depend_entity_type_data->show_gallery) && $depend_entity_type_data->show_gallery == 1))
            <?php for($di= 0; $di <= 2; $di++){ ?>
                var gallery = {};
                loadFileUpload('bulk_entity_raw_{!! $di !!}',"{!! $di !!}",gallery);
                <?php } ?>
                @endif


        var entity_type_id = "{!! $entity_data->entity_type_id !!}";

        <?php if($entity_data->identifier != "customer"){ ?>

        if( $('#role_id').length > 0 && entity_type_id != ""){
            $('#role_id').empty();
            $('#role_id').append('<option value="">Select Role</option>');
            $.ajax({
                url: "<?php echo url('getRoleOptions'); ?>",
                dataType: "json",
                data: {"entity_type_id": entity_type_id},
                beforeSend: function () {
                    // $('#' + chosen_id).empty();
                }
            }).done(function (data) {
                $(data).each(function (index, ele) {
                    $('#role_id').append('<option value="' + ele.role_id + '">' + ele.title + '</option>');
                });
            });
        }

        <?php } ?>

        <?php if($entity_data->identifier == "inventory"){ ?>

             $('.title_field').hide();
             $('.description_field').hide();

            $("#vendor_id").on("change",function(){
                $('#title').val($("#vendor_id option:selected").text()+" inventory");
                console.log($('#title').val());
            });


        $( document ).on( "change", "#item_id", function() {
            var item_id = $(this).val();
            var entity_type_id = $(this).data("type_id");
            // console.log($(this).val());
            var selected_item =  $(this).parents('div.bulk_entity_raw').attr('id');
            // console.log(selected_item);

            if(item_id != ""){

                $.ajax({
                    url: "<?php echo url('getItemData'); ?>",
                    dataType: "json",
                    data: {"entity_id": item_id, "entity_type_id": entity_type_id},
                    beforeSend: function () {
                    }
                }).done(function (data) {
                    // console.log(data.length);
                    if(data.length >0){
                        var item = data[0];
                        $('#'+selected_item).find('#itemWrap').removeClass('hide');

                        $('#'+selected_item).find('select#item_unit').val(item.item_unit_value);
                        $('#'+selected_item).find('#itemWrap #item_code').text(item.item_code);
                        $('#'+selected_item).find('#itemWrap #item_category').text(item.category);

                        var label_class = "label.field-label";

                        if( $('#'+selected_item).find('.quantity_field .label_item_unit').length > 0){
                            $('#'+selected_item).find('.quantity_field .label_item_unit').text("");
                        }
                        else{
                            var new_text = "<span class='label_item_unit'></span>";
                            $('#'+selected_item).find('.quantity_field ' + label_class).append(new_text);
                        }

                        if( $('#'+selected_item).find('.wastage_field .label_item_unit').length > 0){
                            $('#'+selected_item).find('.wastage_field .label_item_unit').text("");
                        }
                        else{
                            var new_text = "<span class='label_item_unit'></span>";
                            $('#'+selected_item).find('.wastage_field ' + label_class).append(new_text);
                        }

                        $('#'+selected_item).find('.label_item_unit').text(" ("+item.item_unit+")");

                    }

                });
            }
        else{
            $('#'+selected_item).find('#itemWrap .item_value').text('');
            $('#'+selected_item).find('#itemWrap').addClass('hide');

        }


        });

         <?php } ?>

        <?php if($entity_data->identifier == "promotion_discount"){ ?>

             $( document ).on( "change", "#promotion_product_id", function() {
             var item_id = $(this).val();
             var entity_type_id = $(this).data("type_id");
             // console.log($(this).val());
             var selected_item =  $(this).parents('div.bulk_entity_raw').attr('id');
             // console.log(selected_item);

             if(item_id != ""){

                 $.ajax({
                     url: "<?php echo url('getProductData'); ?>",
                     dataType: "json",
                     data: {"entity_id": item_id, "entity_type_id": entity_type_id},
                     beforeSend: function () {
                     }
                 }).done(function (data) {
                     // console.log(data.length);
                     if(data.length >0){
                         var item = data[0];
                         $('#'+selected_item).find('#itemWrap').removeClass('hide');
                         $('#'+selected_item).find('#itemWrap #item_price').text(item.price);
                         $('#'+selected_item).find('#itemWrap #item_code').text(item.item_code);
                         $('#'+selected_item).find('#itemWrap #item_category').text(item.category);

                     }

                 });
             }
             else{
                 $('#'+selected_item).find('#itemWrap .item_value').text('');
                 $('#'+selected_item).find('#itemWrap').addClass('hide');

             }


         });
         <?php } ?>

    });



</script>
@include(config('panel.DIR').'footer')
