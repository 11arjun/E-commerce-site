<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
require_once 'utils/mail.php';
require_once 'mailTemplate.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /');
    exit();
}
$userVerified = fetch_row("SELECT * FROM CUSTOMERS WHERE USER_ID = '" . $_SESSION['user']['USER_ID'] . "'");
if (isset($userVerified['EMAIL_VERIFIED_AT'])) {
    $_SESSION['EMAIL_VERIFIED_AT'] = $userVerified['EMAIL_VERIFIED_AT'];
    header('Location: /');
    exit();
}
$token = md5(RAND(4000, 5000));
$useremail = $_SESSION['user']['EMAIL'];
if (!empty(fetch_row("SELECT * FROM VERIFY_EMAIL WHERE EMAIL = '$useremail'")))
    query("UPDATE VERIFY_EMAIL SET TOKEN = '$token', CREATED_AT = " . toTime(date('Y/m/d H:i:s')) . " WHERE EMAIL = '$useremail'");
else
    query("INSERT INTO VERIFY_EMAIL (EMAIL, TOKEN, CREATED_AT) VALUES ('$useremail', '$token', " . toTime(date('Y/m/d H:i:s')) . ")");
$message = "We're glad you're here,<br>" . $useremail;
$link = "http://localhost/verifyUserEmail.php?email=$useremail&token=$token";
$mail = makeMail($message, $link, "Activate Account", null, "(Just confirming you're you.)");
sendMail($useremail, "Verify your OnlineAppetite Account", $mail);
$_SESSION['message'] = ['message' => 'Verification link sent to your email!', 'color' => 'success'];
header("Location: verifyEmail.php");
