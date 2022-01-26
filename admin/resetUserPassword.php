<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $user_id = $_POST['id'] ?? '';
}

$user_email = fetch_row("SELECT EMAIL FROM USERS WHERE USER_ID = '$user_id'")['EMAIL'];

$pass = random_str(10);

$mail = makeMail("Your Password Has Been Reset by Administrator.<br>New password: ".$password, "http://localhost/signin.php", "Login Now", null, "(Thank you for shopping with us.)");
sendMail($user_email, "Account Password Reset Online Appetite", $mail);

$password = md5($pass);

$sql = "UPDATE USERS SET PASSWORD_HASH = '$password' WHERE USER_ID = '$user_id'";
if (!query($sql)) {
    $response = ["message" => "Error changing password", 'status' => "error"];
} else {
    $response = ["message" => "Password changed successfully", 'status' => "success"];
}
echo json_encode($response);

function random_str($length)
{
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
