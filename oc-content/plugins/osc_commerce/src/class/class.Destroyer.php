<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 24-Jul-16
 * Time: 10:35 PM
 */
include_once 'class.DbUtil.php';

class Destroyer
{
    private static $instance;

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function removeTables($tables=null) {
        $dbUtil = DbUtil::newInstance();
        $dbUtil->import(THIS_BASE_PATH."/sql/uninstall.sql");
    }
}