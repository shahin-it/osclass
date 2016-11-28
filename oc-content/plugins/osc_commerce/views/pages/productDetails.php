<?php
$product = $model["product"];
?>
<div class="osc-ec-template product-details-panel">
    <div class="product-widget widget-productName">
        <h1 class="product-name"><?php echo $product["s_name"]?></h1>
    </div>
    <div class="details-container">
        <div class="flex-widget widget-productImage <?php echo ($product['b_is_onsale'] == "1" ? "onsale" : "") ?>">
            <div class="product-image">
                <img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'], "medium")?>">
            </div>
            <div class="image-thumbs">
                <span class="thumb"><img class="product-thumb-image" src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>"></span>
            </div>
        </div>
        <div class="flex-widget product-info">
            <div class="title">Product Details:</div>
            <div class="product-widget widget-productCategory">
                <div class="info-row category">
                    <label>Category:</label>
                    <span class="value"><?php echo ($product["category"] ? $product["category"]["s_name"] : "") ?></span>
                </div>
            </div>

            <div class="product-widget widget-productBrand">
                <div class="info-row brand">
                    <label>Brand:</label>
                    <span class="value"><?php echo $product["s_brand"] ?></span>
                </div>
            </div>

            <div class="product-widget widget-stockMark">
                <span class="available stock-mark"><i class="fa fa-check"></i> Available</span>
            </div>

            <div class="product-widget widget-price">
                <?php if($product["b_is_onsale"] == "1") {?>
                    <div class="info-row price on-sale">
                        <label>Today:</label>
                        <span class="value">
                            <span class="base-price">
                                <?php echo number_format((float)$product['d_base_price'], 2, '.', '') ?> <span class="currency"><?php echo CURRENCY_SYMBOL ?></span>
                            </span>
                            <?php echo number_format((float)$product['display_price'], 2, '.', '') ?>
                            <span class="currency"><?php echo CURRENCY_SYMBOL ?></span>
                        </span>
                    </div>
                <?php } else {?>
                <div class="info-row price">
                    <label>Price:</label>
                    <span class="value">
                        <?php echo number_format((float)$product['display_price'], 2, '.', '') ?>
                        <span class="currency"><?php echo CURRENCY_SYMBOL ?></span>
                    </span>
                </div>
                <?php }?>

            </div>

            <div class="product-widget widget-addCart">
                <input type="number" min="1" max="1000" class="quantity-spinner" value="1">
                <span class="add-to-cart sui-button" title="Add To Cart" data-name="<?php echo $product["s_name"]?>"
                      data-id="<?php echo $product["pk_p_id"]?>" data-quantity="1"><i class="fa fa-cart-plus"></i> Add To Cart</span>
            </div>

            <div class="product-widget widget-likeus">
            </div>
        </div>
    </div>
    <div class="product-information">
        <span class="title">Product Description</span>
        <div class="body-container">
            <div class="title"><?php echo $product["s_name"]?></div>
            <div class="description"><?php echo $product["s_description"] ?></div>
        </div>
    </div>
    <div class="related-product">
        <div class="title">Related Product</div>
    </div>
</div>