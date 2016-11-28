<?php
/*
Plugin Name: Bikroy Venue Styling
Plugin URI: http://bikroyvenue.com
Description: OS Class ecommerce adone.
Version: 1.0
Author: Shahin
Author URI: http://subarnachar.com
Short Name: osc_commerce
Plugin update URI: #
 */



function loadAdminScripts() {
    //osc_register_script('jquery-cookiecuttr', osc_plugin_url(__FILE__) . 'jquery.cookiecuttr.js', array('jquery', 'jquery-cookie'));
}

function loadSiteScript() {
    if(OC_ADMIN) {
        return;
    }
    osc_enqueue_style('bikroy-venue-site-css', osc_plugin_url(__FILE__) . 'css/site.css');
    osc_enqueue_style('bikroy-venue-site-css', osc_plugin_url(__FILE__) . 'css/style.css');
    osc_register_script('bikroy-venue-site-js', osc_plugin_url(__FILE__) . 'js/site.js', array('jquery'));
    osc_enqueue_script('bikroy-venue-site-js');
}


osc_add_hook('init_admin', 'loadAdminScripts');
osc_add_hook('init', 'loadSiteScript');