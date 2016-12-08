<?php
$products = $model['products'] ?: array();
?>

<div class="product-listing osc-ec-template grid-view">
    <div class="features_items products"><!--features_items-->
        <h2 class="widget-title"><span><?php echo ($model["title"] ?: 'Featured Items')?></span></h2>

        <?php foreach($products as $product) {?>
        <div class="col-sm-4 product-card">
            <div class="product-block product-info">
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
                <div class="product-image-wraper">
                    <span class="vertical-aligner"></span>
                    <a href="<?php echo getSiteUrl("items", "product-details")."&id=".$product['pk_p_id'] ?>">
                        <img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>" alt="">
                    </a>
                </div>
                <h2><?php echo toPrice($product['display_price']).CURRENCY_SYMBOL?></h2>
                <p><?php echo $product['s_name']?></p>
                <div class="button-line">
                    <a href="#" class="btn add-to-cart" title="Add To Cart" data-name="<?php echo $product["s_name"]?>"
                       data-id="<?php echo $product["pk_p_id"]?>" data-quantity="1"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    <a href="#" class="btn wishlist"><i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>