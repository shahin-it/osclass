<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 07-Aug-16
 * Time: 7:46 PM
 */
importUtils();

class orderAdmin extends AdminSecBaseModel
{
    private $dbUtil;

    function __construct()
    {
        parent::__construct();
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->action = Params::getParam("trigger");
    }
    function doModel()
    {
        parent::doModel();
        $this->dbUtil->makeDao("t_ec_order", "pk_o_id", array("s_customer_name", "s_customer_email",
            "i_c_id", "pk_o_id", "dt_created", "d_order_total", "s_order_status"));
        $dbUtil =$this->dbUtil;
        $id = Params::getParam("id");
        switch ($this->action) {
            case "orderList":
                $param = array('max'=>10);
                if(Params::getParam("offset")) {
                    $param["offset"] = Params::getParam("offset") ?: 10;
                }
                $orders = $dbUtil->listAll(array(), $param);
                $model = $this->getOrderWithItems($orders);
                $this->doView(PLUGIN_VIEW . "admin/orderList.php", array('orders'=>$model));
                break;
            case "paymentList":
                $param = array('max'=>10);
                if(Params::getParam("offset")) {
                    $param["offset"] = Params::getParam("offset") ?: 10;
                }
                $condition = array();
                $orderId = Params::getParam("orderId");
                if($orderId) {
                    $condition = array("fk_o_id"=>$orderId);
                }
                $model = $dbUtil->makeDao("t_ec_payment", "pk_pay_id")->listAll($condition, $param);
                $this->doView(PLUGIN_VIEW . "admin/paymentList.php", array('payments'=>$model));
                break;
            default:
                break;
        }
    }

    function getOrderWithItems($orders) {
        $this->dbUtil->makeDao("t_ec_order_item", "pk_item_id");
        foreach($orders as &$order) {
            $order["items"] = $this->dbUtil->listAll(array("fk_o_id"=>$order["pk_o_id"]));
        }
        return $orders;
    }

    function doView($file, $model = array())
    {
        $this->_exportVariableToView('model', $model);
        osc_run_hook("before_admin_html");
        require_once(osc_plugin_path($file));
        Session::newInstance()->_clearVariables();
        osc_run_hook("after_admin_html");
    }
}