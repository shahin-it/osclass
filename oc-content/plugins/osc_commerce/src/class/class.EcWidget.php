<?php
/**
 * Created by IntelliJ IDEA.
 * User: mbstu
 * Date: 03-Dec-16
 * Time: 2:14 AM
 */
importUtils();

class EcWidget
{
    private static $instance;
    private $dbUtil;

    function __construct()
    {
        $this->ajax = true;
        $this->dbUtil = DbUtil::newInstance();
        require_once THIS_BASE_PATH."/src/controller/controller.items.php";
        $this->itemController = new items();
        $this->action = Params::getParam("trigger");
    }

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function renderWidget($type, $arguments = array()) {
        $model = $arguments;
        switch ($type) {
            case "category_block":
                $model["categories"] = $this->itemController->getCategoryWithChild();
                require_once(osc_plugin_path(PLUGIN_VIEW."widget/categoryDetails.php"));
                break;
            case "product_sidebar":
                $this->dbUtil->makeDao("t_ec_product", "pk_p_id");
                $model["products"] = $this->itemController->getProduct();
                require_once(osc_plugin_path(PLUGIN_VIEW."widget/productSidebar.php"));
                break;
            case "contact_us":
                break;
            case "related_product":
                break;
            case "payment_info":
                break;
            case "product_grid":
                $this->dbUtil->makeDao("t_ec_product", "pk_p_id");
                $model["products"] = $this->itemController->getProduct();
                require_once(osc_plugin_path(PLUGIN_VIEW."widget/productGrid.php"));
                break;
            default:
                echo $type." widget not found";
                break;
        }
        $model = array();
    }
}