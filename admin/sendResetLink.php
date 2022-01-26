<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
require_once 'utils/mail.php';
require_once '../mailTemplate.php';
if (isset($_SESSION['admin'])) {
    header('Location: /admin');
    exit();
}
$old = $_POST;
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$user = fetch_row("SELECT * FROM USERS WHERE (USERNAME = '$username' OR EMAIL = '$email') AND USER_ROLE = 1");
if (empty($user)) {
    $_SESSION['message'] = ['message' => 'User not found!', 'color' => 'danger'];
    $_SESSION['old'] = $old;
    header('Location: forgot-password.php');
    exit();
} else if ($user['USERNAME'] != $username || $user['EMAIL'] != $email) {
    $_SESSION['message'] = ['message' => 'Username and email do not match!', 'color' => 'danger'];
    $_SESSION['old'] = $old;
    header('Location: forgot-password.php');
    exit();
} else {
    $token = md5(RAND(4000, 5000));
    $useremail = $user['EMAIL'];
    if (!empty(fetch_row("SELECT * FROM RESET_PASSWORD WHERE EMAIL = '$useremail'")))
        query("UPDATE RESET_PASSWORD SET TOKEN = '$token', CREATED_AT = " . toTime(date('Y/m/d H:i:s')) . " WHERE EMAIL = '$useremail'");
    else
        query("INSERT INTO RESET_PASSWORD (EMAIL, TOKEN, CREATED_AT) VALUES ('$useremail', '$token', " . toTime(date('Y/m/d H:i:s')) . ")");
    $message = "Click the button below to reset your password";
    $link = "http://localhost/admin/resetPassword.php?email=$useremail&token=$token";
    $mail = makeMail($message, $link, "Change Password", $link, "If you ignore this message your password won't be changed.");
    sendMail($useremail, "Reset your OnlineAppetite Password", $mail);
    $_SESSION['message'] = ['message' => 'Reset link sent to your email!', 'color' => 'success'];
    header('Location: forgot-password.php');
}
