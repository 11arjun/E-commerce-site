<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
require_once '../utils/utils.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $user_id = $_SESSION['user']['USER_ID'];
}

$data = sanitize_array($_POST);
extract($data);

if (!empty($rating) && !empty($review)) {
    $user_review = fetch_row("SELECT * FROM REVIEWS WHERE PRODUCT_ID = '$product_id' AND USER_ID = '$user_id'");
    if (empty($user_review)) {
        $sql = "INSERT INTO REVIEWS (USER_ID, PRODUCT_ID, RATING, REVIEW) VALUES ('$user_id', '$product_id', '$rating', '$review')";
    } else {
        $sql = "UPDATE REVIEWS SET RATING = '$rating', REVIEW = '$review' WHERE REVIEW_ID = ".$user_review['REVIEW_ID'];
    }
    query($sql);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
