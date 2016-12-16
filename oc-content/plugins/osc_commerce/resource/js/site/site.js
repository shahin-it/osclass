var EcSiteManager = {
    reloadHomePage: function(success) {
        var target = ".home.content, .home #content".jq.last();
        if($.inArray(document.location.pathname, ["/osclass/", "/", "/bv/"]) == -1) {
            return;
        }
        if(target.length) {
            sui.ajax({
                url: app.ajaxBase("site", "home"),
                dataType: "html",
                data: {},
                success: function(resp) {
                    resp = resp.jq;
                    target.after(resp);
                    resp.updateSiteUi();
                    success && success.call(this);
                }
            })
        }
    }
}

$(function() {
	var body = $("body");
    var link = app.base("site", "ecommerce");
    //var navigation = '<div class="container ecommerce-nav fixed-top-nav"><span class="link shop-now" href="'+link+'"><i class="fa fa-area-chart"></i> Shop</span></div>';
    var navigation = '<div class="container ecommerce-nav fixed-top-nav"><div class="row">\
	<div class="col-sm-1"><span class="link shop-now" href="'+link+'"><span class="fa fa-area-chart"></span> Shop</span></div>\
	<div class="col-sm-9"></div>\
	<div class="col-sm-2 drop-container"><span class="cart-list-button"><span class="drop-link"><span class="drop-label cart-popup-link">\
    <span class="cart-widget-text">0 Item | 0.00TK <i class="fa fa-shopping-cart"></i></span></span></span></span></div>\
	</div></div>';
    body.find("#header").prepend(navigation);

    EcSiteManager.reloadHomePage();

    body.on("click", ".submit-button", function() {
        this.jq.parents("form").submit();
    });
    body.on("click", ".link", function() {
        location.href = this.jq.attr("href");
    });
    

    "body".jq.updateSiteUi();
})

if(document.referrer.indexOf("ref=checkout") != -1) {
	location.href = app.base("checkout", "checkout");
}