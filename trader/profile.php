<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['trader'])) {
  header('Location: /trader/login.php');
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
    $user_id = $_SESSION['trader']['USER_ID'];
    $user = fetch_row("SELECT * FROM USERS LEFT JOIN TRADERS on USERS.USER_ID = TRADERS.USER_ID WHERE USERS.USER_ID ='$user_id'");
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
              <div class="mt-4">
                <strong>Registered on: </strong>
                <span><?= date('jS M Y', strtotime($user['CREATED_AT'])) ?></span>
              </div>
              <div class="mt-1">
                <strong>Account status: </strong>
                <?php
                switch ($user['STATUS']) {
                  case 1:
                    echo '<b class="text-warning">Pending</b>';
                    break;
                  case 2:
                    echo '<b class="text-success">Active</b>';
                    break;
                  case 3:
                    echo '<b class="text-danger">Suspended</b>';
                    break;
                }
                ?>
              </div>
            </div>
            <div class="col-md-8 offset-md-1 col-sm-6 col-12">
              <div class="row">
                <div class="col-6">
                  <i>Business Name</i>
                  <p><?= $user['FULL_NAME'] ?></p>
                  <i>Gender</i>
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
                  <i>Street Address</i><br>
                  <p><?= $user['STREET']; ?></p>
                  <i>City</i><br>
                  <p><?= $user['CITY']; ?></p>
                  <i>Postal Code</i><br>
                  <p><?= $user['POSTAL']; ?></p>
                  <i>Business type</i><br>
                  <p><?= $user['BUSINESS_TYPE']; ?></p>
                </div>
                <div class="col-6">
                  <i>Business Email</i>
                  <p><?= $user['EMAIL'] ?></p>
                  <i>Contact No.</i>
                  <p><?= $user['CONTACT_NO'] ?></p>
                  <i>State/Province</i><br>
                  <p><?= $user['STATE']; ?></p>
                  <i>Country</i><br>
                  <p><?= $user['COUNTRY']; ?></p>
                  <i>Trading Since</i><br>
                  <p><?= $user['TRADING_SINCE']; ?></p>
                  <i>Preferred Payments</i><br>
                  <p><?= $user['PREFERRED_PAYMENTS']; ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <a href="/trader/editprofile.php"><button class="btn btn-secondary mb-2">Edit Profile</button></a>
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