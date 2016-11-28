<?php
$categories = $model['category'];
?>
<div id="category-tab" class="sui-single-tab row-wrapper">
    <div class="tab-toolbar">
        <div class="tool-left">
            <span class="tool-item">
                <h3 class="tab-title render-title">Manage Categories</h3>
            </span>
        </div>
        <div class="tool-right">
            <span class="tool-item">
                <input type="text" class="input-text search-text">
                <button type="button" class="btn btn-mini tab-search"><i class="fa fa-search"></i></button>
            </span>
            <span class="tool-item">
                <a class="add-new btn btn-mini" href="#" title="Add new"><i class="fa fa-plus-circle"></i></a>
            </span>
            <span class="tool-item">
                <button type="button" class="tab-reload btn btn-mini" title="Reload"><i class="fa fa-refresh"></i></button>
            </span>
        </div>
    </div>

    <div class="sui-table relative">
        <table class="">
            <tr>
                <th class="select-column"><input type="checkbox"></th>
                <th class="id">Id</th>
                <th class="name actions-column">Name</th>
                <th class="date">Created</th>
<!--                <th class="image">Image</th>-->
                <th class="status">Status</th>
            </tr>
            <?php foreach($categories as $category) {?>
            <tr>
                <td class="select-column"><input type="checkbox"></td>
                <td class="id"><?php echo $category['pk_c_id']?></td>
                <td class="actions-column name">
                    <div class="value"><?php echo $category['s_name']?></div>
                    <div class="navigator" data-name="<?php echo $category['s_name']?>" data-id="<?php echo $category['pk_c_id']?>">
                        <i class="fa fa-pencil edit" title="Edit"></i>
                        <i class="fa fa-trash-o delete" title="Delete"></i>
                    </div>
                </td>
                <td class="date"><?php echo $category['dt_created']?></td>
<!--                <td class="image">--><?php //echo $category['s_image']?><!--</td>-->
                <td class="status"><i class="fa <?php echo($category['b_active'] == "1" ? "fa-check" : "fa-ban")?>"></i></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>