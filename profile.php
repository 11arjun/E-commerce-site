<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
if (!isset($_SESSION['user'])) {
  header('Location: /signin.php');
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
  header('Location: /verifyEmail.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">

  <title>Profile</title>
</head>

<body>
  <?php
  $page = 'profile';
  include 'header.php';
  $user_id = $_SESSION['user']['USER_ID'];
  $user = fetch_row("SELECT * FROM USERS WHERE USER_ID ='$user_id'");
  ?>
  <div class="container-fluid d-flex justify-content-center">
    <div class="w-75 p-5 my-5 bg-dark text-light">
      <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
          <div class="img">
            <img src="<?= $user['IMAGE'] ?? '/assets/images/adminlte/avatar2.png' ?>" alt="" class="img-circle elevation-2">
          </div>
          <div class="mt-4 text-center">
            <strong>Registered on: </strong>
            <hr>
            <span><?= date('jS M Y', strtotime($user['CREATED_AT'])) ?></span>
          </div>
        </div>
        <div class="col-md-7 offset-md-1 col-sm-6 col-12">
          <div class="row">
            <div class="col-12">
              <strong>Full Name</strong>
              <p><?= $user['FULL_NAME'] ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <strong>Email</strong>
              <p><?= $user['EMAIL'] ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
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
              <strong>Address</strong><br>
              <i>Street Address</i><br>
              <p><?= $user['STREET']; ?></p>
              <i>City</i><br>
              <p><?= $user['CITY']; ?></p>
              <i>Postal Code</i><br>
              <p><?= $user['POSTAL']; ?></p>
            </div>
            <div class="col-6">
              <br>
              <i>State/Province</i><br>
              <p><?= $user['STATE']; ?></p>
              <i>Country</i><br>
              <p><?= $user['COUNTRY']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <a href="/editprofile.php"><button class="btn btn-secondary mb-2">Edit Profile</button></a>
            </div>
            <div class="col-6">
              <a href="changePassword.php"><button class="btn btn-secondary mb-2">Change Password</button></a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->

  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>
</body>

</html>