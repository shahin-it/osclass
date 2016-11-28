/**
 * Created by shahin on 05-Aug-16.
 */
var CartManager = {
    reloadCartPopup: function(success) {
        var navigation = ".ecommerce-nav".jq;
        sui.ajax({
            url: app.ajaxBase("cart", "cartPopup"),
            dataType: "html",
            data: {},
            success: function(resp) {
                resp = resp.jq;
                navigation.find(".drop-link").replaceWith(resp);
                resp.updateUi();
                success && success.call(this);
            }
        })
        $("body").css({paddingTop: navigation.outerHeight()})
    }
}
$(function() {
    var navigation = ".ecommerce-nav".jq;
    var cartButton = $('<span class="cart-list-button"><span class="drop-link"><span class="drop-label cart-popup-link">' +
        '<span class="cart-widget-text">0 Item | 0.00TK <i class="fa fa-shopping-cart"></i></span></span>' +
        '</span></span>');
    navigation.append(cartButton);
    CartManager.reloadCartPopup();
    $("body").on("click", ".drop-link .drop-label", function() {
        var popup = this.jq.next(".drop-child");
        popup.slideToggle(function() {
            popup.focus();
        });
        popup.one("blur", function() {
            popup.slideToggle();
        })
        popup.position({
            my: "right top+" + navigation.outerHeight(),
            at: "right top",
            of: ".ecommerce-nav"
        })
    });
    var cartPage = $(".cart-details-page");
    var updateBtn = cartPage.find(".update-cartitem-btn");
    updateBtn.click(function() {
        var data = {}
        cartPage.find(".quantity-spinner").each(function() {
            data["items["+this.jq.data("id")+"]"] = this.value;
        })
        cartPage.loader();
        sui.ajax({
            url: app.ajaxBase("cart", "update"),
            data: data,
            success: function() {
                location.href = app.base("cart", "details");
            }
        });
    })
    cartPage.find(".quantity-spinner").on("change", function() {
        updateBtn.show();
    })
    cartPage.find(".remove-cartitem").click(function() {
        cartPage.loader();
        sui.ajax({
            url: app.ajaxBase("cart", "remove"),
            data: this.jq.data(),
            success: function() {
                location.href = app.base("cart", "details");
            }
        });
    })
});