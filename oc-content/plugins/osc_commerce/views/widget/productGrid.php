<?php
$categories = $model["categories"] ?: array();
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

    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2 class="widget-title"><span>Features Items</span></h2>
                    <div class="nav category-products">
                        <ul class="sui-accordion-panel">
                            <?php foreach($categories as $category) {
                                if($category["child"]) {
                                    echo '<li class="item-label"><a href="#">'.$category['s_name'].'</a></li>';
                                    foreach ($category["child"] as $child) {
                                        echo '<li class="item-body"><a href="#">'.$child['s_name'].'</a></li>';
                                    }
                                } else {
                                    echo '<li class=""><a href="#">'.$category['s_name'].'</a></li>';
                                }
                            }?>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="product-card col-sm-9 padding-right">
                <div class="features_items products"><!--features_items-->
                    <h2 class="widget-title"><span>Features Items</span></h2>

                    <?php foreach($products as $product) {?>
                    <div class="col-sm-4 product-card">
                        <div class="product-block product-info">
                            <?php
                            $tag = "";
                             if($product["b_is_onsale"]) {
                                 $tag = "onSale-tag";
                             } else if($product["b_is_new"]) {
                                 $tag = "new-tag";
                             } else if($product["b_is_feature"]) {
                                 $tag = "featured-tag";
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
        </div>
    </div>
</div>