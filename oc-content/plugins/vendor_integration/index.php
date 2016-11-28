<?php
/*
Plugin Name: Vendor Integration
Plugin URI: http://www.subarnachar.com/osclass/vendor_integration
Description: This plugin introduce a new user type called "enterprise seller"
Version: 1.0.0
Author: Shahin Khaled
Author URI: http://www.subarnachar.com/
Plugin update URI: http://www.osclass.org/files/plugins/google_maps/update.php
*/

function google_maps_location() {
    $item = osc_item();
    osc_google_maps_header();
    require 'map.php';
}

// HELPER
function osc_google_maps_header() {
    echo '<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>';
    echo '<style>#itemMap img { max-width: 140em; } </style>';
}

function insert_geo_location($item) {
    $itemId = $item['pk_i_id'];
    $aItem = Item::newInstance()->findByPrimaryKey($itemId);
    $sAddress = (isset($aItem['s_address']) ? $aItem['s_address'] : '');
    $sCity = (isset($aItem['s_city']) ? $aItem['s_city'] : '');
    $sRegion = (isset($aItem['s_region']) ? $aItem['s_region'] : '');
    $sCountry = (isset($aItem['s_country']) ? $aItem['s_country'] : '');
    $address = sprintf('%s, %s, %s, %s', $sAddress, $sCity, $sRegion, $sCountry);
    $response = osc_file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false', urlencode($address)));
    $jsonResponse = json_decode($response);

    if (isset($jsonResponse->results[0]->geometry->location) && count($jsonResponse->results[0]->geometry->location) > 0) 		{
        $location = $jsonResponse->results[0]->geometry->location;
        $lat = $location->lat;
        $lng = $location->lng;

        ItemLocation::newInstance()->update (array('d_coord_lat' => $lat
            ,'d_coord_long' => $lng)
            ,array('fk_i_item_id' => $itemId));
    }
}

osc_add_hook('location', 'google_maps_location');

osc_add_hook('posted_item', 'insert_geo_location');
osc_add_hook('edited_item', 'insert_geo_location');

?>