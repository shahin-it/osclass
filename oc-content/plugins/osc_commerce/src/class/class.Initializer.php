<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 22-Jul-16
 * Time: 1:24 AM
 */
include_once 'class.DbUtil.php';

class Initializer
{
    private static $instance;

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function init(&$callBack = null) {
        $conn = DbUtil::getConnection();
        $dbUtil = DbUtil::newInstance();
        if($dbUtil->import(THIS_BASE_PATH."/sql/install.sql")) {
            if($callBack != null) {
                call_user_func($callBack);
            }
        }
        return true;
    }

}