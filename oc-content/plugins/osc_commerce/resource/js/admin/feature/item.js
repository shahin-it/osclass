/**
 * Created by shahin on 05-Aug-16.
 */

//category part
$(function() {
    var category_list_tab = {};
    app.tab.category_list = function() {
        this.loading_url = app.ajaxBase("categoryAdmin", "list");
        this.id = "category-tab";
        this.processor = category_list_tab;
        return this;
    }

    var _c = category_list_tab;

    _c.init = function() {
        var _self = this;
        _self.body.find(".tool-item .add-new").click(function() {
            _self.editCategory();
        })
        _self.body.find(".navigator .edit").click(function() {
            var data = this.jq.parent().data() || {};
            _c.editCategory(data);
        });
        _self.body.find(".navigator .delete").click(function() {
            var data = this.jq.parent().data() || {};
            _c.deleteCategory(data.id);
        });
    }

    _c.editCategory = function(data) {
        var _self = this;
        data = $.extend({
            id: null,
            name: null
        }, data);
        var title = data.id ? "Edit category" : "New category"
        var popup = sui.editPopup(app.ajaxBase("categoryAdmin", "edit"), title, data, {
            success: function() {
                _self.reload();
            }
        });
    }

    _c.deleteCategory = function(id) {
        var _self = this;
        sui.confirmDelete(app.ajaxBase("categoryAdmin", "delete"), "Are you sure?", {id: id}, function() {
            _self.reload();
        });
    }
});


//Product part
$(function() {
    var product_list_tab = {};
    app.tab.product_list = function() {
        this.loading_url = app.ajaxBase("productAdmin", "list");
        this.id = "product-tab";
        this.processor = product_list_tab;
        return this;
    }

    var _p = product_list_tab;

    _p.init = function() {
        var _self = this;
        _self.body.find(".tool-item .add-new").click(function() {
            _self.editProduct();
        })
        _self.body.find(".navigator .edit").click(function() {
            var data = this.jq.parent().data() || {};
            _self.editProduct(data);
        })
        _self.body.find(".navigator .delete").click(function() {
            var data = this.jq.parent().data() || {};
            _self.deleteProduct(data.id);
        })

    }

    _p.editProduct = function(data) {
        var _self = this;
        data = $.extend({
            id: null,
            name: null
        }, data);
        var title = data.id ? "Edit product" : "New product"
        var popup = sui.editPopup(app.ajaxBase("productAdmin", "edit"), title, data, {
            success: function() {
                _self.reload();
            }
        });
    }

    _p.deleteProduct = function(id) {
        var _self = this;
        sui.confirmDelete(app.ajaxBase("productAdmin", "delete"), "Are you sure?", {id: id}, function() {
            _self.reload();
        });
    }
})