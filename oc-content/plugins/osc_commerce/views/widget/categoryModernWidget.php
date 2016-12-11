<?php $categories = $model["categories"]?>
<div class="ec-widget layout-widget category-widget">
    <?php foreach($categories as $category) {?><br><br>
    <div class="section-block">
        <div class="section-block-container">
            <div class="col-grid-left">
                <div class="wi-navigation">
                    <div class="title"><?php echo $category["s_name"]?></div>
                    <div class="nav-item-container">
                        <ul>
                            <?php foreach ($category["child"] as $child) {?>
                                <li><a href="<?php echo getSiteUrl("items", "category-details")."?id=".$child["pk_c_id"] ?>"><?php echo $child["s_name"]?></a></li>
                            <?php }?>
                            <li class=""><a href="<?php echo getSiteUrl("items", "category-details")."?id=".$category["pk_c_id"] ?>">See More <span class="fa fa-plus-square"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-grid-middle">
                <div class="slider owl-theme image-slider">
                    <?php foreach ($category["child"] as $child) {
                        echo '<div class="link item" href="'.getSiteUrl("items", "category-details")."&id=".$child['pk_c_id'].'">';
                        echo '<img src="'.getAppUtil()->getBaseCategoryImage($child['pk_c_id'], $child['s_image'], 'large').'" alt="'.$child["s_name"].'"/>';
                        echo '</div>';
                    }?>
                </div>
            </div>
            <div class="col-grid-right">
                <div class="wi-product">
                    <div class="col-grid add-container">
                        <a href="<?php echo getSiteUrl("items", "category-details")."?id=".$category["pk_c_id"] ?>">
                            <img src="<?php echo getAppUtil()->getBaseCategoryImage($category['pk_c_id'], $category['s_image'], "medium")?>" alt=""/>
                        </a>
                    </div>
                    <?php foreach(array_slice($category["products"], 0, 3) as $product) {?>
                    <div class="col-grid  product-item">
                        <div class="product-image">
                            <a href="<?php echo getSiteUrl("items", "product-details")."&id=".$product['pk_p_id'] ?>">
                                <span class="v-align"><img src="<?php echo getAppUtil()->getBaseProductImage($product['pk_p_id'], $product['s_image'])?>" alt=""/>
                            </a>
                        </div>
                        <div class="product-name"><?php echo $product["s_name"]?></div>
                        <div class="product-price"><?php echo toPrice($product["display_price"]).CURRENCY_SYMBOL?></div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>