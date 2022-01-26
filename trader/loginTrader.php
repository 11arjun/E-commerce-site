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
    header('Location: /trader/login.php');
} else {
    $sql = "SELECT USER_ID, FULL_NAME, USERNAME, EMAIL, PASSWORD_HASH, IMAGE, STATUS FROM USERS INNER JOIN TRADERS USING(USER_ID) WHERE (USERNAME='$login' OR EMAIL ='$login') AND USER_ROLE='2'";
    $user = fetch_row($sql);
    if (!$user) {
        $errors['login'] = "Username/Email does not exists.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /trader/login.php');
    } else if (md5($password) != $user['PASSWORD_HASH']) {
        $errors['password'] = "Password Does not match.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /trader/login.php');
    } else if ($user['STATUS'] == 1) {
        $errors['login'] = "Account not verified. Contact Administrator.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /trader/login.php');
    } else if ($user['STATUS'] == 3) {
        $errors['login'] = "Account suspended. Contact Administrator.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header('Location: /trader/login.php');
    } else {
        unset($user['PASSWORD_HASH']);
        $_SESSION['trader'] = $user;
        header('Location: /trader');
    }
}
