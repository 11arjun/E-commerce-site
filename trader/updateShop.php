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

$trader_id = $_SESSION['trader']['USER_ID'];
$shop = fetch_row("SELECT * FROM SHOPS WHERE SHOP_ID = '$shopID'");

if($shop['TRADER_ID']!=$trader_id){
    header('Location: ../401.php');
    exit();
}

//shop name
if (empty($shopName)) {
    $errors['shopName'] = "Shop Name is required.";  
} elseif (strlen($shopName) < 3) {
    $errors['shopName'] = "Shop Name must be atleast 3 characters long.";
} elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $shopName)) {
    $errors['shopName'] = "Please enter a valid shop name.";
}
//Pan no.
if (empty($govNum)) {
    $errors['govNum'] = "Pan no./Vat no. is required.";
} 
//address
if (empty($address)) {
    $errors['address'] = "Address is required.";
} 
//Contact number
if (empty($contact)) {
    $errors['contact'] = "Contact number is required.";
}
//Shop type
if (empty($shop_type)) {
    $errors['shop_type'] = "Shop type is required.";
}
//description
if (empty($description)) {
    $errors['description'] = "Description is required.";
}
elseif (strlen($description) < 20) {
    $errors['description'] = "Description must be atleast 20 characters long.";
}



//error size
if (sizeof($errors) == 0) {
   $sql = "UPDATE SHOPS SET TRADER_ID = '$trader_id', SHOP_NAME = '$shopName', GOV_NO = '$govNum', ADDRESS = '$address', CONTACT_NO = '$contact', SHOP_TYPE = '$shop_type', DESCRIPTION = '$description' WHERE SHOP_ID = '$shopID'";
   $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while updating Shop", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Shop updated Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/trader/editShop.php?id='.$shopID);
