<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $voucher_id = $_GET['id'] ?? '';
}

query("DELETE FROM VOUCHERS WHERE VOUCHER_ID = '$voucher_id'");

header('Location: viewVouchers.php');