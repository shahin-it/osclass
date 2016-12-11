<?php
$cartObj = $model["cartObj"] ?: null;
?>
<div class="section-ecommerce layout-left-full-width osc-ec-template cart-details-page">
    <div class="container">
        <div class="row page-heading">
            <div class="col-sm-12"><h1>Cart Details</h1></div>
        </div>
        <div class="row">
            <div class="col-sm-12 content-main">
                <?php
                if (!is_null($cartObj) && sizeof($cartObj["items"]) > 0) {
                ?>
                <div class="cart_details">
                    <table class="cart-details-table">
                        <thead>
                        <tr class="cart_menu">
                            <td class="image">Item</td>
                            <td class="description">Description</td>
                            <td class="price">Price</td>
                            <td class="quantity">Quantity</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($cartObj["items"] as $product) { ?>
                        <tr class="cart-item">
                            <td class="cart_product">
                                <a href="<?php echo getSiteUrl("items", "product-details")."?id=".$product["id"] ?>">
                                    <img title="<?php echo $product["name"]?>" src="<?php echo getAppUtil()->getBaseProductImage($product['id'], $product['image'])?>" alt="Product image">
                                </a>
                            </td>
                            <td class="cart_description">
                                <p>NAME: <?php echo $product["name"]?></p>
                                <h4>Size: <?php echo $product["size"]?></h4>
                                <h4>Color: <?php echo $product["color"]?></h4>
                            </td>
                            <td class="cart_price">
                                <p><?php echo toPrice($product["rate"]).CURRENCY_SYMBOL?></p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" href=""> + </a>
                                    <input class="cart_quantity_input quantity-spinner" name="quantity" value="1" autocomplete="off"
                                           size="2" type="number" data-id="<?php echo $product["id"]?>" min="1">
                                    <a class="cart_quantity_down" href=""> - </a>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price"><?php echo toPrice($product["price"]).CURRENCY_SYMBOL?></p>
                            </td>
                            <td class="cart_delete actions remove">
                                <a class="cart_quantity_delete remove-cartitem" href="#" title="Remove" data-id="<?php echo $product["id"]?>"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                        <tfoot>
                        <tr class="sub-total-row">
                            <td class="label" colspan="4">
                                <p>Cart Sub Total</p>
                            </td>
                            <td class="amount">
                                <p><?php echo toPrice($cartObj['subTotal']).CURRENCY_SYMBOL?></p>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr class="shipping-cost-row">
                            <td class="label" colspan="4">
                                <p>Shipping Cost</p>
                            </td>
                            <td class="amount">
                                <p><?php echo toPrice($cartObj['shippingCost']).CURRENCY_SYMBOL?></p>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr class="total-amount">
                            <td class="label" colspan="4">
                                <p>Total</p>
                            </td>
                            <td class="amount">
                                <p><?php echo toPrice($cartObj['grandTotal']).CURRENCY_SYMBOL?></p>
                            </td>
                            <td>

                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="btn-wrapper">
                        <a href="<?php echo getSiteUrl("items", "product-list") ?>" class="continue-shopping-btn btn" et-category="button">Continue Shopping</a>
                        <a href="<?php echo getSiteUrl("checkout", "checkout") ?>" class="proceed-checkout-out btn">Proceed To Checkout</a>
                    </div>
                </div>

                <?php } else {?>
                    <div class="empty-cart-text">Your shopping cart is empty</div>
                    <a href="<?php echo getSiteUrl("items", "product-list") ?>" class="continue-shopping-btn btn" et-category="button">Continue Shopping</a>
            <?php }?>
            </div>
        </div>

    </div>
</div>
