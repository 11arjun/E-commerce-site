<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $product_id = $_GET['id'] ?? '';
}

query("UPDATE PRODUCTS SET CONFIRMED_ON = ".toDate(date('Y-m-d'),"YYYY-MM-DD")." WHERE PRODUCT_ID = '$product_id'");

header('Location: viewProducts.php');