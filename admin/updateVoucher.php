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

//voucher code
if (!empty($voucherCode)) {
    if (strlen($voucherCode) < 3) {
        $errors['voucherCode'] = "Voucher Code must be atleast 3 characters long.";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $voucherCode)) {
        $errors['voucherCode'] = "Voucher code can only be alphanumeric";
    } elseif (!checkCodeUnique($voucherCode)) {
        $errors['voucherCode'] = "Voucher code already exists";
    }
}
//amount.
if (empty($amount)) {
    $errors['amount'] = "Discount amount is required.";
} else if (!is_numeric($amount)) {
    $errors['amount'] = "Discount amount must be numeric.";
}
//minimum
if (empty($minimum)) {
    $errors['minimum'] = "Minimum Amount is required.";
} else if (!is_numeric($minimum)) {
    $errors['amount'] = "Minimum amount must be numeric.";
}


//error size
if (sizeof($errors) == 0) {
    $sql = "UPDATE VOUCHERS SET";
    if (!empty($voucherCode))
        $sql .= " VOUCHER_CODE = '$voucherCode',";
    $sql .= " DISCOUNT_AMOUNT = '$amount'*100, MINIMUM = '$minimum'*100 WHERE VOUCHER_ID = '$voucherID'";
    $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while updating Voucher", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Voucher updated Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}

function checkCodeUnique($code)
{
    $row = fetch_row("SELECT COUNT(*) as C FROM VOUCHERS WHERE VOUCHER_CODE = '$code'");
    $count = $row['C'];
    if ($count > 0) return false;
    return true;
}
header('Location:/admin/editVoucher.php?id=' . $voucherID);
