<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 04-Oct-16
 * Time: 12:56 AM
 */
ob_start();
osc_redirect_to($model['url']);
ob_flush();
?>