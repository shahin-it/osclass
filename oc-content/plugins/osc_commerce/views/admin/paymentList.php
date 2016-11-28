<?php
$payments= $model['payments'];
?>
<div id="payment-tab" class="sui-single-tab row-wrapper">
    <div class="tab-toolbar">
        <div class="tool-left">
            <span class="tool-item">
                <h3 class="tab-title render-title">Manage Categories</h3>
            </span>
        </div>
        <div class="tool-right">
            <span class="tool-item">
                <input type="text" class="input-text search-text">
                <button type="button" class="btn btn-mini tab-search"><i class="fa fa-search"></i></button>
            </span>
            <span class="tool-item">
                <button type="button" class="tab-reload btn btn-mini" title="Reload"><i class="fa fa-refresh"></i></button>
            </span>
        </div>
    </div>

    <div class="sui-table relative">
        <table class="">
            <tr>
                <th class="select-column"><input type="checkbox"></th>
                <th class="id actions-column">Id</th>
                <th class="id">Order Id</th>
                <th class="date">Payment Date</th>
                <th class="email">Payee</th>
                <th class="gateway">Gateway</th>
                <th class="amount">Total</th>
                <th class="status">Status</th>
            </tr>
            <?php foreach($payments as $payment) {?>
            <tr>
                <td class="select-column"><input type="checkbox"></td>
                <td class="id actions-column ">
                    <div class="value"><?php echo $payment['pk_pay_id']?></div>
                    <div class="navigator" data-name="<?php echo $payment['s_name']?>" data-id="<?php echo $payment['pk_c_id']?>">
                        <i class="fa fa-times cancel-payment" title="Cancel payment"></i>
                        <i class="fa fa-check accept-payment" title="Accept payment"></i>
                    </div>
                </td>
                <td class="id"><?php echo $payment['fk_o_id']?></td>
                <td class="date"><?php echo $payment['dt_created']?></td>
                <td class="email"><?php echo $payment['s_customer_email']?></td>
                <td class="gateway"><?php echo $payment['s_gateway_name']?></td>
                <td class="amount"><?php echo toPrice($payment['d_payment_total'])?></td>
                <td class="status"><i class="fa <?php echo($payment['b_order_status'] == "pending" ? "fa-ban" : "fa-check")?>"></i></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>