<?php
include '../utils/database.php';
include '../utils/sessionManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
} else {
    $user_id = $_SESSION['user']['USER_ID'];
}

$method = $_GET['method'];
$slot = $_POST['custom'];
$txn_id = isset($_POST['txn_id']) ? "'" . $_POST['txn_id'] . "'" : "NULL";
$payment_fee = $_POST['payment_fee'] ?? null;
$payment_fee *= 100;
$code = !empty($_GET['voucherCode']) ? "'" . $_GET['voucherCode'] . "'" : "NULL";
$amount = $_POST['payment_gross'] * 100;
$voucher = fetch_row("SELECT * FROM VOUCHERS WHERE VOUCHER_CODE = $code");
if ($voucher) {
    $voucher_discount = $voucher['DISCOUNT_AMOUNT'];
} else {
    $voucher_discount = "NULL";
}
$cart = $_SESSION['user']['cart'] ?? [];

$order = query("INSERT INTO ORDERS (USER_ID, SLOT_ID, AMOUNT, VOUCHER_CODE, VOUCHER_DISCOUNT) VALUES ('$user_id', '$slot', '$amount', $code, $voucher_discount)");
$order_id = get_last_id("ORDERS");

if (!$order) {
    die("Error while processing order");
}

foreach ($cart as $shop) {
    foreach ($shop['products'] as $product_id => $product) {
        $site_discount = $product['site_discount'] * 100;
        $product_discount = $product['product_discount'] * 100;
        query("INSERT INTO ORDER_PRODUCT (ORDER_ID, PRODUCT_ID, SITE_DISCOUNT, PRODUCT_DISCOUNT, QUANTITY) VALUES ('$order_id', '$product_id', $site_discount, $product_discount, '" . $product['quantity'] . "')");
        query("UPDATE PRODUCTS SET STOCK = STOCK - ".$product['quantity']." WHERE PRODUCT_ID = ".$product_id);
    }
}

$payment = query("INSERT INTO PAYMENTS (ORDER_ID, AMOUNT, PAYMENT_METHOD, TXN_ID, PAYMENT_FEE) VALUES ('$order_id', '$amount', '$method', $txn_id, $payment_fee)");

if (!$payment) {
    die("Error while processing order");
} else {
    $_SESSION['user']['cart'] = [];
    header("Location: /paymentSuccess.php?OrderID=$order_id");
}
