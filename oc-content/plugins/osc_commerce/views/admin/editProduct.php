<?php
    $product = $model["product"];
    $categories = $model["categories"];
?>
<form class="create-edit-form" action="<?php echo(osc_route_admin_ajax_url("commerce-route", array('controller'=>'productAdmin', 'trigger'=>'save')))?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product['pk_p_id']?>">
    <div class="form-row input-title-wide">
        <label>Name</label>
        <input type="text" name="s_name" value="<?php echo $product['s_name']?>" required="" maxlength="200">
    </div>
    <div class="form-row">
        <label>Status</label>
        <select name="b_active">
            <option value="true" <?php echo($product['b_active'] == 'true' ? 'selected' : '')?>>Activate</option>
            <option value="false" <?php echo($product['b_active'] == 'false' ? 'selected' : '')?>>Deactivate</option>
        </select>
    </div>
    <div class="form-row input-title-wide">
        <label>Model</label>
        <input type="text" name="s_model" value="<?php echo $product['s_model']?>" maxlength="200">
    </div>
    <div class="form-row input-title-wide">
        <label>Size</label>
        <input type="text" name="s_size" value="<?php echo $product['s_size']?>" maxlength="200">
    </div>
    <div class="form-row input-title-wide">
        <label>Color</label>
        <input type="text" name="s_color" value="<?php echo $product['s_color']?>" maxlength="200">
    </div>
    <div class="form-row input-title-wide">
        <label>Available Stock</label>
        <input class="input-text" type="number" name="i_quantity" value="<?php echo $product['i_quantity']?>" required="" maxlength="9">
    </div>
    <div class="form-row input-title-wide">
        <label>Base Price</label>
        <input class="input-text" type="number" name="d_base_price" value="<?php echo $product['d_base_price']?>" required="" maxlength="9">
    </div>
    <div class="form-row">
        <label>Is New</label>
        <input type="checkbox" name="b_is_new" <?php echo ($product['b_is_new'] == "1" ? "checked" : "")?> value="true">
    </div>
    <div class="form-row">
        <label>Is Featured</label>
        <input type="checkbox" name="b_is_feature" <?php echo ($product['b_is_feature'] == "1" ? "checked" : "")?> value="true">
    </div>
    <div class="form-row">
        <label>Is On Sale</label>
        <input type="checkbox" name="b_is_onsale" <?php echo ($product['b_is_onsale'] == "1" ? "checked" : "")?> value="true">
    </div>
    <div class="form-row input-title-wide">
        <label>Sale Price</label>
        <input class="input-text" type="number" name="d_sale_price" value="<?php echo $product['d_sale_price']?>" maxlength="9">
    </div>
    <div class="form-row input-description-wide">
        <label>Description</label>
        <textarea type="text" name="s_description" value="<?php echo $product['s_description']?>" maxlength="65000"></textarea>
    </div>
    <div class="form-row sui-file-chooser">
        <label>Images</label>
        <div class="input">
            <input type="file" name="s_image[]" value="" max-size="2048">
        </div>
    </div>
    <div class="form-row">
        <label>Category</label>
        <select class="input-text" name="fk_c_id">
            <option value="">None</option>
            <?php
                foreach($categories as $category) {
                    echo '<option value="'.$category['pk_c_id'].'" '.($product['fk_c_id'] == $category['pk_c_id'] ?
                            "selected" : "").'>'.$category['s_name'].'</option>';
                }
            ?>
        </select>
    </div>
    <div class="button-line">
        <button type="submit" class="btn btn-submit">Submit</button>
        <button type="button" class="btn btn-cancel btn-red">Cancel</button>
    </div>
</form>