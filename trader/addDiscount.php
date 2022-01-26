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
    $page = "AddDiscount";
    include 'header.php';
    $user_id = $_SESSION['trader']['USER_ID'];
    $products = fetch_all_row("SELECT PRODUCT_ID, PRODUCT_NAME FROM PRODUCTS WHERE TRADER_ID = $user_id");
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
                <li class="breadcrumb-item">Discounts</li>
                <li class="breadcrumb-item active">Add Discount</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Add Discount</h5>

          <form class="addForm" action="insertDiscount.php" method="POST">
            <?php if (isset($message)) { ?>
              <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                <?= $message['message']; ?>
              </div>
            <?php } ?>
            <!--Discount name-->
            <div class="form-group">
              <label for="discountName">Discount Name</label>
              <input type="text" id="discountName" name="discountName" class="form-control <?= isset($errors['discountName']) ? 'is-invalid' : ''; ?>" value="<?= $old['discountName'] ?? ''; ?>">
              <?= isset($errors['discountName']) ? '<div class="invalid-feedback">' . $errors['discountName'] . '</div>' : ''; ?>
            </div>
            <!--pan no.-->
            <div class="form-group">
              <label for="rate">Discount Rate</label>
              <input type="text" id="rate" name="rate" class="form-control <?= isset($errors['rate']) ? 'is-invalid' : ''; ?>" value="<?= $old['rate'] ?? ''; ?>">
              <?= isset($errors['rate']) ? '<div class="invalid-feedback">' . $errors['rate'] . '</div>' : ''; ?>
            </div>
            <!--target-->
            <div class="form-group">
              <label for="target">Target</label>
              <select class="form-control select2 select2-danger <?= isset($errors['target']) ? 'is-invalid' : ''; ?>" id="target" name="target" data-dropdown-css-class="select2-danger" style="width: 100%;">
                <option <?php echo !isset($old['target']) ? 'selected' : ''; ?> disabled>Select one</option>
                <?php
                foreach ($products as $product) {
                ?>
                  <option <?php if (isset($old['target'])) echo $old['target'] == $product['PRODUCT_ID'] ? 'selected' : ''; ?> value="<?= $product['PRODUCT_ID'] ?>"><?= $product['PRODUCT_NAME'] ?></option>
                <?php } ?>
              </select>
              <?= isset($errors['target']) ? '<div class="invalid-feedback">' . $errors['target'] . '</div>' : ''; ?>
            </div>
            <!--starts on-->
            <div class="form-group">
              <label for="starts">Starts On</label>
              <input type="date" id="starts" name="starts" class="form-control <?= isset($errors['starts']) ? 'is-invalid' : ''; ?>" value="<?= $old['starts'] ?? ''; ?>">
              <?= isset($errors['starts']) ? '<div class="invalid-feedback">' . $errors['starts'] . '</div>' : ''; ?>
            </div>
            <!--expires on-->
            <div class="form-group">
              <label for="expires">Expires On</label>
              <input type="date" id="expires" name="expires" class="form-control <?= isset($errors['expires']) ? 'is-invalid' : ''; ?>" value="<?= $old['expires'] ?? ''; ?>">
              <?= isset($errors['expires']) ? '<div class="invalid-feedback">' . $errors['expires'] . '</div>' : ''; ?>
            </div>
            <!--submit button-->
            <button type="submit" class="btn btn-outline-secondary mb-3">Add Discount</button>
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