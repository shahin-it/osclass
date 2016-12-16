<div class="section-ecommerce layout-left-sidebar osc-ec-template checkout-page">
    <div class="container">
        <div class="row page-heading"><div class="col-sm-12"><h1>Please choose the preferred payment method</h1></div></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <?php renderWidget("special_widget", array("title"=> "Special discount sale"));?>
                </div>
            </div>

            <div class="col-sm-9 content-main product-card padding-right">
                <form class="row payment-list" action="<?php echo getSiteUrl("checkout", "processPayment")?>" submit-type="always" method="post">
                    <div class="row">
                        <div class="col-sm-4 payment-item bkash">
                            <div class="gateway-thumb" title="BKash">
                                <img class="gateway-thumb-image" src="<?php echo RESOURCE_BASE."image/bkash_logo.png" ?>" alt="BKash">
                            </div>
                            <input type="radio" value="BKASH" checked name="paymentGateway">
                            <label class="name">BKash</label>
                        </div>
                        <div class="col-sm-4 payment-item creditcard">
                            <div class="gateway-thumb" title="Credit Card">
                                <img class="gateway-thumb-image" src="<?php echo RESOURCE_BASE."image/cards.png" ?>" alt="BKash">
                            </div>
                            <input type="radio" value="CARD" name="paymentGateway">
                            <label class="name">Credit Card</label>
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" class="btn submit-payment">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>