<?php
require_once '../utils/sessionManager.php';
unset($_SESSION['admin']);
header('Location: /admin/login.php');
?>