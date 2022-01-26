<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $order_id = $_GET['id'] ?? '';
}

query("UPDATE ORDERS SET STATUS = 3 WHERE ORDER_ID = '$order_id'");

$user_email = fetch_row("SELECT EMAIL FROM ORDERS INNER JOIN USERS USING (USER_ID) WHERE ORDER_ID = '$order_id'")['EMAIL'];

$mail = makeMail("Your Order Has Been Cancelled", "http://localhost/viewOrder.php?order_id=".$order_id, "View Order", null, "(Thank you for shopping with us.)");

sendMail($user_email, "Order Cancelled Online Appetite", $mail);

header('Location: viewOrders.php');