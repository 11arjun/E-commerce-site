<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
    exit();
} else {
    $user_id = $_SESSION['user']['USER_ID'];
}

$review_id = $_GET['id'];
$user_review = fetch_row("SELECT * FROM REVIEWS WHERE REVIEW_ID = '$review_id' AND USER_ID = '$user_id'");
if (!empty($user_review)) {
    $sql = "DELETE FROM REVIEWS WHERE REVIEW_ID = '$review_id'";
}
query($sql);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
