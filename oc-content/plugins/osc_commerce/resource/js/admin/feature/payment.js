/**
 * Created by shahin on 05-Aug-16.
 */
$(function() {
    var payment_list_tab = {};
    app.tab.payment_list_tab = function() {
        this.loading_url = app.ajaxBase("orderAdmin", "paymentList");
        this.id = "payment-tab";
        this.processor = payment_list_tab;
        return this;
    }

    var _p = payment_list_tab;

    _p.init = function() {
        var _self = this;
        _self.body.find(".navigator .cancel").click(function() {
            var data = this.jq.parent().data() || {};
            _p.cancelPayment(data.id);
        });
    }

    _p.cancelPayment = function(id) {
        var _self = this;
        sui.confirmDelete(app.ajaxBase("orderAdmin", "cancel-payment"), "Are you sure?", {id: id}, function() {
            _self.reload();
        });
    }
});