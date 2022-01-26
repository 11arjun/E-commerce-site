<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/utils.php';
require_once '../utils/mail.php';
require_once '../mailTemplate.php';
$old = $_POST;
$data = sanitize_array($_POST);
extract($data);
$errors = [];
if (empty($name)) {
    $errors['name'] = "Full name is required.";
} elseif (strlen($name) < 3) {
    $errors['name'] = "Fullname must be atleast 3 characters long.";
} elseif (!preg_match('/^[a-zA-Z]+ [a-zA-Z ]+$/', $name)) {
    $errors['name'] = "Please enter a valid Name";
}
if (empty($username)) {
    $errors['username'] = "Username is required.";
} elseif (strlen($username) < 6) {
    $errors['username'] = "Username must be atleast 6 characters long.";
} elseif (!preg_match('/^[a-zA-Z0-9_\.]*$/', $username)) {
    $errors['username'] = "Please enter a valid Username";
} elseif (!checkUsernameUnique($username)) {
    $errors['username'] = "This Username has already been taken.";
}
if (empty($email)) {
    $errors['email'] = "Email is required.";
} elseif (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
    $errors['email'] = "Please enter a valid email";
} elseif (!checkEmailUnique($email)) {
    $errors['email'] = "This Email already exists.";
}
if (empty($password)) {
    $errors['password'] = "Password is required.";
} elseif (strlen($password) < 8) {
    $errors['password'] = "Password must be atleast 8 characters long.";
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', $password)) {
    $errors['password'] = "Include atleast one Uppercase, Number and Special character";
} elseif ($password != $confirm) {
    $errors['password'] = "Password Confirmation does not match.";
}
if (empty($toc)) {
    $errors['toc'] = "You must agree to the Terms and Conditions";
}
if (sizeof($errors) == 0) {
    $password = md5($password);
    $sql1 = "INSERT INTO USERS
    (FULL_NAME, USERNAME, EMAIL, STREET, CITY, STATE, POSTAL, COUNTRY, GENDER, PASSWORD_HASH)
     VALUES 
     ('$name', '$username', '$email', '$street', '$city', '$state', '$postal', '$country', '$gender', '$password')";
    $res1 = query($sql1);
    $user_id = fetch_row("SELECT USER_ID FROM USERS WHERE USERNAME = '$username'")['USER_ID'];
    $sql2 = "INSERT INTO CUSTOMERS (USER_ID) VALUES ('$user_id')";
    if (!$res1)
        $_SESSION['message'] = ["message" => "Error while user registeration", 'color' => "danger"];
    elseif (!query($sql2))
        $_SESSION['message'] = ["message" => "Error while customer registeration", 'color' => "danger"];
    else {
        $token = md5(RAND(4000, 5000));
        $useremail = $email;
        if (!empty(fetch_row("SELECT * FROM VERIFY_EMAIL WHERE EMAIL = '$useremail'")))
            query("UPDATE VERIFY_EMAIL SET TOKEN = '$token', CREATED_AT = " . toTime(date('Y/m/d H:i:s')) . " WHERE EMAIL = '$useremail'");
        else
            query("INSERT INTO VERIFY_EMAIL (EMAIL, TOKEN, CREATED_AT) VALUES ('$useremail', '$token', " . toTime(date('Y/m/d H:i:s')) . ")");
        $message = "We're glad you're here,<br>" . $useremail;
        $link = "http://localhost/verifyUserEmail.php?email=$useremail&token=$token";
        $mail = makeMail($message, $link, "Activate Account", null, "(Just confirming you're you.)");
        sendMail($useremail, "Verify your OnlineAppetite Account", $mail);
        $_SESSION['message'] = ["message" => "You have registered Successfully! Redirecting...", 'color' => "success"];
    }
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/signup.php');
function checkUsernameUnique($username)
{
    $row = fetch_row("SELECT COUNT(*) as C FROM USERS WHERE USERNAME = '$username'");
    $count = $row['C'];
    if ($count > 0) return false;
    return true;
}

function checkEmailUnique($email)
{
    $row = fetch_row("SELECT COUNT(*) as C FROM USERS WHERE EMAIL = '$email'");
    $count = $row['C'];
    if ($count > 0) return false;
    return true;
}
