<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 03-Oct-16
 * Time: 11:16 PM
 */
importUtils();

class checkout extends BaseModel
{
    private $dbUtil;

    function __construct()
    {
        parent::__construct();
        if(!osc_is_web_user_logged_in()) {
//            Params::setParam("HTTP_REFERER", osc_get_http_referer());
            $this->doView(PLUGIN_VIEW . "redirect.php", array("url"=> osc_user_login_url()));
        }
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->action = Params::getParam("trigger");
        $this->dbUtil->makeDao("t_ec_order", "pk_o_id", array("s_customer_name", "s_customer_email",
            "i_c_id", "pk_o_id", "dt_created", "d_order_total", "s_order_status"));
    }

    function doModel()
    {
        $dbUtil =$this->dbUtil;
        $id = Params::getParam("id");

        switch ($this->action) {
            case "checkout":
                $this->doView(PLUGIN_VIEW."pages/checkout.php", array());
                break;
            case "processPayment":
                $this->doView(PLUGIN_VIEW."pages/processPayment.php", array('params'=>Params::getParamsAsArray()));
                break;
            case "bkashPayment":
                $txnId = Params::getParam("txnId");
                $order = $this->makeOrderFromCart("BKASH", $txnId);
                if($order) {
                    getAppUtil()->emptyCart();
                } else {
                    osc_add_flash_error_message("Order create Failed!");
                    $this->doView(PLUGIN_VIEW."redirect.php", array("url"=>getSiteUrl("checkout", "processPayment")."&paymentGateway=BKASH"));
                }
                $this->doView(PLUGIN_VIEW."pages/orderSuccess.php", array("order"=>$order));
                break;
            default:
                break;
        }
    }

    public function makeOrderFromCart($processor, $ref = null) {
        $cart = getAppUtil()->getCart();
        if(sizeof($cart) == 0) {
            return false;
        }
        $this->dbUtil->insert(array(
            "i_c_id"=>osc_logged_user_id(),
            "s_customer_name"=>osc_logged_user_name(),
            "s_customer_email"=>osc_logged_user_email(),
            "dt_created"=>$this->dbUtil->date(),
            "d_order_total"=>toPrice($cart["grandTotal"], 4)
        ));
        $id = $this->dbUtil->findLastId();
        if($id) {
            $this->dbUtil->makeDao("t_ec_order_item", "pk_item_id", array("s_name", "d_price", "fk_o_id"));
            foreach($cart["items"] as $item) {
                $this->dbUtil->insert(array(
                    "s_name"=>$item["name"],
                    "d_price"=>$item["price"],
                    "fk_o_id"=>$id
                ));
            }
            if(!is_null($ref)) {
                $this->makePayment($id, $cart["grandTotal"], $processor, $ref);
            }
        }

        return $this->dbUtil->makeDao("t_ec_order", "pk_o_id")->findByPrimaryKey($id);
    }

    public function makePayment($orderId, $total, $gateway, $ref) {
        $this->dbUtil->makeDao("t_ec_payment", "pk_pay_id", array("pk_pay_id", "s_gateway_name", "s_payment_status",
            "fk_o_id", "s_customer_email", "d_payment_total", "b_order_status", "dt_created", "s_payment_ref"));
        $this->dbUtil->insert(array(
            "fk_o_id"=>$orderId,
            "s_gateway_name"=>$gateway,
            "s_payment_ref"=>$ref,
            "s_customer_email"=>osc_logged_user_email(),
            "dt_created"=>$this->dbUtil->date(),
            "d_payment_total"=>$total
        ));
        return true;
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