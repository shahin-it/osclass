<?php
$products = $model['product'];
?>
<div id="product-tab" class="sui-single-tab row-wrapper">
    <div class="tab-toolbar">
        <div class="tool-left">
            <span class="tool-item">
                <h3 class="tab-title render-title">Manage Products</h3>
            </span>
        </div>
        <div class="tool-right">
            <span class="tool-item">
                <input type="text" class="input-text search-text">
                <button type="button" class="btn btn-mini"><i class="fa fa-search"></i></button>
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
                <th class="select-column"><input type="checkbox"</th>
                <th class="id">Id</th>
                <th class="name actions-column">Name</th>
                <th class="category">Category</th>
                <th class="date">Created</th>
                <th class="image">Image</th>
                <th class="stock">Stock</th>
                <th class="on-sale">Is OnSale</th>
                <th class="price">Price</th>
                <th class="status">Status</th>
            </tr>
            <?php foreach($products as $product) {?>
            <tr>
                <td class="select-column"><input type="checkbox"></td>
                <td class="id"><?php echo $product['pk_p_id']?></td>
                <td class="actions-column name">
                    <div class="value"><?php echo $product['s_name']?></div>
                    <div class="navigator" data-name="<?php echo $product['s_name']?>" data-id="<?php echo $product['pk_p_id']?>">
                        <i class="fa fa-pencil edit" title="Edit"></i>
                        <i class="fa fa-trash-o delete" title="Delete"></i>
                    </div>
                </td>
                <td class="category"><?php echo $product['category'] ? $product['category']['s_name'] : ""?></td>
                <td class="date"><?php echo $product['dt_created']?></td>
                <td class="image"><?php echo $product['s_image']?></td>
                <td class="image"><?php echo $product['i_quantity']?></td>
                <td class="on-sale"><i class="fa <?php echo($product['b_is_onsale'] == "1" ? "fa-check color-green" : "fa-ban color-red")?>"></i></td>
                <td class="price"><?php echo toPrice($product['d_base_price'])?></td>
                <td class="status"><i class="fa <?php echo($product['b_active'] == "1" ? "fa-check color-green" : "fa-ban color-red")?>"></i></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>