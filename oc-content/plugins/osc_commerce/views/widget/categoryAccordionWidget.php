<?php
$categories = $model["categories"] ?: array();
?>
<div class="ec-widget sidebar-widget category-accordion">
    <h2 class="widget-title"><span>CATEGORY</span></h2>
    <div class="nav category-products">
        <ul class="sui-accordion-panel">
            <?php foreach($categories as $category) {
                if($category["child"]) {
                    echo '<li>
                        <a href="'.getSiteUrl("items", "category-details")."?id=".$category["pk_c_id"].'">'.$category['s_name'].' ['.sizeof($category['products']).']'.'</a>
                        <span class="item-label fa fa-plus"></span>
                    </li>';
                    echo '<ul class="item-body" style="display: none">';
                    foreach ($category["child"] as $child) {
                        echo '<li class="item-body"><a href="'.getSiteUrl("items", "category-details")."?id=".$child["pk_c_id"].'">'.$child['s_name'].' ['.sizeof($child['products']).']'.'</a></li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<li><a href="'.getSiteUrl("items", "category-details")."?id=".$category["pk_c_id"].'">'.$category['s_name'].'</a></li>';
                }
            }?>
        </ul>
    </div>
</div>