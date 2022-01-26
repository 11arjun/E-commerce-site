<?php
require_once '../utils/sessionManager.php';
if (!isset($_SESSION['trader'])) {
  header('Location: /trader/login.php');
}else {
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
  }
  if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $old = $_SESSION['old'];
    unset($_SESSION['errors']);
    unset($_SESSION['old']);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
  <link rel="stylesheet" href="/css/select2/select2.min.css">
  <style>
    @media only screen and (min-width: 992px) {
      .addForm {
        width: 500px;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/assets/images/logoSmall.png" alt="DFOS" height="60" width="60">
    </div>
    <?php
    $page = "profile";
    include 'header.php';
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Profile</li>
                <li class="breadcrumb-item active">Change Password</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Change Password</h5>
          <form class="addForm" action="updatePassword.php" method="POST">
          <?php if (isset($message)) { ?>
            <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
              <?= $message['message']; ?>
            </div>
          <?php } ?>
            <!--shop name-->
            <div class="form-group">
              <label for="oldpass">Old Password</label>
              <input type="password" id="oldpass" name="oldpass" class="form-control <?= isset($errors['oldpass']) ? 'is-invalid' : ''; ?>">
              <?= isset($errors['oldpass']) ? '<div class="invalid-feedback">' . $errors['oldpass'] . '</div>' : ''; ?> 
            </div>

              <!--shop name-->
              <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" id="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>">
              <?= isset($errors['password']) ? '<div class="invalid-feedback">' . $errors['password'] . '</div>' : ''; ?> 
            </div>

              <!--shop name-->
              <div class="form-group">
              <label for="confirm">Confirm New Password</label>
              <input type="password" id="confirm" name="confirm" class="form-control <?= isset($errors['confirm']) ? 'is-invalid' : ''; ?>">
              <?= isset($errors['confirm']) ? '<div class="invalid-feedback">' . $errors['confirm'] . '</div>' : ''; ?> 
            </div>

           
            
            <!--submit button-->
            <button type="submit" class="btn btn-outline-secondary mb-3">Change Password</button>
          </form>

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'footer.php'; ?>
  </div>
  <!-- ./wrapper -->


  <!-- jQuery -->
  <script src="/js/adminlte/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/js/adminlte/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/js/adminlte/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/js/adminlte/demo.js"></script>
  <!-- Select2 -->
  <script src="/js/select2/select2.full.min.js"></script>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
  </script>
</body>

</html>