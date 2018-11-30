<?php
$order_id = $data['order']->entity_id;
$order = $data['order']->attributes;
$order_status = $data['order']->attributes->order_status->id;
$status_keyword = $data['order']->attributes->order_status->detail->attributes->keyword;
$driver_id = isset($data['order']->attributes->driver_id->id) ? $data['order']->attributes->driver_id->id : "";
$driver_name = isset($data['order']->attributes->driver_id->value) ? $data['order']->attributes->driver_id->value : "";

$vehicle_id = isset($data['order']->attributes->vehicle_id->id) ? $data['order']->attributes->vehicle_id->id : "";
//echo "<pre>"; print_r($data['order']->attributes->driver_id); exit;
$is_hide = '';
if(in_array($status_keyword,array('pending'))){
    $is_hide = 'hide';
}

$is_disabled = 'disabled';
if(in_array($status_keyword,array('confirmed','declined'))){
    $is_disabled = '';
}

$pending_arr = array('pending','payment_received','cancelled');
$confirmed_arr = array('pending','cancelled');
$primary_statuses = array('pending','payment_received');

?>


<div class="tab-content row br-n admin-form">

    @if(isset($data['warning']) && !empty($data['warning']))
        <div class="alert alert-warning">{!! $data['warning'] !!}</div>
        @endif


    <input type="hidden" name="order_id" id="order_id" value="{!! $order_id !!}" />
<div class="section mb10 col-md-6 truck_class_field ">
    <label title="" class="field-label  field-label cus-lbl" data-toggle="tooltip">Status&nbsp;*</label>
    <label class=" field select ">
        <select class=" field_dropdown2 form-control" id="order_status" name="order_status">
            <option value="">-- Select Status --</option>

            <?php
            //echo "<pre>"; print_r($data['order']); exit;
            ?>
            <?php if($data['status_list'] && count($data['status_list']) > 0){ ?>
                <?php  foreach($data['status_list'] as $status){

                       $disabled_option = $selected = "";
                        if($order_status == $status->entity_id){
                           // $status_keyword = $status->keyword;
                           $selected = 'selected="selected"';
                           $disabled_option = "disabled";
                        }

                        if($status_keyword == 'pending' && !in_array($status->keyword,$pending_arr)){
                                continue;
                        }

                        else if($status_keyword == 'payment_received' && in_array($status->keyword,$confirmed_arr)){
                                continue;
                        }

                        else if(!in_array($status_keyword,$primary_statuses) && in_array($status->keyword,$primary_statuses)){
                            continue;
                        }

                    ?>
                    <option  {!! $disabled_option !!} <?php if(!empty($selected)){ ?> {!! $selected !!}<?php } ?> value="{!! $status->entity_id !!}">{!! $status->title !!}</option>
                <?php  }  } ?>

        </select><i class="arrow"></i></label>
</div>


    <div class="section mb10 col-md-6 description_field ">
        <label title="" class="field-label cus-lbl  field-label cus-lbl">Comments</label>
        <label class=" field"><textarea placeholder="" class="gui-textarea" name="comment" id="comment"></textarea>
        </label>
    </div>

    <div id="vehicleInfo"  class="col-md-12">
    </div>

</div>