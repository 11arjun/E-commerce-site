<?php
require_once '../utils/sessionManager.php';
if (isset($_SESSION['admin'])) {
  header('Location: /admin');
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OnlineAppetite | Forgot Password</title>

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
      <a href="/"><b>Online</b>Appetite</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <?php if (!empty($message)) { ?>
        <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
          <?= $message['message']; ?>
        </div>
      <?php } ?>
      <div class="card-body login-card-body">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <form action="sendResetLink.php" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $old['username'] ?? '' ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $old['email'] ?? '' ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login.php">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</body>

</html>