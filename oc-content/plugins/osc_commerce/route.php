<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 13-Aug-16
 * Time: 4:01 PM
 */

$page = Params::getParam('controller');
$dir = OC_ADMIN ? "admin/" : "";

require_once(THIS_BASE_PATH . 'src/controller/'.$dir.'controller.'.$page.'.php');
$do = new $page();
Params::setParam("action", Params::getParam("trigger"));
$do->doModel();