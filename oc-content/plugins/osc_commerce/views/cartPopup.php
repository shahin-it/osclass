<?php
$cartObj = $model["cartObj"] ?: null;
?>
<span class="drop-link">
    <span class="drop-label cart-popup-link">
        <span class="cart-widget-text">
            <?php echo($cartObj ? sizeof($cartObj["items"]) : 0) ?>
            Item | <?php echo ($cartObj ? toPrice($cartObj["grandTotal"]) : "0.00") . CURRENCY_SYMBOL ?>
        </span>
        <i class="fa fa-shopping-cart"></i>
    </span>
    <?php if (!is_null($cartObj) && sizeof($cartObj["items"]) > 0) { ?>
        <div class="drop-child cart-popup-wrap cart-list-popup" style="display: none" tabindex="-1">
            <div class="cart-popup">
                <?php
                if (!is_null($cartObj)) {
                    foreach ($cartObj["items"] as $item) {
                        ?>
                    <div class="cart-popup-item">
                        <div class="product-image">
                            <img src="<?php echo getAppUtil()->getBaseProductImage($item["id"], $item["image"], "small")?>" alt="Product Image"/>
                        </div>
                        <div class="product-info">
                            <div class="product-name"><?php echo $item['name']?></div>
                            <div class="product-quantity"><?php echo $item['quantity']?></div>
                            <div class="product-price"><?php echo toPrice($item['price']).CURRENCY_SYMBOL?></div>
                        </div>
                        <span class="remove remove-cartitem" data-id="<?php echo $item["id"]?>"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="btn-row">
                <span class="btn link view-cart" href="<?php echo getSiteUrl("cart", "details") ?>">View Cart</span>
                <span class="btn link checkout" href="<?php echo getSiteUrl("checkout", "checkout") ?>">Checkout</span>
            </div>
        </div>
    <?php } ?>
</span>

