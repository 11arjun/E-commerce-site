<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $user_id = $_SESSION['user']['USER_ID'];
}
$old = $_POST;
extract($_POST);
$errors = [];
$user = fetch_row("SELECT PASSWORD_HASH FROM USERS WHERE USER_ID = '$user_id'");
if(empty($oldpass)) {
    $errors['oldpass'] = "Old password is required.";
}
elseif (md5($oldpass) != $user['PASSWORD_HASH']){
    $errors['oldpass'] = "Old password does not match.";
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
if(sizeof($errors) == 0){
    $password = md5($password);
    $sql = "UPDATE USERS SET PASSWORD_HASH = '$password' WHERE USER_ID = '$user_id'";
    if(!query($sql)){
        $_SESSION['message'] = ["message" => "Error changing password", 'color' => "danger"];
    }
    else {
        $_SESSION['message'] = ["message" => "Password changed successfully", 'color' => "success"];
    }
}else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/changePassword.php');
