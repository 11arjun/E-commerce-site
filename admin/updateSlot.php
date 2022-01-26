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

//shop name
if (empty($slotName)) {
    $errors['slotName'] = "Slot Name is required.";
} elseif (strlen($slotName) < 3) {
    $errors['slotName'] = "Slot Name must be atleast 3 characters long.";
}


//error size
if (sizeof($errors) == 0) {
    $sql = "UPDATE SLOTS SET SLOT_TIME = '$slotName' WHERE SLOT_ID = '$slotID'";

    $res = query($sql);
    if (!$res)
        $_SESSION['message'] = ["message" => "Error while inserting Slot", 'color' => "danger"];
    else
        $_SESSION['message'] = ["message" => "Slot added Successfully!", 'color' => "success"];
} else {
    $_SESSION['message'] = ["message" => "Please fix the following errors", 'color' => "danger"];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}
header('Location:/admin/editSlot.php?id='.$slotID);
