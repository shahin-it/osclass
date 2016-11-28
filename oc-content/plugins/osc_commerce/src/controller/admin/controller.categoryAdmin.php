<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 07-Aug-16
 * Time: 7:46 PM
 */
importUtils();

class categoryAdmin extends AdminSecBaseModel
{
    private $dbUtil;

    function __construct()
    {
        parent::__construct();
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->action = Params::getParam("trigger");
    }

    public function mkModel() {
        $this->dbUtil->makeDao("t_ec_category", "pk_c_id", array("pk_c_id", "b_active", "s_name", "s_image", "s_description",
            "dt_created", "i_parent_id"));
    }

    function doModel()
    {
        parent::doModel();
        $this->mkModel();
        $dbUtil =$this->dbUtil;
        $id = Params::getParam("id");
        switch ($this->action) {
            case "list":
                $param = array('max'=>10);
                if(Params::getParam("offset")) {
                    $param["offset"] = Params::getParam("offset") ?: 10;
                }
                $model = $dbUtil->listAll(array(), $param);
                $this->doView(PLUGIN_VIEW . "admin/categoryList.php", array('category'=>$model));
                break;
            case "save":
                $props = array();
                $props['s_name'] = Params::getParam("s_name");
                $props['b_active'] = Params::getParam("b_active") == "true";
                $props['s_description'] = Params::getParam("s_description");
                $props['i_parent_id'] = Params::getParam("i_parent_id") ?: null;
                $save = true;
                if($id) {
                    $image = Params::getFiles("s_image");
                    if($image) {
                    }
                    $save = $dbUtil->updateByPrimaryKey($props, $id);
                } else {
                    $props['dt_created'] = $dbUtil->date();
                    $save = $dbUtil->insert($props);
                }
                if($save == false) {
                    AppUtil::JSON_RESPONSE(array('status'=>"error", 'message'=> "Unexpected error occurred!"));
                } else {
                    AppUtil::JSON_RESPONSE(array('status'=>"success", 'message'=> "Category save success"));
                }
                break;
            case "edit":
                $model = array();
                if($id) {
                    $model['category'] = $dbUtil->findByPrimaryKey($id);
                } else {
                    $model['category'] = array();
                }
                $model["parents"] = $this->findRootAble($id);
                $this->doView(PLUGIN_VIEW . "admin/editCategory.php", $model);
                break;
            case "delete":
                header('Content-Type: application/json');
                $deleted = false;
                if($id) {
                    $deleted = $dbUtil->deleteByPrimaryKey($id);
                }
                if($deleted == false) {
                    AppUtil::JSON_RESPONSE(array('status'=>"error", 'message'=> "Delete failed!"));
                } else {
                    AppUtil::JSON_RESPONSE(array('status'=>"success", 'message'=> "Delete success"));
                }
                break;
            default:
                break;
        }
    }

    function findRootAble($base)
    {
        if($base) {
            return $this->dbUtil->dao->query("SELECT * FROM ".DB_TABLE_PREFIX."t_ec_category WHERE pk_c_id !='".$base."' AND b_active=1")->result();
        } else {
            return $this->dbUtil->listAll(array());
        }
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