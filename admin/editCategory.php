<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if (!isset($_SESSION['admin'])) {
  header('Location: /admin/login.php');
  exit();
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
  if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
  } else {
    header('Location: ../404.php');
    exit();
  }
}
$fetch = fetch_row("SELECT * FROM CATEGORIES WHERE CATEGORY_ID = '$category_id'");
if (!$fetch) {
  header('Location: ../404.php');
  exit();
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
    $page = "ViewCategories";
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
                <li class="breadcrumb-item">Category</li>
                <li class="breadcrumb-item active">Edit Category</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Edit Category</h5>

          <form class="addForm" action="updateCategory.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="categoryID" value="<?= $category_id ?>">
            <?php if (isset($message)) { ?>
              <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                <?= $message['message']; ?>
              </div>
            <?php } ?>
            <!--category name-->
            <div class="form-group">
              <label for="categoryName">Category Name</label>
              <input type="text" id="categoryName" name="categoryName" class="form-control <?= isset($errors['categoryName']) ? 'is-invalid' : ''; ?>" value="<?= $old['categoryName'] ?? $fetch['CATEGORY_NAME']; ?>">
              <?= isset($errors['categoryName']) ? '<div class="invalid-feedback">' . $errors['categoryName'] . '</div>' : ''; ?>
            </div>
            <!--description-->
            <div class="form-group">
              <label for="inputDescription">Description</label>
              <textarea id="inputDescription" name="description" rows="4" class="form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>"><?= $old['description'] ?? $fetch['DESCRIPTION']; ?></textarea>
              <?= isset($errors['description']) ? '<div class="invalid-feedback">' . $errors['description'] . '</div>' : ''; ?>
            </div>
            <!--category image-->
            <div class="form-group">
              <label for="categoryImage">Category Image</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="categoryImage" class="custom-file-input <?= isset($errors['categoryImage']) ? 'is-invalid' : ''; ?>" id="categoryImage">
                  <label class="custom-file-label" for="categoryImage">Choose category image</label>
                </div>
              </div>
              <?= isset($errors['categoryImage']) ? '<div class="text-danger">' . $errors['categoryImage'] . '</div>' : ''; ?>
            </div>
            <!--submit button-->
            <button type="submit" class="btn btn-outline-secondary mb-3">Edit Category</button>
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
  <!-- bs-custom-file-input -->
  <script src="/js/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- Select2 -->
  <script src="/js/select2/select2.full.min.js"></script>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
    $(function() {
      bsCustomFileInput.init();
    });
  </script>
</body>

</html>