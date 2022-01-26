<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['trader'])) {
    header('Location: /trader/login.php');
} else {
    $discount_id = $_GET['id'] ?? '';
    $user_id = $_SESSION['trader']['USER_ID'];
}

$discount = fetch_row("SELECT * FROM DISCOUNTS WHERE DISCOUNT_ID = '$discount_id'");

if($discount['CREATED_BY']!=$user_id){
    header('Location: ../401.php');
    exit();
}

query("DELETE FROM DISCOUNTS WHERE DISCOUNT_ID = '$discount_id'");

header('Location: viewDiscounts.php');