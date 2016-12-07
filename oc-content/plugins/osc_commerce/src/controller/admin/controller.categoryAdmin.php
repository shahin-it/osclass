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
                $category = $this->getCategories(array(), $param);
                $this->doView(PLUGIN_VIEW . "admin/categoryList.php", array('category'=>$category));
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
                    $id = $dbUtil->findLastId();
                }
                $image = Params::getFiles("s_image");
                if($image && $id) {
                    $images = $this->saveCategoryImage($image, $id);
                    $props["s_image"] = $images;
                    $save = $dbUtil->updateByPrimaryKey($props, $id);
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
                    getAppUtil()->deleteDir(RESOURCE_BASE_PATH.("image/category/category-".$id));
                    AppUtil::JSON_RESPONSE(array('status'=>"success", 'message'=> "Delete success"));
                }
                break;
            default:
                break;
        }
    }

    public function saveCategoryImage($img, $id = "") {
            $prefix = "category-".$id."/";
            $dir = RESOURCE_BASE_PATH."image/category/".$prefix;
            $file = $img["name"];
            osc_mkdir($dir, 0700);
            $distFile = $dir.$file;
            move_uploaded_file($img['tmp_name'], $distFile);
            try {
                getAppUtil()->resizeAndSave($distFile, $dir, $file);
            } catch(Exception $e) {
                osc_add_flash_error_message($e->getMessage());
            }
        return $file;
    }

    function findRootAble($base)
    {
        if($base) {
            return $this->dbUtil->listAll("WHERE pk_c_id !='".$base."' AND i_parent_id IS NULL AND b_active=1");
        } else {
            return $this->dbUtil->listAll(array());
        }
    }

    function getCategories($conditionMap, $param) {
        $categories = $this->dbUtil->listAll(array(), $param);
        $cate = array();
        foreach ($categories as $c1) {
            $c = $c1;
            foreach ($categories as $c2) {
                if($c2["pk_c_id"] == $c1["i_parent_id"]) {
                    $c["parent"] = $c2;
                }
            }
            array_push($cate, $c);
        }
        return $cate;
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