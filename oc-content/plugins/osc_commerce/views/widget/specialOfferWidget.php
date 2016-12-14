<div class="ec-widget sidebar-widget widget wi-spacial-product">
    <div class="widget-title"><span><?php echo ($model["title"] ?: 'Spacial Offer')?></span></div>
    <div class="widget-container">
        <?php foreach ($model['products'] as $product) {?>
        <div class="product-block">
            <div class="product-img-wrap">
                <a href="<?php echo getSiteUrl("items", "product-details")."&id=".$product['pk_p_id'] ?>">
                    <img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'], 'small')?>" alt="Product Image"/>
                </a>
            </div>
            <div class="product-info">
                <a href="<?php echo getSiteUrl("items", "product-details")."&id=".$product['pk_p_id'] ?>">
                    <div class="product-name"><?php echo $product["s_name"]?></div>
                </a>
                <div class="product-price">
                    <?php
                    if($product["b_is_onsale"] == "1") {
                        echo '<span class="previous-price">'.toPrice($product['d_base_price']).CURRENCY_SYMBOL.'</span>';
                        echo '<span class="current-price">'.toPrice($product['display_price']).CURRENCY_SYMBOL.'</span>';
                    } else {
                        echo '<span class="current-price">'.toPrice($product['display_price']).CURRENCY_SYMBOL.'</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>