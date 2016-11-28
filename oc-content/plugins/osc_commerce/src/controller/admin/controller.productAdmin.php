<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 07-Aug-16
 * Time: 7:46 PM
 */
importUtils();
class productAdmin extends AdminSecBaseModel
{
    private $dbUtil;

    function __construct()
    {
        parent::__construct();
//        header("Access-Control-Allow-Origin: *");
//        header("Content-Type: application/json; charset=UTF-8");
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->action = Params::getParam("trigger");
    }

    public function mkModel() {
        $this->dbUtil->makeDao("t_ec_product", "pk_p_id", array("pk_p_id", "s_name", "b_active", "b_is_onsale", "s_url",
            "s_image", "s_brand", "s_model", "s_size", "s_color", "s_description", "d_base_price", "d_sale_price",
            "dt_created", "dt_updated", "fk_c_id", "s_image1", "s_image2", "s_image3", "s_image4"));
    }

    function doModel()
    {
        parent::doModel();
        $this->mkModel();
        $dbUtil = $this->dbUtil;
        $id = Params::getParam("id");
        switch ($this->action) {
            case "list":
                $param = array('max'=>10);
                if(Params::getParam("offset")) {
                    $param["offset"] = Params::getParam("offset") ?: 10;
                }
                $model["product"] = $this->getProducts($param);
                $this->doView(PLUGIN_VIEW . "admin/productList.php", $model);
                break;
            case "save":
                $props = array();
                $props['s_name'] = Params::getParam("s_name");
                $props['b_active'] = Params::getParam("b_active") == "true";
                $props['s_url'] = Params::getParam("s_url") ?: null;

                $props['s_model'] = Params::getParam("s_model");
                $props['s_size'] = Params::getParam("s_size");
                $props['s_color'] = Params::getParam("s_color");

                $props['d_base_price'] = Params::getParam("d_base_price");
                $props['b_is_onsale'] = Params::getParam("b_is_onsale") == "true";
                $props['d_sale_price'] = Params::getParam("d_sale_price") ?: null;

                $props['s_description'] = Params::getParam("s_description");
                $props['fk_c_id'] = Params::getParam("fk_c_id") ?: null;
                $save = true;
                if($id) {
                    $props['dt_updated'] = $dbUtil->date();
                    $save = $dbUtil->updateByPrimaryKey($props, $id);
                } else {
                    $props['dt_created'] = date('Y-m-d h:i:s');
                    $save = $dbUtil->insert($props);
                    $id = $dbUtil->findLastId();
                }
                $images = AppUtil::getFileParam(Params::getFiles("s_image"));
                if($images && $id) {
                    $images = $this->saveProductImage($images, $id);
                    $i = 0;
                    foreach($images as $image) {
                        if($i==0) {
                            $props["s_image"] = $image;
                        } else {
                            $props["s_image".$i] = $image;
                        }
                        $i++;
                    }
                    $save = $dbUtil->updateByPrimaryKey($props, $id);
                }
                if($save == false) {
                    echo json_encode(array('status'=>"error", 'message'=> "Unexpected error occurred!"));
                } else {
                    echo json_encode(array('status'=>"success", 'message'=> "Product save success"));
                }
                break;
            case "edit":
                $model = array();
                if($id) {
                    $model['product'] = $dbUtil->findByPrimaryKey($id);
                } else {
                    $model['product'] = array();
                }
                $model['categories'] = $dbUtil->makeDao("t_ec_category", "pk_c_id")->listAll(array('b_active'=>1));
                $this->doView(PLUGIN_VIEW . "admin/editProduct.php", $model);
                break;
            case "delete":
                $deleted = false;
                if($id) {
                    $deleted = $dbUtil->deleteByPrimaryKey($id);
                }
                if($deleted) {
                    getAppUtil()->deleteDir(PRODUCT_IMAGE_BASE.("product-".$id));
                    echo json_encode(array('status'=>"success", 'message'=> "Delete success"));
                } else {
                    echo json_encode(array('status'=>"error", 'message'=> "Delete failed!"));
                }
                break;
            default:
                break;
        }
    }

    public function saveProductImage($images, $id = "") {
        $files = array();
        if(!is_null($images)) {
            $i = 0;
            foreach($images as $img) {
                $prefix = "product-".$id."/";
                $dir = RESOURCE_BASE_PATH."image/product/".$prefix;
                $file = $i."_".$img["name"];
                osc_mkdir($dir, 0700);
                $distFile = $dir.$file;
                move_uploaded_file($img['tmp_name'], $distFile);
                array_push($files, $file);
                try {
                    getAppUtil()->resizeAndSave($distFile, $dir, $file);
                } catch(Exception $e) {
                    osc_add_flash_error_message($e->getMessage());
                }
                $i++;
            }
        }
        return $files;
    }

    public function getProducts($param) {
        $dbUtil = $this->dbUtil;
        $products = $dbUtil->listAll(array(), $param);
        $category = $dbUtil->makeDao("t_ec_category", "pk_c_id")->listAll(array('b_active'=>1));
        foreach($products as &$prd) {
            foreach($category as $cat) {
                if($prd["fk_c_id"] != null && $prd["fk_c_id"] == $cat["pk_c_id"]) {
                    $prd["category"] = $cat;
                }
            }
        }
        return $products;
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