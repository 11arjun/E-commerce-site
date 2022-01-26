<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $discount_id = $_GET['id'] ?? '';
}

query("DELETE FROM DISCOUNTS WHERE DISCOUNT_ID = '$discount_id'");

header('Location: viewDiscounts.php');