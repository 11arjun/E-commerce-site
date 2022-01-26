<?php
// session_set_cookie_params(['samesite' => 'None', 'secure'=> true, 'httponly'=>true]);
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
session_start();
?>