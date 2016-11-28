/**
 * Created by shahin on 05-Aug-16.
 */
$(function() {
    var checkoutPage = $(".checkout-page");
    checkoutPage.find(".payment-item").click(function() {
        this.jq.find("input[type=radio]").prop("checked", true);
    });
    checkoutPage.find(".submit-payment").click(function() {
        checkoutPage.find("form.payment-list").submit();
    })
})