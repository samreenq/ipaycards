@include(config('panel.DIR').'header')
<?php
$fields = "App\Libraries\Fields";
$fields = new $fields();
?>
<!-- Begin: Content -->

<section id="content_wrapper" class="content">
    <section id="content" class="table-layout animated fadeIn">

        <!-- begin: .tray-center -->
        <div class="tray tray-center p25 va-t posr">

            <div class="panel panel-theme panel-border top mb25">
                <div class="panel-heading">
                    <span class="panel-title">{!! $page_action !!} {!! isset($entity_data->title) ? $entity_data->title : $module !!}</span>
                </div>
                <div class="panel-body p20 pb10">
                    <form  name="data_form" method="post" id="data_form" class="panel-collapse collapse in">
                        <div class="tab-content pn br-n admin-form">
                            @include(config('panel.DIR').'flash_message')
                            @if (Session::has('message'))
                                <div class="alert alert-info">{{ Session::get('message') }}</div>
                            @endif
                            <div class="alert-message"></div>

                            <div class="row entity_wrap" id="entity_data">

                                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                                <input type="hidden" name="do_post" value="1" />
                                <input type="hidden" name="language_file" id="language_file" value="" />
                                <?php
                                if (isset($records[0])) {
                                foreach ($records as $record) {
                                $field_class = $record->name.'_field';
                                ?>
                                <?php if($record->element_type != "hidden"){ ?>
                                <div class="section mb10 col-md-6 {!! $field_class !!}">
                                    <?php } ?>
                                    <?php
                                    if($record->element_type=='text') $record->element_type='input';
                                    echo $fields->randerFields($record,$update);
                                    ?>
                                    <?php if($record->element_type != "hidden"){ ?>
                                </div>
                                <?php } ?>
                                <?php }
                                }
                                ?>

                            </div>

                            <div class="pull-right p-relative">
                                @if($uri_method != 'view' )
                                    <button type="submit" class="btn ladda-button btn-theme btn-wide mt10" data-style="zoom-in"> <span class="ladda-label">Submit</span> </button>
                                    @include(config('panel.DIR').'entities.loader')
                                @else
                                    <a href="../update/{{ $update->language_id }}" type="submit" class="btn ladda-button btn-theme btn-wide mt10" data-style="zoom-in"> <span class="ladda-label">Edit Record</span> </a>
                                @endif
                            </div>
                            <!-- end section row section -->
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
        // default form submit/validate
        $('form[name="data_form"]').submit(function (e) {
            e.preventDefault();
            // hide all errors
            $("div[id^=error_msg_]").removeClass("show").addClass("hide");
            // validate form
            Common.jsonValidation('<?=Request::url()?>', this,'',"language");
        });

        <?php if(isset($update->data->role)){ ?>
        //   $("#entity_type_id").attr("disabled");
        //$("#entity_type_id").prop("disabled", true);
       // $('#div_entity_type_id').addClass('hide');
        <?php } ?>

        if($('#div_parent_id').length > 0){
            $('#div_parent_id').hide();
        }

        $('.attachment-field').each(function(k,v){

            console.log($(this).attr('id'));
            var gallery_id = $(this).data('id');
            var id = $(this).attr('id');

            var iid = "#gallery_"+gallery_id;
            var field_hidden = "input[id='"+gallery_id+"']";

            console.log(iid);
            var baseUrl = "";
            var token = "{{ Session::getToken() }}";
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("div"+iid, {

                url: baseUrl + "{!! URL::to('/api/system/attachment/save') !!}",
                addRemoveLinks: true,
                maxFiles:1,
                dictRemoveFileConfirmation:  "Are you sure you want to remove?",
                params: {
                    _token: token,
                    attachment_type_id: 9,
                    entity_type_id:""
                }
            });
            var numItems = 0;
            var attch_id = '';
            myDropzone.on("success", function(file,responseText) {

                $('.alert-message').html('');
                var image_response = $.parseJSON(responseText.jsonEditor);
                if(image_response.error == 1){
                    // $('.dz-preview').remove();
                    showAlert(image_response.message);
                    this.removeFile(file);
                }
                else{
                    attch_id = image_response.data.attachment.attachment_id;
                }
                //console.log($.parseJSON(responseText.jsonEditor).data.attachment.attachment_id);
                //$('.dz-complete').eq(numItems).append('<input type="checkbox" onClick="isfeatured()">');
                //numItems++;
                myDropzone.processQueue();
            });

            myDropzone.on("complete", function() {

                // $('.dz-remove').addClass('dz-file-upload');
                console.log(attch_id);
                // $('.dz-complete').append('<div class="pull-right"><input type="hidden" name="file" value="'+attch_id+'"></div>');
                $(field_hidden).val(attch_id);
                $('#'+id+' .dz-remove').attr('data-attachment-id',attch_id);
                $('#submit-btn').removeClass('hide');
                /* setTimeout(function(){
                     $('.dz-complete').eq(numItems).append('<input type="radio" name="gallery_featured_item" value="'+attch_id+'">');

                     numItems++;

                 }, 3000);*/


            });


            myDropzone.on("removedfile", function(file) {
                // console.log(file);
                //console.log(file._removeLink.attributes['data-attachment-id']);
                var attach_attr = file._removeLink.attributes['data-attachment-id'];
                var file_id = attach_attr.nodeValue;
                if(file_id != ""){
                    $.ajax({
                        url: "<?php echo url('/api/system/attachment/delete'); ?>",
                        dataType: "json",
                        data: {"attachment_id": file_id},
                        beforeSend: function () {
                        }
                    }).done(function (data) {
                        $(field_hidden).val('');
                        $('#'+id).find('.dz-preview').remove();
                        $('#submit-btn').addClass('hide');
                    });
                }

            });


            if($.trim(gallery_id) == 'validation_file'){

                        @if(isset($validation_file->file))
                    <?php
                    $image_name = ''; $image_size = '';
                    if (isset($validation_file->data_packet)) {
                        $data_packet = json_decode($validation_file->data_packet, true);
                        $image_name = $data_packet['name'];
                        $image_size = $data_packet['size'];
                    }
                    ?>
                var mockFile = {name: "{!! $image_name !!}", size: "{!! $image_size !!}"};
                myDropzone.emit("addedfile", mockFile);

                $('#gallery_'+ gallery_id + ' .dz-remove').attr('data-attachment-id', "{!! $validation_file->attachment_id !!}");
                @if($uri_method == 'view' )
                $('#gallery_'+ gallery_id + ' .dz-remove').addClass('hide');
                @endif
                @endif
            }else {
                        @if(isset($attachment->file))
                    <?php
                    $image_name = ''; $image_size = '';
                    if (isset($attachment->data_packet)) {
                        $data_packet = json_decode($attachment->data_packet, true);
                        $image_name = $data_packet['name'];
                        $image_size = $data_packet['size'];
                    }
                    ?>
                var mockFile = {name: "{!! $image_name !!}", size: "{!! $image_size !!}"};
                myDropzone.emit("addedfile", mockFile);

                $('#gallery_'+ gallery_id + ' .dz-remove').attr('data-attachment-id', "{!! $attachment->attachment_id !!}");
                @if($uri_method == 'view' )
                $('#gallery_'+ gallery_id + ' .dz-remove').addClass('hide');
                @endif
                @endif
            }



        });



    });
</script> 
@include(config('panel.DIR').'footer')