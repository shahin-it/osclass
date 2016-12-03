<?php $categories = $model["categories"]?>
<div class="ec-widget layout-widget category-widget">
    <?php foreach($categories as $category) {?>
    <div class="section-block">
        <div class="section-block-container">
            <div class="col-grid-left">
                <div class="wi-navigation">
                    <div class="title"><?php echo $category["s_name"]?></div>
                    <div class="nav-item-container">
                        <ul>
                            <li><a href="#">Navigation Name</a></li>
                            <li><a href="#">Navigation Name</a></li>
                            <li><a href="#">Navigation Name</a></li>
                            <li><a href="#">Navigation Name</a></li>
                            <li><a href="#">Navigation Name</a></li>
                            <li><a href="#">Navigation Name</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-grid-middle">
                <div class="slider">
                    <img src="<?php echo $category["s_image"]?>" alt="<?php echo $category["s_name"]?>"/>
                </div>
            </div>
            <div class="col-grid-right">
                <div class="wi-product">
                    <div class="col-grid add-container">
                        <img src="image/ad.png" alt=""/>
                    </div>
                    <?php foreach($category["products"] as $product) {?>
                    <div class="col-grid  product-item">
                        <div class="product-image">
                            <a href="#"><span class="v-align"><img src="image/product-image.png" alt=""/></a>
                        </div>
                        <div class="product-name"><?php echo $product["s_name"]?></div>
                        <div class="product-price"><?php echo $product["display_price"].CURRENCY_SYMBOL?></div>
                    </div>
                    <?php }?>
                </div>

            </div>
        </div>
    </div>
    <?php }?>
</div>