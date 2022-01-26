<?php
require_once 'utils/sessionManager.php';
if(isset($_SESSION['user'])){
    header('Location: /');
}else {
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        $old = $_SESSION['old'];
        unset($_SESSION['old']);
    }
}
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
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/Login-Form.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $page = "signin";
    include 'header.php';
    ?>
    <section class="login-clean">
        <form method="POST" action="backend/loginUser.php">
            <h1 class="text-center" style="margin: 30px;margin-top: -2px; color: black;">Login</h1>
            <div class="mb-3">
                <input class="form-control <?= isset($errors['login']) ? 'is-invalid' : ''; ?>" type="text" name="login" placeholder="Username/Email" value="<?= $old['login'] ?? ''; ?>">
                <?= isset($errors['login']) ? '<span class="invalid-feedback">' . $errors['login'] . '</span>' : ''; ?>
            </div>
            <div class="mb-3">
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" type="password" name="password" placeholder="Password">
                <?= isset($errors['password']) ? '<span class="invalid-feedback">' . $errors['password'] . '</span>' : ''; ?>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit">Log In</button>
            </div>
            <a class="forgot" href="forgotpassword.php" style="font-size: 17px;color: #fb7925;">Forgot password?</a><br>
            <a class="text-center d-block" href="toc.php">Terms and condition</a>
        </form>
    </section>
    <?php include 'footer.php' ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>