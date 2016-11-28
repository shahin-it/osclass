<?php
/*
Plugin Name: An OSC Commerce
Plugin URI: http://bikroyvenue.com
Description: OS Class ecommerce adone
Version: 1.0
Author: Shahin
Author URI: http://subarnachar.com
Short Name: osc_commerce
Plugin update URI: #
 */
require_once 'src/class/class.Initializer.php';
require_once 'src/class/class.Destroyer.php';
date_default_timezone_set("Asia/Dhaka");
define("PLUGIN", "osc_commerce");
define("PLUGIN_VIEW", PLUGIN.'/views/');
define("RESOURCE_BASE", osc_plugin_url(__FILE__).'resource/');
define("PRODUCT_IMAGE_BASE", RESOURCE_BASE."image/product/");
define("PLUGIN_BASE", osc_plugin_url(__FILE__));
define("THIS_BASE_PATH", osc_plugin_path("osc_commerce/"));
define("RESOURCE_BASE_PATH", THIS_BASE_PATH."resource/");
define("CURRENCY_SYMBOL", "TK");
importUtils();

osc_add_route('commerce-route', 'commerce-route/([0-9]+)/(.+)', 'commerce-route/{controller}/{trigger}', osc_plugin_folder(__FILE__).'route.php');

function add_admin_menu()
{
    $menu = AdminMenu::newInstance();
    $menu->add_menu('OSC Commerce', osc_admin_render_plugin_url(PLUGIN_VIEW.'admin/dashboard.php'), 'osc_commerce', 'administrator', RESOURCE_BASE."image/ecommerce_48.png");
    $menu->add_submenu('osc_commerce', 'Categories', osc_route_admin_url('commerce-route', array('controller'=>'categoryAdmin', 'trigger'=>'list')), PLUGIN.'_category', 'administrator');
    $menu->add_submenu('osc_commerce', 'Products', osc_route_admin_url('commerce-route', array('controller'=>'productAdmin', 'trigger'=>'list')), PLUGIN.'_product', 'administrator');
    $menu->add_submenu('osc_commerce', 'Orders', osc_route_admin_url('commerce-route', array('controller'=>'orderAdmin', 'trigger'=>'orderList')), PLUGIN.'_order', 'administrator');
    $menu->add_submenu('osc_commerce', 'Payments', osc_route_admin_url('commerce-route', array('controller'=>'orderAdmin', 'trigger'=>'paymentList')), PLUGIN.'_payment', 'administrator');
}

function call_after_install()
{
    $initializer = Initializer::newInstance();
    $initializer->init();
}

function call_after_uninstall()
{
    Destroyer::newInstance()->removeTables();
}

function load_script_resource() {
    $prefix = "osc-";
    osc_enqueue_style($prefix.'common-css', RESOURCE_BASE . 'css/ecom-style.css');
    AppUtil::enqueue_script($prefix.'jqform-js', RESOURCE_BASE.'js/jquery.form.js');
    AppUtil::enqueue_script($prefix.'common-js', RESOURCE_BASE.'js/common.js');
    AppUtil::enqueue_script($prefix.'utility-js', RESOURCE_BASE.'js/utility.js');
    if(OC_ADMIN) {
        osc_enqueue_style($prefix.'admin-css', RESOURCE_BASE . 'css/admin/ecom-base.css');

        $adminJs = array('item', 'order', 'payment', 'widget', 'tab');
        foreach($adminJs as $js) {
            AppUtil::enqueue_script($prefix.$js, RESOURCE_BASE.'js/admin/feature/'.$js.'.js');
        }
    } else {
        osc_enqueue_style($prefix.'site-css', RESOURCE_BASE . 'css/site/ecom-site.css');

        $siteJs = array('site', 'product', 'cart', 'payment');
        foreach($siteJs as $js) {
            AppUtil::enqueue_script($prefix.$js, RESOURCE_BASE.'js/site/'.$js.'.js');
        }
    }
//    AppUtil::enqueue_script($prefix.'config-js', RESOURCE_BASE.'js/config.js');
}

function toPrice($amount = "0.00", $point = 2) {
    return number_format((float)$amount, $point, '.', '');
}

function getSiteUrl($controller, $action) {
    return osc_route_url("commerce-route", array('controller'=>$controller, 'trigger'=>$action));
}

function getAppUtil() {
    return AppUtil::newInstance();
}

function importUtils() {
    require_once THIS_BASE_PATH."/src/class/class.AppUtil.php";
}

function imageResulation($size) {
    return array(
        "small"=>196,
        "medium"=>480,
        "large"=>960
    )[$size];
}

//end file (Making a plugin installable)
osc_register_plugin(osc_plugin_path(__FILE__), 'call_after_install');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'call_after_uninstall');
osc_add_hook('admin_menu_init', 'add_admin_menu');
osc_add_hook('init', 'load_script_resource');
osc_add_hook("admin_header", function() {
    echo('<script type="text/javascript">');
    echo('var _osc_commerce_admin_base = "'.osc_route_admin_url("commerce-route", array('controller'=>'##controller##', 'trigger'=>'##action##')).'";');
    echo('var _osc_commerce_admin_ajax_base = "'.osc_route_admin_ajax_url("commerce-route", array('controller'=>'##controller##', 'trigger'=>'##action##')).'";');
    echo('</script>');
});
osc_add_hook("header", function() {
    echo('<script type="text/javascript">');
    echo('var _osc_commerce_base = "'.osc_route_url("commerce-route", array('controller'=>'##controller##', 'trigger'=>'##action##')).'";');
    echo('var _osc_commerce_ajax_base = "'.osc_route_ajax_url("commerce-route", array('controller'=>'##controller##', 'trigger'=>'##action##')).'";');
    echo('</script>');
});
?>