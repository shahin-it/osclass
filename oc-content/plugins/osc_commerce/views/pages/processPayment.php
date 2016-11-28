<?php
$params = $model['params'];
$cart = getAppUtil()->getCart();
?>
<div class="osc-ec-template payment-page">
    <?php if($params["paymentGateway"] == "BKASH") {?>
        <div class="payment-inst bkash">
            <div class="inst-panel left">
                <div class="header">
                    <h3>How to Make Payment using bKash Account</h3>
                    <span class="title">If you have a bKash account then follow the steps below</span>
                </div>
                <div class="body">
                    <div class="info-row">
                        <label class="label">STEP 1</label>
                        <span class="value">Dial *247#</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 2</label>
                        <span class="value">Choose Option: "Payment"</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 3</label>
                        <span class="value">Enter Merchant bKash Account No: xxxxxxxxxxx</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 4</label>
                        <span class="value">Enter Amount: xx</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 5</label>
                        <span class="value">Enter Reference: xxxxxxxxxx</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 6</label>
                        <span class="value">Enter Counter No: 1</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 7</label>
                        <span class="value">Enter Your Pin to Confirm the Transaction: xxxxx</span>
                    </div>
                    <div class="info-row">
                        <label class="label">STEP 8</label>
                        <span class="value">Use Mobile number and Transaction ID to complete your Transaction</span>
                    </div>
                </div>
            </div>
            <div class="inst-panel right">
                <div class="header">
                    <h3>Having Problems? Call Support:  +880 1xxxxxxxxx</h3>
                </div>
                <div class="body">
                    <form action="<?php echo getSiteUrl("checkout", "bkashPayment")?>" method="post">
                        <div class="info-row">
                            <label class="label">Merchant bKash Account No</label>
                            <span class="value">xxxxxxxxxxx</span>
                        </div>
                        <div class="info-row">
                            <label class="label">Amount</label>
                            <span class="value"><?php echo toPrice($cart["grandTotal"]).CURRENCY_SYMBOL?></span>
                        </div>
                        <div class="info-row">
                            <label class="label">Reference</label>
                            <span class="value">xxxxxxxxxx</span>
                        </div>
                        <div class="form-row">
                            <label class="label">Transection ID</label>
                            <input type="text" class="" name="txnId">
                        </div>
                        <div class="button-row">
                            <span class="sui-button submit-button">Submit</span>
                            <a class="sui-button cancel-button" href="<?php echo getSiteUrl("checkout", "checkout")?>">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php }?>
</div>
