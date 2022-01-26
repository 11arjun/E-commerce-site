<?php
require_once 'utils/sessionManager.php';
if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $message = $_SESSION['message'] ?? [];
    unset($_SESSION['message']);
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
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
    <title>Forgot Password</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <section class="login-clean">
        <form method="POST" onsubmit="formSubmit(this)" action="sendResetLink.php" style="background: #c5c3c3;">
            <?php if (!empty($message)) { ?>
                <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                    <?= $message['message']; ?>
                </div>
            <?php } ?>
            <h4 class="text-center" style="font-size:23px; margin: 30px;margin-top: -2px; color: black;">Forgot Password</h4>
            <div class="mb-3"><input class="form-control" id="username" type="text" name="username" placeholder="Username" value="<?= $old['username'] ?? '' ?>"></div>
            <div class="mb-3"><input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?= $old['email'] ?? '' ?>"></div>
            <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Send Reset Link</button></div>
        </form>
    </section>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    function formSubmit(form) {
        form.querySelector('button').disabled = true;
        form.querySelector('').readOnly = true;
        form.querySelector('button').readOnly = true;
    }
    </script>
</body>

</html>