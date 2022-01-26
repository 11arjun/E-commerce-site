<?php
require_once '../utils/sessionManager.php';

$error = "";

if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $cart = $_SESSION['user']['cart'] ?? [];
}

$product = $_POST['product'] ?? '';
$quantity = $_POST['quantity'] ?? '';
if (!empty($product) && !empty($quantity)) {
    foreach ($cart as $shop_id => $shop) {
        if (array_key_exists($product, $shop['products'])) {
            if ($quantity <= 0) {
                $error = "Quantity cannot be 0";
            } else if ($quantity > $cart[$shop_id]['products'][$product]['stock']) {
                $error = "Out of stock";
            } else {
                $cart[$shop_id]['products'][$product]['quantity'] = $quantity;
            }
        }
        break;
    }
}
$_SESSION['user']['cart'] = $cart;

$price = 0;
foreach ($cart as $shop) {
    foreach ($shop['products'] as $product) {
        $price += ($product['discounted_price'] * $product['quantity']);
    }
}

if (empty($error)) {
    echo json_encode(['status' => 'success', 'message' => '', 'totalPrice' => number_format((float)$price, 2, '.', '')]);
} else {
    echo json_encode(['status' => 'error', 'message' => $error]);
}
exit();
