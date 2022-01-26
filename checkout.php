<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
$businessEmail = "onlineappetite@gmail.com";
$siteUrl = "http://localhost";
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $cart = $_SESSION['user']['cart'] ?? [];
    $total = 0.0;
    $discountedPrice = 0.0;
    $code = $_GET['voucher'] ?? '';
    $voucher = fetch_row("SELECT * FROM VOUCHERS WHERE VOUCHER_CODE = '$code'");
    foreach ($cart as $shop) {
        foreach ($shop['products'] as $product_id => $product) {
            $total += $product['price'] * $product['quantity'];
            $discountedPrice += $product['discounted_price'] * $product['quantity'];
        }
    }
    if ($voucher && $total > ($voucher['MINIMUM'] / 100)) {
        $discountedPrice -= ($voucher['DISCOUNT_AMOUNT'] / 100);
    } else {
        $code = '';
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/checkout.css">
    <title>Checkout</title>
</head>

<body>
    <?php
    include 'header.php';
    $slots = fetch_all_row("SELECT SLOTS.*, (SELECT COUNT(*) FROM ORDERS WHERE ORDERS.SLOT_ID = SLOTS.SLOT_ID) AS ORDER_COUNT FROM SLOTS");

    ?>
    <!-- Collection Slot -->
    <div class="py-5">
        <div class="container" style="max-width:700px;background-color:#FFFFFF">
            <h2 class="text-center pt-4"> Select Collection Slot </h1>
                <select name="slot" id="slot" style="width:85%; height: 30px" class="my-4 mx-5" onchange="slotChanged(this.value)">
                    <?php foreach ($slots as $slot) { ?>
                        <option value="<?= $slot['ORDER_COUNT'] >= 20 ? '' : $slot['SLOT_ID'] ?>" <?= $slot['ORDER_COUNT'] >= 20 ? 'disabled' : '' ?>><?= $slot['SLOT_TIME'] ?> <?= $slot['ORDER_COUNT'] >= 20 ? '(Full)' : '' ?></option>
                    <?php } ?>
                </select>
        </div>
    </div>
    <!-- Payment Method -->
    <div class="container mb-5" style="max-width:700px;background-color:#FFFFFF">
        <h2 class="text-center py-3"> Select Payment Method </h2>
        <div class="container py-4" style="background-color:#f1f1f1;max-width:600px">
            <h2 class="text-center px-3 mb-3"> Order Summary</h2>
            <div class="amount my-2"><span>Total Amount</span><span><?= number_format($total, 2, '.', '') ?></span></div>
            <div class="amount my-2"><span>Discount Amount</span><span><?= number_format(($total - $discountedPrice), 2, '.', '') ?></span></div>
            <div class="amount my-2"><span>Sub Total</span><span><?= number_format($discountedPrice, 2, '.', '') ?></span></div>
        </div>
        <div class="row mt-4" style="max-width:790px">
            <div class="col-md-4 text-center">
                <div class="payment-option" onclick="alert('Feature not implemented!')">
                    <img src="assets/images/card.png" class="image-fluid" style="width:100px;">
                    <p>Credit/debit Card</p>
                </div>
            </div>

            <div class="col-md-4 text-center px-2">
                <form action="payment/handleOrders.php?voucherCode=<?= $code ?>&method=cash" method="post">
                    <input type='hidden' name='payment_gross' value='<?= $discountedPrice ?>'>
                    <input type='hidden' name='custom' value='1' id="slotData">
                    <button class="payment-option" onclick="event.preventDefault();cashSubmit(this)">
                        <img src="assets/images/cash.png" class="image-fluid" style="width:100px;">
                        <p class="mx-4">Cash On Pickup</p>
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-center">
                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                    <input type='hidden' name='business' value='<?= $businessEmail ?>'>
                    <input type='hidden' name='amount' value='<?= $discountedPrice ?>'>
                    <input type='hidden' name='item_name' value='OnlineAppetite'>
                    <input type='hidden' name='no_shipping' value='1'>
                    <input type='hidden' name='currency_code' value='GBP'>
                    <input type='hidden' name='custom' value='1' id="slotField">
                    <input type='hidden' name='rm' value='2'>
                    <input type="hidden" name="first_name" value="<?= explode(' ', $_SESSION['user']['FULL_NAME'])[0] ?>">
                    <input type="hidden" name="last_name" value="<?= end(explode(' ', $_SESSION['user']['FULL_NAME'])) ?>">
                    <input type="hidden" name="email" value="<?= $_SESSION['user']['EMAIL'] ?>">
                    <input type='hidden' name='cancel_return' value='<?= $siteUrl ?>/paymentCancelled.php'>
                    <input type='hidden' name='return' value='<?= $siteUrl ?>/payment/handleOrders.php?voucherCode=<?= $code ?>&method=paypal'>
                    <input type="hidden" name="cmd" value="_xclick">
                    <button class="payment-option" onclick="event.preventDefault();paypalSubmit(this)">
                        <img src="assets/images/paypal.png" class="image-fluid" style="width:100px;">
                        <p class="mx-4">PayPal</p>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script>
        function slotChanged(val) {
            document.getElementById("slotData").value = val;
            document.getElementById("slotField").value = val;
        }

        function cashSubmit(form) {
            if (document.getElementById("slotData").value != null)
                form.parentElement.submit();
        }

        function paypalSubmit(form) {
            if (document.getElementById("slotField").value != null)
                form.parentElement.submit();
        }
    </script>
</body>

</html>