<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
$old = $_POST;
extract($_POST);
$errors = [];

if (empty($login)) {
    $errors['login'] = "Username/Email is required.";
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
    header('Location: /signin.php');
} else {
    $sql = "SELECT USER_ID, FULL_NAME, USERNAME, EMAIL, PASSWORD_HASH, IMAGE, EMAIL_VERIFIED_AT FROM USERS INNER JOIN CUSTOMERS USING (USER_ID) WHERE (USERNAME='$login' OR EMAIL ='$login') AND USER_ROLE='3'";
    $user = fetch_row($sql);
    if (!$user) {
        $errors['login'] = "Username/Email does not exists.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /signin.php');
    } else if (md5($password) != $user['PASSWORD_HASH']) {
        $errors['password'] = "Password Does not match.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /signin.php');
    } else {
        unset($user['PASSWORD_HASH']);
        $_SESSION['user'] = $user;
        if (!isset($user['EMAIL_VERIFIED_AT'])) {
            header('Location: /verifyEmail.php');
            exit();
        } else {
            header('Location: /');
        }
    }
}
