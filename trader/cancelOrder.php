<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $id = $_GET['id'] ?? '';
}

query("UPDATE ORDER_PRODUCT SET STATUS = 3 WHERE ID = '$id'");

$user_email = fetch_row("SELECT EMAIL FROM ORDER_PRODUCT INNER JOIN ORDERS USING (ORDER_ID) INNER JOIN USERS USING (USER_ID) WHERE ID = '$id'")['EMAIL'];

$mail = makeMail("Sorry,<br>Your Order Has Been Cancelled by trader", "http://localhost/itemOrder.php?id=".$id, "View Order", null, "(Thank you for shopping with us.)");

sendMail($user_email, "Order Cancelled Online Appetite", $mail);

header('Location: viewOrders.php');