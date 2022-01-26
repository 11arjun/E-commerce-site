<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
    exit();
} else if (isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /');
    exit();
}
$userVerified = fetch_row("SELECT * FROM CUSTOMERS WHERE USER_ID = '" . $_SESSION['user']['USER_ID'] . "'");
if (isset($userVerified['EMAIL_VERIFIED_AT'])) {
    $_SESSION['EMAIL_VERIFIED_AT'] = $userVerified['EMAIL_VERIFIED_AT'];
    header('Location: /');
    exit();
}

$message = $_SESSION['message'] ?? [];
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Login-Form.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <section class="login-clean">
        <form action="sendVerificationEmail.php">
            <?php if (!empty($message)) { ?>
                <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                    <?= $message['message']; ?>
                </div>
            <?php } ?>
            <h1 class="text-center" style="margin: 30px;margin-top: -2px; color: black;">Verify Email</h1>
            <p>Please verify your email to continue using your email.</p>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit">Resend Email</button>
            </div>
        </form>
    </section>
    <?php include 'footer.php' ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>