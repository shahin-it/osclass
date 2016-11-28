<div class="osc-ec-template checkout-page">
    <div class="payment-method accordion-item expanded" event_name="payment-method-change" step="payment" step_index="4">
        <p class="step-header">Please select the preferred payment method</p>
        <form class="payment-list" action="<?php echo getSiteUrl("checkout", "processPayment")?>" submit-type="always" method="post">
            <div class="payment-item bkash">
                <div class="gateway-thumb" title="BKash">
                    <img class="gateway-thumb-image" src="<?php echo RESOURCE_BASE."image/bkash_logo.png" ?>" alt="BKash">
                </div>
                <input type="radio" value="BKASH" checked name="paymentGateway">
                <label class="name">BKash</label>
            </div>

            <div class="payment-item creditcard">
                <div class="gateway-thumb" title="Credit Card">
                    <img class="gateway-thumb-image" src="<?php echo RESOURCE_BASE."image/cards.png" ?>" alt="BKash">
                </div>
                <input type="radio" value="CARD" name="paymentGateway">
                <label class="name">Credit Card</label>
            </div>

            <div class="button-line">
                <span type="submit" class="sui-button submit-payment">Continue</span>
            </div>
        </form>
    </div>
</div>