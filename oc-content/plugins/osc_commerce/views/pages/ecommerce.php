<div class="section-ecommerce layout-left-sidebar osc-ec-template ecommerce-product-page">
    <div class="container">
        <div class="row page-heading"><div class="col-sm-12"><h1>Bikroy Venue Shop</h1></div></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <?php renderWidget("category_accordion");?>
                    <?php renderWidget("special_widget");?>
                    <?php renderWidget("special_widget", array("title"=> "New Arrival", "condition"=> array("b_is_new"=> "1")));?>
                </div>
            </div>

            <div class="col-sm-9 content-main product-card padding-right">
                <?php renderWidget("product_grid");?>
            </div>
        </div>
    </div>
</div>