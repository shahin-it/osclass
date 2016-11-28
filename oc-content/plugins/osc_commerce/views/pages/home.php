<div class="osc-ec-template ecommerce-home-page">
    <?php
    //        require_once(THIS_BASE_PATH."/views/productListing.php");
    ?>

    <div class="site-intro">
        <div class="title">Bikroy Venue Shop</div>
    </div>

    <div class="home-layout">
        <div class="left-slidebar">
            <?php getAppUtil()->renderWidget("product_sidebar")?>
            <div class="ec-widget slidebar-widget">widget2</div>
            <div class="ec-widget slidebar-widget">widget3</div>
        </div>
        <div class="layout-content">
            <?php getAppUtil()->renderWidget("category");?>
        </div>
        <div class="right-slidebar">
            <div class="ec-widget slidebar-widget">widget1</div>
            <div class="ec-widget slidebar-widget">widget2</div>
            <div class="ec-widget slidebar-widget">widget3</div>
        </div>
    </div>

</div>