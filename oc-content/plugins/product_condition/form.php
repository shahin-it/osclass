<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 26-Jul-16
 * Time: 11:25 PM
 */
?>
<div class="row">
    <label><?php _e("Item Condition", 'item_condition') ; ?></label>
    <?php $item_condition = __get('item_conditions') ; ?>
    <div class="select-box">
        <select name="s_item_condition" id="product-condition">
            <?php foreach($item_condition as $k => $v) { ?>
                <option value="<?php echo $k ; ?>" <?php if ($itemData != null && $itemData['s_item_condition'] == $k) { echo "selected" ; } ?>><?php echo $v ; ?></option>
            <?php } ?>
        </select>
    </div>
</div>

