<?php
$cartObj = $model["cartObj"] ?: null;
?>
<span class="drop-link">
    <span class="drop-label cart-popup-link">
        <span class="cart-widget-text">
            <?php echo($cartObj ? sizeof($cartObj["items"]) : 0) ?> Item | <?php echo($cartObj ? toPrice($cartObj["grandTotal"]) : "0.00").CURRENCY_SYMBOL ?>
        </span>
        <i class="fa fa-shopping-cart"></i>
    </span>
    <?php if (!is_null($cartObj) && sizeof($cartObj["items"]) > 0) {?>
        <div class="drop-child cart-list-popup" style="display: none" tabindex="-1">
            <table>
                <thead>
                <th class="item-name" width="60%">Name</th>
                <th class="item-quantity" width="15%">Qty</th>
                <th class="item-price" width="25%">Price</th>
                </thead>
                <tbody>
                <?php
                if (!is_null($cartObj)) {
                    foreach ($cartObj["items"] as $item) {
                        ?>

                        <tr class="item-row">
                            <td class="item-name"><?php echo $item['name']?></td>
                            <td class="item-quantity"><?php echo $item['quantity']?></td>
                            <td class="item-price"><?php echo toPrice($item['price'])?></td>
                        </tr>

                        <?php
                    }
                }
                ?>
                <tr class="last-row">
                    <td class="total" colspan="2">Total</td>
                    <td class="amount"><?php echo toPrice($cartObj['grandTotal']).CURRENCY_SYMBOL?></td>
                </tr>
                </tbody>
            </table>
            <div class="footer">
                <span class="sui-button link checkout" href="<?php echo getSiteUrl("checkout", "checkout") ?>">Checkout</span>
                <span class="sui-button link view-cart" href="<?php echo getSiteUrl("cart", "details") ?>">View Cart</span>
            </div>
        </div>
    <?php }?>
</span>

