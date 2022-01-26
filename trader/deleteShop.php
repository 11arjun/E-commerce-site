<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['trader'])) {
    header('Location: /trader/login.php');
} else {
    $shop_id = $_GET['id'] ?? '';
    $user_id = $_SESSION['trader']['USER_ID'];
}

$shop = fetch_row("SELECT * FROM SHOPS WHERE SHOP_ID = '$shop_id'");

if($shop['TRADER_ID']!=$user_id){
    header('Location: ../401.php');
    exit();
}

query("DELETE FROM SHOPS WHERE SHOP_ID = '$shop_id'");

header('Location: viewShops.php');