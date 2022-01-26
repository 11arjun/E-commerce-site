<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
$email = $_GET['email'];
$token = $_GET['token'];
$reset = fetch_row("SELECT * FROM RESET_PASSWORD WHERE EMAIL = '$email'");
$user = fetch_row("SELECT * FROM USERS WHERE EMAIL = '$email' AND USER_ROLE = 3");
if (!empty($reset)) {
    $expires = strtotime('+1 hour', strtotime($reset['CREATED_AT']));
  }
if (empty($reset)) {
    $message = ['message' => "Reset link is invalid", 'color' => "danger"];
} else if (empty($user)) {
    $message = ['message' => "Reset link is invalid", 'color' => "danger"];
} elseif ($reset['TOKEN'] != $token) {
    $message = ['message' => "Reset token is invalid", 'color' => "danger"];
} else if ($expires < strtotime("now")) {
    $message = ['message' => "Reset token expired", 'color' => "danger"];
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Login-Form.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Reset Password</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <section class="login-clean">
        <form method="post" action="updateResetPassword.php" style="background: #c5c3c3;">
            <?php if (!empty($message)) { ?>
                <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                    <?= $message['message']; ?>
                </div>
            <?php } ?>
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="token" value="<?= $token ?>">
            <h4 class="text-center" style="font-size:22px; margin: 30px;margin-top: -2px; color: black;">Change Password</h4>
            <div class="mb-3">
                <input class="form-control<?= isset($errors['password']) ? ' is-invalid' : '' ?>" type="password" name="password" placeholder="New Password">
                <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>
            </div>
            <div class="mb-3">
                <input class="form-control<?= isset($errors['confirm']) ? ' is-invalid' : '' ?>" type="password" name="confirm" placeholder="Confirm New Password">
                <div class="invalid-feedback"><?= $errors['confirm'] ?? '' ?></div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit">Change Password</button>
            </div>
        </form>
    </section>
    <?php include 'footer.php' ?>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>