<?php
require_once '../utils/sessionManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $cart = $_SESSION['user']['cart'] ?? [];
}

$products = $_POST['product'] ?? [];

foreach ($products as $product) {
    foreach ($cart as $shop_id => $shop) {
        if (array_key_exists($product, $shop['products'])) {
            unset($shop['products'][$product]);
            if(count($shop['products'])==0){
                unset($cart[$shop_id]);
            }
            else {
                $cart[$shop_id] = $shop;
            }
            break;
        }
    }
}

$_SESSION['user']['cart'] = $cart;

header('Location: /cart.php');
