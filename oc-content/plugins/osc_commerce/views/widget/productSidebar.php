<?php $products = $model["products"] ?>
<div class="ec-widget slidebar-widget product">
    <div class="widget-title"><?php echo $model["title"] ?: ''?></div>
    <div class="owl-carousel owl-theme product-slider">
        <?php foreach ($products as $product) {?>
            <div class="product-image-wrapper item">
                <div class="single-products">
                    <div class="product-info text-center">
                        <img class="image" src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>" alt="<?php echo $product['s_name']?>">
                        <h2 class="price"><?php echo number_format((float)$product['display_price'], 2, '.', '') ?> <?php echo CURRENCY_SYMBOL ?></h2>
                        <p class="name"><?php echo $product['s_name']?></p>
                        <a href="#" class="ecommerce-button add-to-cart" data-id="<?php echo $product["pk_p_id"]?>" data-quantity="1"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>