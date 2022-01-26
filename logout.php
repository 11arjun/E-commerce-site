<?php
require_once 'utils/sessionManager.php';
unset($_SESSION['user']);
header('Location: /');
?>