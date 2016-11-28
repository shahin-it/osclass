<?php
$orders = $model['orders'];
?>
<div id="order-tab" class="sui-single-tab row-wrapper">
    <div class="tab-toolbar">
        <div class="tool-left">
            <span class="tool-item">
                <h3 class="tab-title render-title">Manage Orders</h3>
            </span>
        </div>
        <div class="tool-right">
            <span class="tool-item">
                <input type="text" class="input-text search-text">
                <button type="button" class="btn btn-mini tab-search"><i class="fa fa-search"></i></button>
            </span>
            <span class="tool-item">
                <a class="add-new btn btn-mini" href="#" title="Add new"><i class="fa fa-plus-circle"></i></a>
            </span>
            <span class="tool-item">
                <button type="button" class="tab-reload btn btn-mini" title="Reload"><i class="fa fa-refresh"></i></button>
            </span>
        </div>
    </div>

    <div class="sui-table relative">
        <table class="sui-accordion-panel">
            <tr>
                <th class="select-column"><input type="checkbox"></th>
                <th class="id">Id</th>
                <th class="name actions-column">Customer Name</th>
                <th class="email">Email</th>
                <th class="date">Created</th>
                <th class="status">Status</th>
                <th class="total">Order Total</th>
            </tr>
            <?php foreach($orders as $order) {?>
            <tr class="sui-accordion-label">
                <td class="select-column"><input type="checkbox"></td>
                <td class="id"><?php echo $order['pk_o_id']?></td>
                <td class="actions-column name">
                    <div class="value"><?php echo $order['s_customer_name']?></div>
                    <div class="navigator" data-name="<?php echo $order['s_customer_name']?>" data-id="<?php echo $order['pk_o_id']?>">
                        <i class="fa fa-pencil edit" title="Edit"></i>
                        <i class="fa fa-dollar payment-list" data-href="<?php echo osc_route_admin_url('commerce-route',
                            array('controller'=>'orderAdmin', 'trigger'=>'paymentList'))."&orderId=".$order['pk_o_id'] ?>" title="Payments"></i>
                        <i class="fa fa-times cancel" title="Cancel"></i>
                    </div>
                </td>
                <td class="email"><?php echo $order['s_customer_email']?></td>
                <td class="date"><?php echo $order['dt_created']?></td>
                <?php $status=array("pending"=>"fa-hourglass-half", "completed"=>"fa-check", "cancel"=>"fa-ban")?>
                <td class="status"><i title="<?php echo $order['s_order_status']?>" class="fa <?php echo($status[$order['s_order_status']])?>"></i></td>
                <td class="total"><?php echo toPrice($order['d_order_total']).CURRENCY_SYMBOL?></td>
            </tr>
            <?php if(count($order["items"])){?>
                <tr class="sui-accordion-item">
                    <td colspan="7">
                        <table>
                            <tr>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Item Price</th>
                            </tr>
                            <?php foreach($order["items"] as $item) {?>
                                <tr>
                                    <td><?php echo $item['pk_item_id']?></td>
                                    <td><?php echo $item['s_name']?></td>
                                    <td><?php echo toPrice($item['d_price']).CURRENCY_SYMBOL?></td>
                                </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
            <?php }?>
            <?php }?>
        </table>
    </div>
</div>