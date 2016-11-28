<?php
$order = $model["order"]
?>
<div class="osc-ec-template order-success-page">
    <pre>
        Congratulations! your order is successfully processed..
        Your order id#<?php echo $order["pk_o_id"]?>, Please keep this for farther queries.
        Thank you for with us..
        <a href="<?php echo getSiteUrl("items", "product-list")?>">Continue</a> Shopping...
    </pre>
</div>
