<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['trader'])) {
  header('Location: /trader/login.php');
} else {
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
  <style>
    select.form-control:invalid {
      color: #aaa;
    }

    ;
  </style>
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
    $user['PAYMENTS'] = isset($old) ? $old['payments'] ?? [] : explode(', ', $user['PREFERRED_PAYMENTS']);
    $user['BUSINESS_TYPE'] = $old['business_type'] ?? $user['BUSINESS_TYPE'];
    $user['GENDER'] = $old['gender'] ?? $user['GENDER'];
    $user['COUNTRY'] = $old['country'] ?? $user['COUNTRY'];
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
                <li class="breadcrumb-item active">Edit Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Edit Profile</h5>
          <?php if (isset($message)) { ?>
            <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
              <?= $message['message']; ?>
            </div>
          <?php } ?>
          <form action="updateProfile.php" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="img">
                  <img src="<?= $user['IMAGE'] ?? '/assets/images/adminlte/avatar2.png' ?>" alt="" class="img-circle elevation-2" id="imagePreview" style="max-width: 250px;">
                </div>
                <div class="form-group mt-4">
                  <label for="profileImage">Profile Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="profileImage" class="custom-file-input  <?= isset($errors['profileImage']) ? 'is-invalid' : ''; ?>" id="profileImage">
                      <label class="custom-file-label" for="profileImage">Choose image</label>
                    </div>
                  </div>
                  <?= isset($errors['profileImage']) ? '<div class="text-danger">' . $errors['profileImage'] . '</div>' : ''; ?>
                </div>
              </div>
              <div class="col-md-8 offset-md-1 col-sm-6 col-12">
                <div class="form-group">
                  <label for="name">Business Name</label>
                  <input type="text" id="name" name="full_name" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['FULL_NAME'] ?>" value="<?= $old['full_name'] ?? '' ?>">
                  <?= isset($errors['full_name']) ? '<div class="invalid-feedback">' . $errors['full_name'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="email">Business Email</label>
                  <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['EMAIL'] ?>" value="<?= $old['email'] ?? '' ?>">
                  <?= isset($errors['email']) ? '<div class="invalid-feedback">' . $errors['email'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['USERNAME'] ?>" value="<?= $old['username'] ?? '' ?>">
                  <?= isset($errors['username']) ? '<div class="invalid-feedback">' . $errors['username'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="contact">Contact No.</label>
                  <input type="text" id="contact" name="contact_no" class="form-control <?= isset($errors['contact_no']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['CONTACT_NO'] ?>" value="<?= $old['contact_no'] ?? '' ?>">
                  <?= isset($errors['contact_no']) ? '<div class="invalid-feedback">' . $errors['contact_no'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="gender">Gender</label>
                  <select id="gender" name="gender" class="form-control <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>">
                    <option <?= $user['GENDER'] == '1' ? 'selected' : ''; ?> value="1">Male</option>
                    <option <?= $user['GENDER'] == '2' ? 'selected' : ''; ?> value="2">Female</option>
                    <option <?= $user['GENDER'] == '3' ? 'selected' : ''; ?> value="3">Others</option>
                    <option <?= $user['GENDER'] == '4' ? 'selected' : ''; ?> value="4">Prefer not to specify</option>
                  </select>
                  <?= isset($errors['gender']) ? '<div class="invalid-feedback">' . $errors['gender'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <div class="my-2">
                    <strong>Address</strong>
                    <input type="text" id="st1" name="street" class="form-control <?= isset($errors['street']) ? 'is-invalid' : ''; ?>" placeholder="Street Address" value="<?= $user['STREET'] ?>">
                    <?= isset($errors['street']) ? '<div class="invalid-feedback">' . $errors['street'] . '</div>' : ''; ?>
                  </div>
                  <div class="row my-2">
                    <div class="col-6">
                      <input type="text" id="city" name="city" class="form-control <?= isset($errors['city']) ? 'is-invalid' : ''; ?>" placeholder="City" value="<?= $user['CITY'] ?>">
                      <?= isset($errors['city']) ? '<div class="invalid-feedback">' . $errors['city'] . '</div>' : ''; ?>
                    </div>
                    <div class="col-6">
                      <input type="text" id="state" name="state" class="form-control <?= isset($errors['state']) ? 'is-invalid' : ''; ?>" placeholder="State/Province" value="<?= $user['STATE'] ?>">
                      <?= isset($errors['state']) ? '<div class="invalid-feedback">' . $errors['state'] . '</div>' : ''; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <input type="text" id="postal" name="postal" class="form-control <?= isset($errors['postal']) ? 'is-invalid' : ''; ?>" placeholder="Postal Code" value="<?= $user['POSTAL'] ?>">
                      <?= isset($errors['postal']) ? '<div class="invalid-feedback">' . $errors['postal'] . '</div>' : ''; ?>
                    </div>
                    <div class="col-6">
                      <select id="country" name="country" class="form-control <?= isset($errors['country']) ? 'is-invalid' : ''; ?>" required>
                        <option <?= $user['COUNTRY'] == 'Nepal' ? 'selected' : ''; ?> value="Nepal">Nepal</option>
                        <option <?= $user['COUNTRY'] == 'India' ? 'selected' : ''; ?> value="India">India</option>
                        <option <?= $user['COUNTRY'] == 'Bhutan' ? 'selected' : ''; ?> value="Bhutan">Bhutan</option>
                      </select>
                      <?= isset($errors['country']) ? '<div class="invalid-feedback">' . $errors['country'] . '</div>' : ''; ?>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="trading_since">Trading Since</label>
                  <input type="date" id="trading_since" name="trading_since" class="form-control <?= isset($errors['trading_since']) ? 'is-invalid' : ''; ?>" value="<?= date('Y-m-d', strtotime($user['TRADING_SINCE'])) ?>">
                  <?= isset($errors['trading_since']) ? '<div class="invalid-feedback">' . $errors['trading_since'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label>Business Type</label><br>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="small" name="business_type" value="small" <?= $user['BUSINESS_TYPE'] == 'small' ? 'checked' : ''; ?> class="custom-control-input <?= isset($errors['business_type']) ? 'is-invalid' : ''; ?>">
                    <label class="custom-control-label" for="small">Small</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="medium" name="business_type" value="medium" <?= $user['BUSINESS_TYPE'] == 'medium' ? 'checked' : ''; ?> class="custom-control-input <?= isset($errors['business_type']) ? 'is-invalid' : ''; ?>">
                    <label class="custom-control-label" for="medium">Medium</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="large" name="business_type" value="large" <?= $user['BUSINESS_TYPE'] == 'large' ? 'checked' : ''; ?> class="custom-control-input <?= isset($errors['business_type']) ? 'is-invalid' : ''; ?>">
                    <label class="custom-control-label" for="large">Large</label>
                  </div>
                  <?= isset($errors['business_type']) ? '<div class="text-danger">' . $errors['business_type'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label>Payments</label><br>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input <?= isset($errors['payments']) ? 'is-invalid' : ''; ?>" name="payments[]" value="card" <?= in_array('card', $user['PAYMENTS']) ? 'checked' : '' ?> id="card">
                    <label class="custom-control-label <?= isset($errors['payments']) ? 'is-invalid' : ''; ?>" for="card">Card</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input <?= isset($errors['payments']) ? 'is-invalid' : ''; ?>" name="payments[]" value="cash" <?= in_array('cash', $user['PAYMENTS']) ? 'checked' : '' ?> id="cash">
                    <label class="custom-control-label <?= isset($errors['payments']) ? 'is-invalid' : ''; ?>" for="cash">Cash</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input <?= isset($errors['payments']) ? 'is-invalid' : ''; ?>" name="payments[]" value="paypal" <?= in_array('paypal', $user['PAYMENTS']) ? 'checked' : '' ?> id="paypal">
                    <label class="custom-control-label" for="paypal">Paypal</label>
                  </div>
                  <?= isset($errors['payments']) ? '<div class="text-danger">' . $errors['payments'] . '</div>' : ''; ?>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-secondary mb-2" type="submit">Update</button>
                  </div>
                  <div class="col-6">
                    <button class="btn btn-secondary mb-2" onclick="event.preventDefault(); window.location.href='/trader/profile.php'">Back</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
  <!-- bs-custom-file-input -->
  <script src="/js/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/js/adminlte/demo.js"></script>
  <script>
    $(function() {
      bsCustomFileInput.init();
    });
    document.getElementById('profileImage').onchange = evt => {
      const [file] = document.getElementById('profileImage').files
      if (file) {
        document.getElementById('imagePreview').src = URL.createObjectURL(file)
      }
    }
  </script>
</body>

</html>