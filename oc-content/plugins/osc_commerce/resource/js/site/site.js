var EcSiteManager = {
    reloadHomePage: function(success) {
        var footer = "body.home #footer".jq;
        if(footer.length) {
            sui.ajax({
                url: app.ajaxBase("site", "home"),
                dataType: "html",
                data: {},
                success: function(resp) {
                    resp = resp.jq;
                    footer.before(resp);
                    resp.updateSiteUi();
                    success && success.call(this);
                }
            })
        }
    }
}

$(function() {
    var link = app.base("site", "ecommerce");
    var navigation = '<div class="ecommerce-nav fixed-top-nav"><span class="link shop-now" href="'+link+'"><i class="fa fa-area-chart"></i> Shop</span></div>';
    "body #header".jq.prepend(navigation);

    EcSiteManager.reloadHomePage();

    $("body").on("click", ".submit-button", function() {
        this.jq.parents("form").submit();
    });
    $("body").on("click", ".link", function() {
        location.href = this.jq.attr("href");
    });
    "body".jq.updateSiteUi();
})