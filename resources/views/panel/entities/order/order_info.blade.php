<div class="row">
    <div class="col-md-6">
        <div class="panel panel-theme top mb25">
            <div class="panel-body p20 pb10">
                <table width="100%" class="orderPrevDetail">
                    <tr>
                        <td>Order #</td>
                        <td><b>{!! $order->order_number !!}</b></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td><b>{!! $order_date !!}</b></td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td><b>{!! $order_status !!}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-theme  top mb25">

            <div class="panel-body p20 pb10">
                <table width="100%" class="orderPrevDetail">
                    <tr>
                        <td>Customer Name</td>
                        <td><b>{!! $customer_name !!}</b></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><b>{!! $email !!}</b></td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td><b>{!! $phone !!}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@if(!empty($order->recipient_email))
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-theme top mb25">
            <div class="panel-body p20 pb10">
                <table width="100%" class="orderPrevDetail">
                    <tr>
                        <td>Recipient Name</td>
                        <td><b>{!! $order->recipient_name !!}</b></td>
                    </tr>
                    <tr>
                        <td>Recipient Email</td>
                        <td><b>{!! $order->recipient_email !!}</b></td>
                    </tr>
                    <tr>
                        <td>Recipient Message</td>
                        <td><b>{!! $order->recipient_message !!}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@if($order->payment_method_type->value == 'master_card')
    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-theme top mb25">
                <div class="panel-body p20 pb10">
                    <table width="100%" class="orderPrevDetail">
                        <tr>
                            <td>Payment Method</td>
                            <td><b><?php if($order->wallet > 0 && $order->payment_method_type->value != 'cod'){
                                       echo $order->payment_method_type->option.",".trans('system.ipay_wallet');

                            }
                                    else{
                                      echo  $order->payment_method_type->option;
                                    }
                                    ?>
                                    </b></td>
                        </tr>
                        <tr>
                            <td>Transaction #</td>
                            <td><b>{!! $order->transaction_id !!}</b></td>
                        </tr>
                        <tr>
                            <td>Transaction Order ID</td>
                            <td><b>{!! $order->lead_order_id !!}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-theme top mb25">
                <div class="panel-body p20 pb10">
                    <table width="100%" class="orderPrevDetail">
                        <tr>
                            <td>Card Name</td>
                            <td><b>{!! $order->card_id !!}</b></td>
                        </tr>
                        <tr>
                            <td>Card Type</td>
                            <td><b>{!! $order->card_type !!}</b></td>
                        </tr>
                        <tr>
                            <td>Card Last 4 Digits</td>
                            <td><b>{!! $order->card_last_digit !!}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif