<?php
require_once '../utils/sessionManager.php';
if (isset($_SESSION['admin'])) {
  header('Location: /admin/index.php');
} else {
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OnlineAppetite | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Admin</b> Login
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="loginAdmin.php" method="post">
          <?= isset($errors['login']) ? '<span class="text-danger">' . $errors['login'] . '</span>' : ''; ?>
          <div class="input-group mb-3">
            <input type="text" name="login"  class="form-control <?= isset($errors['login']) ? 'is-invalid' : ''; ?>" placeholder="Email/Username"  value="<?= $old['login'] ?? ''; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <?= isset($errors['password']) ? '<span class="text-danger">' . $errors['password'] . '</span>' : ''; ?>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="forgot-password.php">I forgot my password</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</body>

</html>