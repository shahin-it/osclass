<?php
$product = $model["product"];
?>
<div class="section-ecommerce layout-left-sidebar osc-ec-template product-details-panel">
    <div class="container">
        <div class="row page-heading"><div class="col-sm-12"><h1>Product Details</h1></div></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <?php renderWidget("category_accordion");?>
                </div>
            </div>

            <div class="col-sm-9 content-main">
                <?php renderWidget("product_details", $model);?>
                <?php renderWidget("related_product", array("title"=>"Related Products", "product"=>$product));?>
            </div>
        </div>
    </div>
</div>