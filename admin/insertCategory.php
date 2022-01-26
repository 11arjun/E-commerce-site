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

//category name
if (empty($categoryName)) {
    $errors['categoryName'] = "Category Name is required.";
} else if (strlen($categoryName) < 3) {
    $errors['categoryName'] = "Category Name must be atleast 3 characters long.";
} else if (!preg_match('/^[a-zA-Z ]+$/', $categoryName)) {
    $errors['categoryName'] = "Please enter a valid Category name.";
}
//description
if (empty($description)) {
    $errors['description'] = "Description is required.";
} else if (strlen($description) < 20) {
    $errors['description'] = "Description must be atleast 20 characters long.";
}
//image
if (file_exists($_FILES['categoryImage']["tmp_name"])) {

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES['categoryImage']["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors['categoryImage'] = "Upload valid images. Only PNG and JPEG are allowed.";
    }    // Validate image file size
    else {
        $fileinfo = getimagesize($_FILES['categoryImage']["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];

        if (($_FILES['categoryImage']["size"] > 2000000)) {
            $errors['categoryImage'] = "Image size exceeds 2MB.";
        }    // Validate image file dimension
        else if ($width > "1200" || $height > "1200") {
            $errors['categoryImage'] = "Image dimension should be within 1200X1200.";
        }
    }
} else {
    $errors['categoryImage'] = "Category Image is required.";
}



//error size
if (sizeof($errors) == 0) {
    $filename = uniqid('Category_');
    $target = "../uploads/categories/" . $filename . '.' . $file_extension;
    if (move_uploaded_file($_FILES['categoryImage']["tmp_name"], $target)) {
        $categoryImage = '/uploads/categories/' . $filename . '.' . $file_extension;
    } else {
        $errors['categoryImage'] = "Problem in uploading image files.";
    }
}

//error size
if (sizeof($errors) == 0) {
    $sql = "INSERT INTO CATEGORIES (CATEGORY_NAME, DESCRIPTION, IMAGE) VALUES ('$categoryName', '$description', '$categoryImage')";
    $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while inserting Category", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Category added Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/admin/addCategory.php');
