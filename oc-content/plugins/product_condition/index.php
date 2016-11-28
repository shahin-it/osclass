<?php
/*
Plugin Name: Product Condition
Plugin URI: http://www.subarnachar.com/osclass/product_condition
Description: This plugin introduce a new item type called "new" and "used"
Version: 1.0.0
Author: Shahin Khaled
Author URI: http://www.subarnachar.com/
Plugin update URI: http://www.osclass.org/files/plugins/product_condition/update.php
*/
$pc_connection = null;
$pc_command = null;
$item_conditions = array();
$item_conditions['NEW'] = __('New', 'product_condition');
$item_conditions['USED']  = __('Used', 'product_condition');

View::newInstance()->_exportVariableToView("item_conditions", $item_conditions);

function pc_getConnection() {
    global $pc_connection;
    if($pc_connection == null) {
        $pc_connection = DBConnectionClass::newInstance();
    }
    return $pc_connection;
}

function pc_getCommand() {
    global $pc_command;
    if($pc_command == null) {
        $conn = pc_getConnection();
        $db = $conn->getOsclassDb();
        $pc_command = new DBCommandClass($db);
    }
    return $pc_command;
}

function pc_call_after_install()
{
    $sql = file_get_contents(osc_plugin_path("product_condition")."/install.sql");
    $sql = str_replace('#DB_TABLE_PREFIX#', DB_TABLE_PREFIX, $sql);
    pc_getCommand()->query(sprintf($sql));
}

function pc_call_after_uninstall()
{
    $sql = file_get_contents(osc_plugin_path("product_condition")."/uninstall.sql");
    $sql = str_replace('#DB_TABLE_PREFIX#', DB_TABLE_PREFIX, $sql);
    pc_getCommand()->query(sprintf($sql));
}

function buysell_item_edit($catId = null, $itemId = null) {
    $itemData = Item::newInstance()->findByPrimaryKey($itemId);
    include_once 'form.php';
}

function buysell_item_edit_post($catId = null, $item_id = null) {
    if($catId == null) {
        return false;
    }

    if(osc_is_this_category('buysell', $catId)) {
        $conn = getConnection() ;
        $conn->osc_dbExec("REPLACE INTO %st_item_buysell (fk_i_item_id, s_type) VALUES (%d, '%s')", DB_TABLE_PREFIX, $item_id, Params::getParam('buysell_type') );
    }
}

osc_register_plugin(osc_plugin_path(__FILE__), 'pc_call_after_install');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'pc_call_after_uninstall');

//osc_add_hook('item_form', 'buysell_form', 0);
//osc_add_hook('item_form_post', 'buysell_form_post');
//osc_add_hook('search_form', 'buysell_search_form',0 );
//osc_add_hook('search_conditions', 'buysell_search_conditions');
//osc_add_hook('item_detail', 'buysell_item_detail', 0);
osc_add_hook('item_edit', 'buysell_item_edit');
osc_add_hook('item_edit_post', 'buysell_item_edit_post');
?>