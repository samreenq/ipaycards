<?php
        if(isset($is_update_order)){
            if(isset($data['order'])){
              //  print_r($data['order']); exit;
                $order = (object)$data['order'];
            }
        }

    $discount = (isset($order->discount_amount) && $order->discount_amount > 0) ? $order->discount_amount : "0.00";
    //$estimated_minutes = isset($order->estimated_minutes) ? $order->estimated_minutes : "";

    $subtotal = isset($order->subtotal) ? $order->subtotal : 0;
    $grand_total = (isset($order->grand_total) && $order->grand_total > 0) ? $order->grand_total : 0;
    $payment_method_fee = (isset($order->payment_method_fee) && $order->payment_method_fee > 0) ? $order->payment_method_fee : 0;
    $wallet = isset($order->wallet) ? $order->wallet : 0;
    $card = isset($order->paid_amount) ? $order->paid_amount : 0;

    ?>

<?php

        if(isset($data['warning']) && $data['warning'] == 1){
            ?>
            <div class="alert alert-warning">{!! $data['warning_message'] !!}</div>
        <?php
              }
        ?>

        <table width="100%" class="table orderPrevDetail">
            <tr>
                <td>Subtotal</td>
                <td align="right"><b><span>{!! $currency !!}</span>&nbsp;<span>{!! $subtotal !!}</span></b></td>
            </tr>
            <tr>
                <td>Discount</td>
                <td align="right"><b><span>{!! $currency !!}</span>&nbsp;<span>{!! $discount !!}</span></b></td>
            </tr>

            <tr>
                <td>iPay Wallet</td>
                <td align="right"><b><span>{!! $currency !!}</span>&nbsp;<span>{!! $wallet !!}</span></b></td>
            </tr>
            <tr>
                <td>Master Card</td>
                <td align="right"><b><span>{!! $currency !!}</span>&nbsp;<span>{!! $card !!}</span></b></td>
            </tr>
            <tr>
                <td>Grand Total</td>
                <td align="right"><b><span>{!! $currency !!}</span>&nbsp;<span>{!! $grand_total !!}</span></b></td>
            </tr>
        </table>
