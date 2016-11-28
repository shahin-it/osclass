<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 13-Aug-16
 * Time: 5:01 PM
 */
importUtils();

class cart extends BaseModel
{
    private $dbUtil;
    private $appUtil;
    private $session;

    function __construct()
    {
        parent::__construct();
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->appUtil = AppUtil::newInstance();
        $this->action = Params::getParam("trigger");
        $this->session = Session::newInstance();
    }

    function doModel()
    {
        $dbUtil =$this->dbUtil;
        $appUtil =$this->appUtil;
        $id = Params::getParam("id");
        $cartObj = &getAppUtil()->getCart();

        switch ($this->action) {
            case "add":
                $product = $dbUtil->makeDao("t_ec_product", "pk_p_id")->findByPrimaryKey($id);
                $rate = $product["b_is_onsale"] == "1" ? $product["d_sale_price"] : $product["d_base_price"];
                $quantity = Params::getParam("quantity") ?: "1";
                $productData = array(
                    "id"=>$product["pk_p_id"],
                    "name"=>$product["s_name"],
                    "image"=>($product["s_image"] ?: "default.png"),
                    "quantity"=>$quantity,
                    "rate"=>$rate,
                    "price"=>$rate * $quantity
                );
                if($appUtil->addProductToCart($productData)) {
                    AppUtil::JSON_RESPONSE(array('status'=>"success", 'message'=> "\"".$product["s_name"]."\" added to cart successfully"));
                } else {
                    AppUtil::JSON_RESPONSE(array('status'=>"error", 'message'=> "Failed to add cart"));
                }
                break;
            case "update":
                $data = Params::getParam("items");
                foreach($data as $id=>$quantity) {
                    $appUtil->updateCart($id, $quantity);
                }
                AppUtil::JSON_RESPONSE(array('status'=>"success"));
                break;
            case "empty":
                $appUtil->emptyCart();
                $this->doView(PLUGIN_VIEW . "pages/cartDetails.php", array("cartObj"=>null));
                break;
            case "remove":
                $appUtil->removeCartItem($id);
                AppUtil::JSON_RESPONSE(array('status'=>"success"));
                break;
            case "cartPopup":
                $appUtil->refreshCart($cartObj);
                $this->doView(PLUGIN_VIEW . "cartPopup.php", array("cartObj"=>$cartObj));
                break;
            case "details":
                $appUtil->refreshCart($cartObj);
                $this->doView(PLUGIN_VIEW . "pages/cartDetails.php", array("cartObj"=>$cartObj));
                break;
            default:
                break;
        }
    }


    function doView($file, $model = array())
    {
        $this->_exportVariableToView('model', $model);
        osc_run_hook("before_html");
        require_once(osc_plugin_path($file));
        Session::newInstance()->_clearVariables();
        osc_run_hook("after_html");
    }
}
?>