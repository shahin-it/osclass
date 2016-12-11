<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 13-Aug-16
 * Time: 5:01 PM
 */
importUtils();

class items extends BaseModel
{
    private $dbUtil;

    function __construct()
    {
        parent::__construct();
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        $this->action = Params::getParam("trigger");
    }

    public function mkProductModel() {
        return $this->dbUtil->makeDao("t_ec_product", "pk_p_id", array("pk_p_id", "s_name", "b_active", "b_is_onsale", "s_url",
            "s_image", "s_brand", "s_model", "s_size", "s_color", "s_description", "d_base_price", "d_sale_price",
            "dt_created", "dt_updated", "fk_c_id", "s_image1", "s_image2", "s_image3", "s_image4"));
    }

    public function mkCategoryModel() {
        return $this->dbUtil->makeDao("t_ec_category", "pk_c_id", array("pk_c_id", "b_active", "s_name", "s_image", "s_description",
            "dt_created", "i_parent_id"));
    }

    function doModel()
    {
        $dbUtil = $this->dbUtil;
        $id = Params::getParam("id");

        switch ($this->action) {
            case "product-list":
                $categoryId = Params::getParam("category");
                $categories = array();
                $products = array();
                if($categoryId == null) {
                    $products = $this->getProducts();
                } elseif($categoryId == "root") {
                    $products = $this->getProducts(array('fk_c_id'=>null));
                } else {
                    $products = $this->getProducts(array('fk_c_id'=>$categoryId));
                }
                $this->doView(PLUGIN_VIEW . "pages/home.php", array("categories"=>$categories, "products"=>$products));
                break;
            case "category-details":
                $model = array();
                $model["products"] = $this->getProducts(array("fk_c_id"=> $id));
                if($model["products"]) {
                    $model["title"] = "Category details - ".$this->mkCategoryModel()->findByPrimaryKey($id)["s_name"];
                }
                $this->doView(PLUGIN_VIEW . "pages/categoryDetails.php", $model);
                break;
            case "product-details":
                $product = $this->getProducts(array("pk_p_id"=> $id))[0];
                $this->doView(PLUGIN_VIEW . "pages/productDetails.php", array("product"=> $product));
                break;
        }
    }

    public function getProducts($condition = array(), $param = array()) {
        $this->mkProductModel();
        $condition = array_merge(array(
            'b_active'=>1
        ), $condition);
        $products = $this->dbUtil->makeDao("t_ec_product", "pk_p_id")->listAll($condition, $param);
        foreach($products as &$prd) {
            if(is_null($prd["fk_c_id"])) {
                $prd["category"] = $this->dbUtil->makeDao("t_ec_category", "pk_c_id")->listAll(array('b_active'=>1, 'pk_c_id'=>$prd["fk_c_id"]))[0];
            }
            if($prd['b_is_onsale'] == "1") {
                $prd["display_price"] = $prd['d_sale_price'];
            } else {
                $prd["display_price"] = $prd['d_base_price'];
            }
        }
        return $products;
    }

    public function getRelatedProduct($product, $condition = array(), $param = array()) {
        $this->mkProductModel();
        $condition = array_merge(array(
            'b_active'=>1
        ), $condition);
        $products = array();
        foreach ($this->getProducts($condition, $param) as $prd) {
            if($prd["pk_p_id"] != $product["pk_p_id"] && $prd["fk_c_id"] == $product["fk_c_id"]) {
                array_push($products, $prd);
            }
        }
        return $products;
    }

    public function getCategoryWithChild($catParam = array(), $prdParam = array()) {
        $dbUtil = $this->dbUtil;
        $categories = array();
        global $products;
        $products = $this->getProducts(array('b_active'=>1), $prdParam);
        $category = $dbUtil->makeDao("t_ec_category", "pk_c_id")->listAll(array('b_active'=>1), $catParam);
        foreach ($category as $item) {
            global $__cat;
            $__cat = $item;
            if($__cat["i_parent_id"] == null) {
                $__cat["products"] = $this->getChildProducts($products, $__cat);
                $__cat["child"] = array_filter($category, function (&$child) {
                    global $__cat;
                    global $products;
                    $valid = $__cat["pk_c_id"] != $child["pk_c_id"] && $__cat["pk_c_id"] == $child["i_parent_id"];
                    if($valid) {
                        $child["products"] = $this->getChildProducts($products, $child);
                    }
                    return $valid;
                });
                array_push($categories, $__cat);
            }
        }
        return $categories;
    }

    private function getChildProducts($products, $parentCategory) {
        global $____category;
        $____category = $parentCategory;
        return array_filter($products, function ($prd) {
            global $____category;
            return $____category["pk_c_id"] == $prd["fk_c_id"];
        });
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