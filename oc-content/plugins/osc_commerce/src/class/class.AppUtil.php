<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 05-Aug-16
 * Time: 2:21 AM
 */

class AppUtil
{
    private static $instance;
    private static $session;
    private $dbUtil;

    function __construct() {
        session_start();
        $this->dbUtil = DbUtil::newInstance();
    }

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function base($page = "", $action = "") {
        $url = osc_admin_base_url(true);
        if($page && $action) {
            $url .= "?page=$page&action=$action";
        } elseif($page) {
            $url .= "?page=$page";
        }
        return $url;
    }

    public static function enqueue_script($key, $resUrl, $dependencyArray = array('jquery'), $version = null) {
        if($version == null) {
            $pluginInfo = osc_plugin_get_info(PLUGIN.'/index.php');
            $version = $pluginInfo['version'];
        }
        osc_register_script($key, $resUrl/*.'?version='.$version*/, $dependencyArray);
        osc_enqueue_script($key);
    }

    public static function JSON_RESPONSE($array = array()) {
        echo json_encode($array);
    }

    public static function getFileParam($files) {
        $list = array();
        if(!is_null($files) && !is_null($files["name"])) {
            for($i = 0; $i < sizeof($files["name"]); $i++) {
                $map = array();
                $map['name'] = $files['name'][$i];
                $map['type'] = $files['type'][$i];
                $map['tmp_name'] = $files['tmp_name'][$i];
                $map['error'] = $files['error'][$i];
                $map['size'] = $files['size'][$i];
                array_push($list, $map);
            }
        }
        return $list;
    }

    public static function jsonToObj($str = "{}") {
        if($str == "") {
            $str = "{}";
        }
        return json_decode($str);
    }

    public static function objToJson ($obj) {
        return json_encode($obj);
    }

    public function getCurrentUser() {
        if(osc_logged_user_id()) {
            return array(
                "id"=>$this::$session->_get("userId"),
                "name"=>$this::$session->_get("userName"),
                "email"=>$this::$session->_get("userEmail")
            );
        } else {
            return array();
        }
    }

    function &getCart() {
        return $_SESSION["cartObj"];
    }

    public function addProductToCart($product) {
        if(is_null($product)) {
            return false;
        }
        if(!$this->getCart()) {
            $_SESSION["cartObj"] = array(
                'items'=>array(),
                'subTotal'=>0.0,
                'grandTotal'=>0.0
            );
        }
        $cartObj = &$this->getCart();
        foreach($cartObj["items"] as &$item) {
            if($item['id'] == $product['id']) {
                $item["quantity"] += $product['quantity'];
                $this->refreshCart($cartObj);
                return true;
            }
        }
        array_push($cartObj["items"], $product);
        $this->refreshCart($cartObj);
        return true;
    }

    public function &refreshCart(&$cart) {
        if(is_null($cart)) {
            return;
        }
        $items = &$cart['items'];
        $cart["subTotal"] = 0.00;
        $cart["grandTotal"] = 0.00;
        foreach($items as $key=>$item) {
            if($item["quantity"] == "0") {
                array_splice($items, $key, 1);
            } else {
                $_item = &$items[$key];
                $_item["price"] = $item["rate"] * $item["quantity"];
                $cart["subTotal"] += $item["price"];
                $cart["grandTotal"] += $item["price"];
            }
        }
        return $cart;
    }

    public function emptyCart() {
        $_SESSION["cartObj"] = null;
    }

    public function &removeCartItem($id) {
        return $this->updateCart($id, "0");
    }

    public function &updateCart($id, $quantity) {
        $cart = &$this->getCart();
        if(!$cart || is_null($quantity)) {
            return;
        }
        foreach($cart["items"] as &$item) {
            if($item['id'] == $id) {
                $item["quantity"] = $quantity;
            }
        }
        return $this->refreshCart($cart);
    }

    public function resizeAndSave($source, $dist, $name) {
        $small = imageResulation("small");
        $medium = imageResulation("medium");
        $large = imageResulation("large");

        ImageResizer::fromFile($source)->resizeTo($small, $small)->saveToFile($dist.$small."_".$name);
        ImageResizer::fromFile($source)->resizeTo($medium, $medium)->saveToFile($dist.$medium."_".$name);
        ImageResizer::fromFile($source)->resizeTo($large, $large)->saveToFile($dist.$large."_".$name);
    }

    public function getBaseProductImage($id, $image, $size = "small") {
        return PRODUCT_IMAGE_BASE.($image ? "product-".$id."/".imageResulation($size)."_".$image : "default.png");
    }

    public static function deleteDir($dir) {
        if(!is_dir($dir)) {
            return false;
        }
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}