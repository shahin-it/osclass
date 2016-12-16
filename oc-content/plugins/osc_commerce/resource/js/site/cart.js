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
                resp.updateSiteUi();
                success && success.call(this, resp);
            }
        })
        $("body").css({paddingTop: navigation.outerHeight()})
    },
    bindRemoveCartItem: function(page) {
        page.find(".remove-cartitem").click(function() {
            page.loader();
            sui.ajax({
                url: app.ajaxBase("cart", "remove"),
                data: this.jq.data(),
                success: function() {
                    location.reload();
                }
            });
        })
    }
}
$(function() {
    var navigation = ".ecommerce-nav".jq;
    var cartButton = navigation.find(".cart-list-button");
    CartManager.reloadCartPopup(function (resp) {
        CartManager.bindRemoveCartItem(resp.find(".cart-list-popup"));
    });
    var rePosition = true;
    $("body").on("click", ".drop-link .drop-label", function() {
        var popup = this.jq.next(".drop-child");
		popup.stop().slideToggle(function() {
			popup.focus();
			if(!popup.is(":hidden")) {
			    reposition = false;
            }
		}).one("blur", function() {
            popup.stop().slideToggle();
        })
        if(rePosition) {
            popup.position({
                my: "right top+" + navigation.outerHeight(),
                at: "right top",
                of: ".ecommerce-nav"
            })
        }
        return false;
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
    CartManager.bindRemoveCartItem(cartPage);
});