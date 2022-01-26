<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['trader'])) {
    header('Location: /trader/login.php');
} else {
    $product_id = $_GET['id'] ?? '';
    $user_id = $_SESSION['trader']['USER_ID'];
}

$product = fetch_row("SELECT * FROM PRODUCTS WHERE PRODUCT_ID = '$product_id'");

if($product['TRADER_ID']!=$user_id){
    header('Location: ../401.php');
    exit();
}

query("DELETE FROM PRODUCTS WHERE PRODUCT_ID = '$product_id'");

header('Location: viewProducts.php');