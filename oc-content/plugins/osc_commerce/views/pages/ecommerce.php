<?php
//echo file_get_contents(THIS_BASE_PATH."Eshopper/index.html");
?>

<div class="osc-ec-template ecommerce-product-page">
    <div class="site-intro">
        <div class="title">Bikroy Venue Shop</div>
    </div>

    <div class="page-layout">
        <div class="left-slidebar">
            <?php //renderWidget("product_sidebar", array("title"=>"New Arrival"))?>
<!--            <div class="ec-widget slidebar-widget">widget2</div>-->
<!--            <div class="ec-widget slidebar-widget">widget3</div>-->
        </div>
        <div class="layout-content">
            <?php renderWidget("product_grid");?>
        </div>
    </div>
</div>
