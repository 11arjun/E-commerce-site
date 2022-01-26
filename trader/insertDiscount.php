<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/utils.php';
if (!isset($_SESSION['trader'])) {
    header('Location: /trader/login.php');
  }
$old = $_POST;
$data = sanitize_array($_POST);
extract($data);
$errors = [];

$user_id = $_SESSION['trader']['USER_ID'];

//discount name
if (empty($discountName)) {
    $errors['discountName'] = "Discount Name is required.";
} elseif (strlen($discountName) < 3) {
    $errors['discountName'] = "Discount Name must be atleast 3 characters long.";
}
//rate.
if (empty($rate)) {
    $errors['rate'] = "Discount rate is required.";
} else if (!is_numeric($rate)) {
    $errors['rate'] = "Discount rate must be numeric.";
}
//target
if ($discount_type == "category" && empty($target)) {
    $errors['target'] = "Target is required.";
}
//starts on
if (empty($starts)) {
    $errors['starts'] = "Start Date is required.";
}
//expires on
if (empty($expires)) {
    $errors['expires'] = "Expiry Date is required.";
}



//error size
if (sizeof($errors) == 0) {
    $sql = "INSERT INTO DISCOUNTS (DISCOUNT_NAME, RATE, TARGET_ID, DISCOUNT_TYPE, STARTS_ON, EXPIRES_ON, CREATED_BY) VALUES ('$discountName', '$rate', '$target', 'product', ".toDate($starts, "YYYY-MM-DD").", ".toDate($expires, "YYYY-MM-DD").", $user_id)";
    $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while inserting Discount", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Discount added Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/trader/addDiscount.php');
