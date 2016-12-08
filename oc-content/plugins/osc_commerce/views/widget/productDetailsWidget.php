<?php
$product = $model["product"];
?>
<div class="ec-widget content-widget product-detail-widget">
    <div class="product-details">
        <div class="col-sm-6">
            <div class="product-image">
                <?php
                $tag = "";
                if($product["b_is_onsale"] == "1") {
                    $tag = "onSale-tag";
                } else if($product["b_is_feature"] == "1") {
                    $tag = "featured-tag";
                } else if($product["b_is_new"] == "1") {
                    $tag = "new-tag";
                }
                ?>
                <span class="<?php echo $tag?>"></span>
                <img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'], "large")?>" alt="<?php echo $product["s_name"]?>">
            </div>
            <div class="thumb-image-wrapper" data-size="<?php echo getAppUtil()->imageResulation("small").':'.getAppUtil()->imageResulation("large")?>">
                <span class="next fa fa-angle-left"></span>
                <ul>
                    <?php foreach(getAppUtil()->getBaseProductImages($product) as $thumb) {
                        echo '<li class="thumb active"><a href="#"><img src="'.$thumb.'" alt=""></a></li>';
                    }?>
                </ul>
                <span class="previous fa fa-angle-right"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="product-information">
                <h2 class="product-name"><?php echo $product["s_name"]?></h2>
                <span class="product-info webId">SKU: <?php echo $product["s_uuid"]?></span>
                <span class="product-info rating"><img src="<?php echo PRODUCT_IMAGE_BASE?>rating.png" alt=""></span>
                <span class="product-info price">
                    <span class="label">Today's Price</span>
                    <span class="current-price"><?php echo toPrice($product['display_price']).CURRENCY_SYMBOL ?></span>
                    <?php
                        if($product["b_is_onsale"] == "1") {
                            echo '<span class="previous-price">'.toPrice($product['d_base_price']).CURRENCY_SYMBOL.'</span>';
                        }
                    ?>
                </span>
                <span class="product-info webId"><label>Availability:</label> <span class="value"><?php echo ($product["i_quantity"] > 0 ? "In Stock" : "Stock Out")?></span></span>
                <span class="product-info webId"><label>Condition:</label> <span class="value">New</span></span>
                <span class="product-info webId"><label>Brand:</label> <span class="value"><?php echo $product["s_brand"]?></span></span>
                <span class="product-info webId"><label>Model:</label> <span class="value"><?php echo $product["s_model"]?></span></span>
                <span class="product-info quantity">
                    <label>Quantity:</label>
                     <input type="number" min="1" max="1000" class="quantity-spinner" value="1">
                     <a href="#" class="btn add-to-cart" title="Add To Cart" data-name="<?php echo $product["s_name"]?>"
                        data-id="<?php echo $product["pk_p_id"]?>" data-quantity="1"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                    <a href="#" class="btn wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
                </span>
                <span class="product-info webId"><img src="<?php echo PRODUCT_IMAGE_BASE?>share.png" class="share" alt=""></span>
            </div>
        </div>
        <div class="clear-both"></div>
        <div class="product-details-tab">
            <div class="tab-header">
                <ul>
                    <li><a class="active" href="#">Details</a></li>
                    <li><a href="#">Tag</a></li>
                    <li><a href="#">Review</a></li>
                </ul>
            </div>
            <div class="tab-container">
                <p><?php echo $product["s_description"]?></p>
            </div>
        </div>
    </div>
</div>