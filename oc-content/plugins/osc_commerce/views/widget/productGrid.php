<?php
$products = $model['products'] ?: array();
?>

<div class="product-listing osc-ec-template grid-view">
    <nav class="product-filter">

        <h1>Jackets</h1>

        <div class="sort">

            <div class="collection-sort">
                <label>Filter by:</label>
                <select>
                    <option value="/">All Jackets</option>
                </select>
            </div>

            <div class="collection-sort">
                <label>Sort by:</label>
                <select>
                    <option value="">Featured</option>
                </select>
            </div>

        </div>

    </nav>

    <section class="products">

        <?php foreach($products as $product) {?>
        <div class="product-card <?php echo ($product['b_is_onsale'] == "1" ? "onsale" : "") ?>">
            <a href="<?php echo getSiteUrl("items", "product-details")."&id=".$product['pk_p_id'] ?>">
                <div class="product-image">
                    <img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>">
                </div>
            </a>
            <div class="product-info">
                <div class="stock-info">
                    <?php if($product["dt_updated"]) {?>
                        <span class="new-product">new</span>
                    <?php }?>
                    <span class="in-stock">in stock</span>
                </div>
                <div class="name"><?php echo $product['s_name']?></div>
                <div class="price">
                    <span class="value"><?php echo number_format((float)$product['display_price'], 2, '.', '') ?></span>
                    <span class="currency"><?php echo CURRENCY_SYMBOL ?></span>
                </div>
                <?php if($product["dt_updated"]) {?>

                <?php }?>
                <span class="sui-button add-to-cart" title="Add To Cart" data-name="<?php echo $product["s_name"]?>"
                      data-id="<?php echo $product["pk_p_id"]?>" data-quantity="1"><i class="fa fa-cart-plus"></i> Add to Cart</span>
            </div>
        </div>
        <?php }?>

    </section>
</div>