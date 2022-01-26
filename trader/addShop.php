<?php
require_once '../utils/sessionManager.php';
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
    $page = "AddShop";
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
                <li class="breadcrumb-item">Shops</li>
                <li class="breadcrumb-item active">Add Shop</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Add Shop</h5>

          <form class="addForm" action="insertShop.php" method="POST">
            <?php if (isset($message)) { ?>
              <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                <?= $message['message']; ?>
              </div>
            <?php } ?>
            <!--shop name-->
            <div class="form-group">
              <label for="shopName">Shop Name</label>
              <input type="text" id="shopName" name="shopName" class="form-control <?= isset($errors['shopName']) ? 'is-invalid' : ''; ?>" value="<?= $old['shopName'] ?? ''; ?>">
              <?= isset($errors['shopName']) ? '<div class="invalid-feedback">' . $errors['shopName'] . '</div>' : ''; ?>
            </div>
            <!--pan no.-->
            <div class="form-group">
              <label for="govNum">Pan no./Vat no.</label>
              <input type="text" id="govNum" name="govNum" class="form-control <?= isset($errors['govNum']) ? 'is-invalid' : ''; ?>" value="<?= $old['govNum'] ?? ''; ?>">
              <?= isset($errors['govNum']) ? '<div class="invalid-feedback">' . $errors['govNum'] . '</div>' : ''; ?>
            </div>
            <!--address-->
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address" class="form-control <?= isset($errors['address']) ? 'is-invalid' : ''; ?>" value="<?= $old['address'] ?? ''; ?>">
              <?= isset($errors['address']) ? '<div class="invalid-feedback">' . $errors['address'] . '</div>' : ''; ?>
            </div>
            <!--contact number-->
            <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="text" id="contact" name="contact" class="form-control <?= isset($errors['contact']) ? 'is-invalid' : ''; ?>" value="<?= $old['contact'] ?? ''; ?>">
              <?= isset($errors['contact']) ? '<div class="invalid-feedback">' . $errors['contact'] . '</div>' : ''; ?>
            </div>
            <!--Business type / no validation-->
            <div class="form-group">
              <label for="shop_type">Shop Type</label>
              <select class="form-control select2 select2-danger <?= isset($errors['shop_type']) ? 'is-invalid' : ''; ?>" id="shop_type" name="shop_type" data-dropdown-css-class="select2-danger" style="width: 100%;">
                <option <?php echo !isset($old['shop_type']) ? 'selected' : ''; ?> disabled>Select one</option>
                <option <?php if (isset($old['shop_type'])) echo $old['shop_type'] == 'small' ? 'selected' : ''; ?> value="small">Small</option>
                <option <?php if (isset($old['shop_type'])) echo $old['shop_type'] == 'medium' ? 'selected' : ''; ?> value="medium">Medium</option>
                <option <?php if (isset($old['shop_type'])) echo $old['shop_type'] == 'large' ? 'selected' : ''; ?> value="large">Large</option>
              </select>
              <?= isset($errors['shop_type']) ? '<div class="invalid-feedback">' . $errors['shop_type'] . '</div>' : ''; ?>
            </div>
            <!--description-->
            <div class="form-group">
              <label for="inputDescription">Description</label>
              <textarea id="inputDescription" name="description" rows="4" class="form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>"><?= $old['description'] ?? ''; ?></textarea>
              <?= isset($errors['description']) ? '<div class="invalid-feedback">' . $errors['description'] . '</div>' : ''; ?>

            </div>
            <!--submit button-->
            <button type="submit" class="btn btn-outline-secondary mb-3">Add Shop</button>
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