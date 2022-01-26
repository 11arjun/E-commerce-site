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
$product = fetch_row("SELECT * FROM PRODUCTS WHERE PRODUCT_ID = '$productID'");

if($product['TRADER_ID']!=$user_id){
    header('Location: ../401.php');
    exit();
}

//product name
if (empty($productName)) {
    $errors['productName'] = "Product Name is required.";
} elseif (strlen($productName) < 3) {
    $errors['productName'] = "Product Name must be atleast 3 characters long.";
}
//price
if (empty($price)) {
    $errors['price'] = "Price is required.";
} elseif (!is_numeric($price)) {
    $errors['price'] = "Price must be numeric.";
}
//category
if (empty($category)) {
    $errors['category'] = "Category is required.";
}
//quantity
if (empty($stock)) {
    $errors['stock'] = "Stock is required.";
} elseif (!is_numeric($stock)) {
    $errors['stock'] = "Please enter a valid stock.";
}
//shop
if (empty($shop)) {
    $errors['shop'] = "Shop is required.";
}
//description
if (empty($description)) {
    $errors['description'] = "Description is required.";
} elseif (strlen($description) < 20) {
    $errors['description'] = "Description must be atleast 20 characters long.";
}
//category
if (file_exists($_FILES['productImage1']["tmp_name"])) {

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES['productImage1']["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors['productImage1'] = "Upload valid images. Only PNG and JPEG are allowed.";
    }    // Validate image file size
    else {
        $fileinfo = getimagesize($_FILES['productImage1']["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];

        if (($_FILES['productImage1']["size"] > 2000000)) {
            $errors['productImage1'] = "Image size exceeds 2MB.";
        }    // Validate image file dimension
        else if ($width != $height) {
            $errors['productImage2'] = "Image should be a square image.";
        } else if ($width > "500" || $height > "500") {
            $errors['productImage1'] = "Image dimension should be within 500X500.";
        }
    }
}

if (file_exists($_FILES['productImage2']["tmp_name"])) {

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES['productImage2']["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors['productImage2'] = "Upload valid images. Only PNG and JPEG are allowed.";
    }    // Validate image file size
    else {
        $fileinfo = getimagesize($_FILES['productImage2']["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];

        if (($_FILES['productImage2']["size"] > 2000000)) {
            $errors['productImage2'] = "Image size exceeds 2MB.";
        }    // Validate image file dimension
        else if ($width != $height) {
            $errors['productImage2'] = "Image should be a square image.";
        } else if ($width > "500" || $height > "500") {
            $errors['productImage2'] = "Image dimension should be within 500X500.";
        }
    }
}

//error size
if (sizeof($errors) == 0) {
    if (file_exists($_FILES['productImage1']["tmp_name"])) {
        $filename = uniqid('ProductImage_');
        $target = "../uploads/products/" . $filename . '.' . $file_extension;
        if (move_uploaded_file($_FILES['productImage1']["tmp_name"], $target)) {
            $productImage1 = '/uploads/products/' . $filename . '.' . $file_extension;
        } else {
            $errors['productImage1'] = "Problem in uploading image files.";
        }
    }
}
if (sizeof($errors) == 0) {
    if (file_exists($_FILES['productImage2']["tmp_name"])) {
        $filename = uniqid('ProductImage_');
        $target = "../uploads/products/" . $filename . '.' . $file_extension;
        if (move_uploaded_file($_FILES['productImage2']["tmp_name"], $target)) {
            $productImage2 = '/uploads/products/' . $filename . '.' . $file_extension;
        } else {
            $errors['productImage2'] = "Problem in uploading image files.";
        }
    }
}

//error size
if (sizeof($errors) == 0) {
    $price = $price * 100;
    $sql = "UPDATE PRODUCTS SET PRODUCT_NAME = '$productName', CATEGORY_ID = '$category', PRICE = '$price', STOCK = '$stock', SHOP_ID = '$shop', DESCRIPTION = '$description'";
    if (!empty($productImage1))
        $sql .= ", IMAGE1 = '$productImage1'";
    if (!empty($productImage2))
        $sql .= ", IMAGE2 = '$productImage2'";
    $sql .= " WHERE PRODUCT_ID = '$productID'";
    $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while inserting Product", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Product added Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}

header('Location:/trader/editProduct.php?id=' . $productID);
