<?php
require_once '../utils/sessionManager.php';
unset($_SESSION['trader']);
header('Location: /trader/login.php');
?>