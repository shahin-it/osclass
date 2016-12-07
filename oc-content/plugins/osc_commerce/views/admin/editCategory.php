<?php
    $category = $model["category"];
?>
<form class="create-edit-form" action="<?php echo(osc_route_admin_ajax_url("commerce-route", array('controller'=>'categoryAdmin', 'trigger'=>'save')))?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $category['pk_c_id']?>">
    <div class="form-row input-title-wide">
        <label>Name</label>
        <input type="text" name="s_name" value="<?php echo $category['s_name']?>" required="" maxlength="200">
    </div>
    <div class="form-row sui-file-chooser">
        <label>Image</label>
        <div class="input">
            <input class="single" type="file" name="s_image" value="" max-size="2048">
        </div>
    </div>
    <div class="form-row">
        <label>Parent Category</label>
        <select name="i_parent_id">
            <option value="">None::</option>
            <?php
                foreach ($model["parents"] as $parent) {
            ?>
                    <option value="<?php echo $parent['pk_c_id']?>" <?php echo($category['i_parent_id'] == $parent['pk_c_id'] ? 'selected' : '')?>><?php echo $parent['s_name']?></option>
            <?php
                }
            ?>
        </select>
    </div>
    <div class="form-row">
        <label>Status</label>
        <select name="b_active">
            <option value="true" <?php echo($category['b_active'] == 'true' ? 'selected' : '')?>>Activate</option>
            <option value="false" <?php echo($category['b_active'] == 'false' ? 'selected' : '')?>>Deactivate</option>
        </select>
    </div>
    <div class="form-row input-description-wide">
        <label>Description</label>
        <textarea type="text" name="s_description" value="<?php echo $category['s_description']?>" maxlength="65000"></textarea>
    </div>
    <div class="button-line">
        <button type="submit" class="btn btn-submit">Submit</button>
        <button type="button" class="btn btn-cancel btn-red">Cancel</button>
    </div>
</form>