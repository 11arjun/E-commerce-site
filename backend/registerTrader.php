<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/utils.php';
$old = $_POST;
$data = sanitize_array($_POST);
extract($data);
$errors = [];
if (empty($name)) {
    $errors['name'] = "Business Name is required.";
} elseif (strlen($name) < 3) {
    $errors['name'] = "Business Name must be atleast 3 characters long.";
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
if (empty($number)) {
    $errors['number'] = "Contact number is required.";
} else if (strlen($number) > 15) {
    $errors['number'] = "Enter a valid contact number";
}
if (empty($type)) {
    $errors['type'] = "Business type is required.";
}
if (empty($payments)) {
    $errors['payments'] = "Preferred payments is required.";
}
if (empty($message)) {
    $errors['message'] = "Application message is required.";
}
if (empty($toc)) {
    $errors['toc'] = "You must agree to the Terms and Conditions";
}
if (sizeof($errors) == 0) {
    $password = md5($password);
    $sql1 = "INSERT INTO USERS
    (FULL_NAME, USERNAME, EMAIL, STREET, CITY, STATE, POSTAL, COUNTRY, GENDER, USER_ROLE, PASSWORD_HASH)
     VALUES 
     ('$name', '$username', '$email', '$street', '$city', '$state', '$postal', '$country', '$gender', 2, '$password')";
    $res1 = query($sql1);
    $user_id = fetch_row("SELECT USER_ID FROM USERS WHERE USERNAME = '$username'")['USER_ID'];
    $tradingSince = makeDate($month, $day, $year);
    $payments = implode(', ', $payments);
    $sql2 = "INSERT INTO TRADERS (USER_ID, CONTACT_NO, TRADING_SINCE, BUSINESS_TYPE, PREFERRED_PAYMENTS, MESSAGE)
    VALUES
    ('$user_id', '$number', " . toDate($tradingSince, 'YYYY-MM-DD') . ", '$type', '$payments', '$message')";
    if (!$res1)
        $_SESSION['message'] = ["message" => "Error while user registeration", 'color' => "danger"];
    else if (!query($sql2)){
        $_SESSION['message'] = ["message" => "Error while trader registeration", 'color' => "danger"];
    }
    else
        $_SESSION['message'] = ["message" => "Registered Successfully! Wait for verification", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/traderregister.php');
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

function makeDate($month, $day, $year)
{
    $date = $year . '-' . (strlen($month) == 1 ? '0' . $month : $month) . '-' . (strlen($day) == 1 ? '0' . $day : $day);
    return $date;
}
