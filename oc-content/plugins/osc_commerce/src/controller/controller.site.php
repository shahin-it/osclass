<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 13-Aug-16
 * Time: 5:01 PM
 */
importUtils();

class site extends BaseModel
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
            case "home":
                $this->doView(PLUGIN_VIEW . "pages/home.php", array("cartObj"=>$cartObj));
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