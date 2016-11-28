<?php
$cartObj = $model["cartObj"] ?: null;
?>
<div class="osc-ec-template cart-details-page">
    <?php
    if (!is_null($cartObj) && sizeof($cartObj["items"]) > 0) {
        ?>
    <div class="shopping-cartitem ">
        <div class="header-wrapper">
            <h1 class="page-heading">Shopping Cart</h1>
        </div>
        <div class="cartitem-btn-wrapper top">
            <a class="empty-cartitem-btn button" href="<?php echo getSiteUrl("cart", "empty") ?>">Empty Cart</a>
            <span class="update-cartitem-btn button" style="display: none">Update Cart</span>
        </div>
        <table class="cartitem-table">
            <thead>
            <tr>
                <th width="5%"></th>
                <th width="5%" class="image">Image</th>
                <th width="35%" class="product-name">Product Name</th>
                <th width="15%" class="unit-price">Price</th>
                <th width="10%" class="quantity">Quantity</th>
                <th width="15%" class="price">Amount</th>
            </tr>
            </thead>
            <tbody>
        <?php foreach($cartObj["items"] as $product) { ?>
            <tr class="odd cart-item ">
                <td class="actions remove">
                    <span class="fa fa-trash remove-cartitem" title="Remove" data-id="<?php echo $product["id"]?>"></span>
                </td>
                <td class="image">
                    <div class="product-image small">
                        <a href="<?php echo getSiteUrl("items", "product-details")."?id=".$product["id"] ?>">
                            <img class="product-thumb-image" src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>" alt="<?php echo $product['name']?>">
                        </a>
                    </div>
                </td>
                <td class="product-name">
                    <a href="<?php echo getSiteUrl("items", "product-details")."?id=".$product["id"] ?>"><?php echo $product['name']?></a>
                </td>
                <td class="unit-price"><?php echo toPrice($product["rate"]).CURRENCY_SYMBOL?></td>
                <td class="quantity">
                    <input type="number" data-id="<?php echo $product["id"]?>" class="quantity-spinner" value="<?php echo $product["quantity"]?>" min="1"/>
                </td>
                <td class="price"><?php echo toPrice($product["price"]).CURRENCY_SYMBOL?></td>
            </tr>
        <?php }?>
            </tbody>
        </table>
        <div class="shopping-cart-total">
            <div class="left-column">
            </div>
            <div class="right-column">
                <table>
                    <tbody>
                    <tr class="sub-total-row">
                        <td class="total-label">Sub Total</td>
                        <td class="price"><?php echo toPrice($cartObj['subTotal']).CURRENCY_SYMBOL?></td>
                    </tr>
                    <tr class="total-order">
                        <td class="total-label">Order Total</td>
                        <td class="price"><?php echo toPrice($cartObj['grandTotal']).CURRENCY_SYMBOL?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="cartitem-btn-wrapper">
            <a href="<?php echo getSiteUrl("items", "product-list") ?>" class="continue-shopping-btn sui-button">Continue Shopping</a>
            <a class="checkout-btn sui-button" href="<?php echo getSiteUrl("checkout", "checkout") ?>">Proceed To Checkout</a>
        </div>
    </div>
    <?php } else {?>
    <div class="shopping-cartitem empty-cart">
        <div class="header-wrapper">
            <h1 class="page-heading">Shopping Cart</h1>
        </div>
        <div class="empty-cartitem-text">Your shopping cart is empty</div>
        <a href="<?php echo getSiteUrl("items", "product-list") ?>" class="sui-button continue-shopping">Continue Shopping</a>
    </div>
    <?php }?>
</div>
