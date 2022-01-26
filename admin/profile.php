<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['admin'])) {
  header('Location: /admin/login.php');
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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/assets/images/logoSmall.png" alt="DFOS" height="60" width="60">
    </div>
    <?php
    $page = "Profile";
    include 'header.php';
    $user_id = $_SESSION['admin']['USER_ID'];
    $user = fetch_row("SELECT * FROM USERS LEFT JOIN MANAGEMENTS ON USERS.USER_ID = MANAGEMENTS.USER_ID WHERE USERS.USER_ID ='$user_id'");
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
                <li class="breadcrumb-item active">Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Profile</h5>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="img">
                <img src="<?= $user['IMAGE'] ?? '/assets/images/adminlte/avatar2.png' ?>" alt="" class="img-circle elevation-2">
              </div>
            </div>
            <div class="col-md-8 offset-md-1 col-sm-6 col-12">
              <div class="row">
                <div class="col-6">
                  <strong>First Name</strong>
                  <p><?= $user['FULL_NAME'] ?></p>
                </div>
                <div class="col-6">
                  <strong>Email</strong>
                  <p><?= $user['EMAIL'] ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <strong>Contact No.</strong>
                  <p><?= $user['CONTACT_NO'] ?></p>
                </div>
                <div class="col-6">
                  <strong>Gender</strong>
                  <p><?php
                      switch ($user['GENDER']) {
                        case 1:
                          echo 'Male';
                          break;
                        case 2:
                          echo 'Female';
                          break;
                        case 3:
                          echo 'Other';
                          break;
                        case 4:
                          echo 'Not Specified';
                          break;
                      }
                      ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <a href="/admin/editprofile.php"><button class="btn btn-secondary mb-2">Edit Profile</button></a>
                </div>
                <div class="col-6">
                  <a href="changepassword.php"><button class="btn btn-secondary mb-2">Change Password</button></a>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
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
</body>

</html>