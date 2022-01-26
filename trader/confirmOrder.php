<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['trader'])) {
    header('Location: /trader/login.php');
} else {
    $id = $_GET['id'] ?? '';
}

query("UPDATE ORDER_PRODUCT SET STATUS = 2 WHERE ID = '$id'");

$user_email = fetch_row("SELECT EMAIL FROM ORDER_PRODUCT INNER JOIN ORDERS USING (ORDER_ID) INNER JOIN USERS USING (USER_ID) WHERE ID = '$id'")['EMAIL'];

$mail = makeMail("Your Order Has Been Confirmed", "http://localhost/itemOrder.php?id=".$id, "View Order", null, "(Thank you for shopping with us.)");

sendMail($user_email, "Order Confirmed Online Appetite", $mail);

header('Location: viewOrders.php');