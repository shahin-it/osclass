/**
 * Created by shahin on 05-Aug-16.
 */
$(function() {
    $(".add-to-cart").on("click", function() {
        var _this = this.jq;
        var data = _this.data();
        var quantity = _this.prev(".product-quantity-selector").val();
        if(quantity > 0) {
            quantity = Math.round(+quantity, -1);
            data.quantity = quantity
        }
        sui.ajax({
            url: app.ajaxBase("cart", "add"),
            data: data,
            success: function(resp) {
                CartManager.reloadCartPopup(function() {
                    sui.notify(resp.message, "success");
                });
            }
        })
    })
})