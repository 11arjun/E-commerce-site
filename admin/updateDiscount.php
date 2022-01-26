<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once '../utils/utils.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
}
$old = $_POST;
$data = sanitize_array($_POST);
extract($data);
$errors = [];

$user_id = $_SESSION['admin']['USER_ID'];

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
//discount type
if (empty($discount_type)) {
    $errors['discount_type'] = "Discount type is required.";
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
} else if ($starts > $expires) {
    $errors['expires'] = "Expiry Date cannot be before start date.";
}



//error size
if (sizeof($errors) == 0) {
    $sql = "UPDATE DISCOUNTS SET DISCOUNT_NAME = '$discountName', RATE = '$rate'";
    if ($discount_type == "category")
        $sql .= ", TARGET_ID = '$target'";
    $sql .= ", DISCOUNT_TYPE = '$discount_type', STARTS_ON = " . toDate($starts, "YYYY-MM-DD") . ", EXPIRES_ON = " . toDate($expires, "YYYY-MM-DD") . ", CREATED_BY =  '$user_id' WHERE DISCOUNT_ID = '$discountID'";
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
header('Location:/admin/editDiscount.php?id=' . $discountID);
