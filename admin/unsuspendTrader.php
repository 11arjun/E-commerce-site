<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $user_id = $_GET['id'] ?? '';
}

query("UPDATE TRADERS SET VERIFIED_AT = ".toDate(date('Y-m-d'),"YYYY-MM-DD").", STATUS = '2' WHERE USER_ID = '$user_id'");

$user_email = fetch_row("SELECT EMAIL FROM USERS WHERE USER_ID = '$user_id'")['EMAIL'];

$mail = makeMail("Your Account Has Been Unsuspended", "http://localhost/trader", "Login Now", null, "(Thank you for partnering with us.)");

sendMail($user_email, "Account Unsuspended Online Appetite", $mail);

header('Location: viewTraders.php');