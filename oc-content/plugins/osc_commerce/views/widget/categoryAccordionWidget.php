<?php
$categories = $model["categories"] ?: array();
?>
<div class="ec-widget slidebar-widget category-accordion">
    <h2 class="widget-title"><span>CATEGORY</span></h2>
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