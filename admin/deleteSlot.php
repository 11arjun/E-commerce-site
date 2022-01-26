<?php
include '../utils/database.php';
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
} else {
    $slot_id = $_GET['id'] ?? '';
}

query("DELETE FROM SLOTS WHERE SLOT_ID = '$slot_id'");

header('Location: viewSlots.php');