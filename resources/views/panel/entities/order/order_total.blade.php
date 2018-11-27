
<?php
        if(isset($is_update_order)){
            if(isset($data['order'])){
              //  print_r($data['order']); exit;
                $order = (object)$data['order'];
            }
        }

    $discount = (isset($order->discount) && $order->discount > 0) ? $order->discount : "0.00";
    //$estimated_minutes = isset($order->estimated_minutes) ? $order->estimated_minutes : "";

    $subtotal = isset($order->subtotal) ? $order->subtotal : 0;
    $grand_total = (isset($order->grand_total) && $order->grand_total > 0) ? $order->grand_total : 0;
    $payment_method_fee = (isset($order->payment_method_fee) && $order->payment_method_fee > 0) ? $order->payment_method_fee : 0;
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
                <td align="right"><b><span>$</span><span>{!! $subtotal !!}</span></b></td>
            </tr>
            <tr>
                <td>Discount</td>
                <td align="right"><b><span>$</span><span>{!! $discount !!}</span></b></td>
            </tr>
            <tr>
                <td>Grand Total</td>
                <td align="right"><b><span>$</span><span>{!! $grand_total !!}</span></b></td>
            </tr>
        </table>
