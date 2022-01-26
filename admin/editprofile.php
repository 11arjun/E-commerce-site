  <?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['admin'])) {
  header('Location: /admin/login.php');
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
    $user['GENDER'] = $old['gender'] ?? $user['GENDER'];
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
                  <label for="name">Full Name</label>
                  <input type="text" id="name" name="full_name" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['FULL_NAME'] ?>" value="<?= $old['full_name'] ?? '' ?>">
                  <?= isset($errors['full_name']) ? '<div class="invalid-feedback">' . $errors['full_name'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['USERNAME'] ?>" value="<?= $old['username'] ?? '' ?>">
                  <?= isset($errors['username']) ? '<div class="invalid-feedback">' . $errors['username'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['EMAIL'] ?>" value="<?= $old['email'] ?? '' ?>">
                  <?= isset($errors['email']) ? '<div class="invalid-feedback">' . $errors['email'] . '</div>' : ''; ?>
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
                    <option <?= $user['GENDER'] == '4' ? 'selected' : ''; ?> value="4">Prefer Not to Specify</option>
                  </select>
                  <?= isset($errors['gender']) ? '<div class="invalid-feedback">' . $errors['gender'] . '</div>' : ''; ?>
                </div>
                <div class="row mt-2">
                  <div class="col-6">
                    <button class="btn btn-secondary mb-2" type="submit">Update</button>
                  </div>
                  <div class="col-6">
                    <button class="btn btn-secondary mb-2" onclick="event.preventDefault(); window.location.href='/admin/profile.php'">Back</button>
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