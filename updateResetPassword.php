<?php
include 'utils/database.php';
include 'utils/sessionManager.php';
require_once 'utils/mail.php';
require_once 'mailTemplate.php';
extract($_POST);
$errors = [];
$reset = fetch_row("SELECT * FROM RESET_PASSWORD WHERE EMAIL = '$email'");
$user = fetch_row("SELECT * FROM USERS WHERE EMAIL = '$email' AND USER_ROLE = 3");
if (!empty($reset)) {
    $expires = strtotime('+1 hour', strtotime($reset['CREATED_AT']));
  }
if (empty($reset)) {
    $_SESSION['message'] = ['message' => "Reset link is invalid", 'color' => "danger"];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else if (empty($user)) {
    $_SESSION['message'] = ['message' => "Reset link is invalid", 'color' => "danger"];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else if ($reset['TOKEN'] != $token) {
    $_SESSION['message'] = ['message' => "Reset token is invalid", 'color' => "danger"];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else if ($expires < strtotime("now")) {
    $_SESSION['message'] = ['message' => "Reset token expired", 'color' => "danger"];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
if (empty($password)) {
    $errors['password'] = "Password is required.";
} elseif (strlen($password) < 8) {
    $errors['password'] = "Password must be atleast 8 characters long.";
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', $password)) {
    $errors['password'] = "Include atleast one Uppercase, Number and Special character";
} elseif ($password != $confirm) {
    $errors['confirm'] = "Password Confirmation does not match.";
}
if (sizeof($errors) == 0) {
    $password = md5($password);
    $sql = "UPDATE USERS SET PASSWORD_HASH = '$password' WHERE EMAIL = '$email'";
    if (!query($sql)) {
        $_SESSION['message'] = ["message" => "Error changing password", 'color' => "danger"];
    } else {
        $mail = makeMail("Your Password Has Been Reset." . $password, "http://localhost/signin.php", "Login Now", null, "(Get back to your account.)");
        sendMail($user_email, "Account Password Reset Online Appetite", $mail);
        $_SESSION['message'] = ["message" => "Password changed successfully", 'color' => "success"];
        query("DELETE FROM RESET_PASSWORD WHERE EMAIL = '$email'");
    }
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
