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
  if (isset($_GET['id'])) {
    $slot_id = $_GET['id'];
  } else {
    header('Location: ../404.php');
    exit();
  }
}
$fetch = fetch_row("SELECT * FROM SLOTS WHERE SLOT_ID = '$slot_id'");
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
    $page = "ViewSlots";
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
                <li class="breadcrumb-item">Slots</li>
                <li class="breadcrumb-item active">Edit Slot</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Edit Slot</h5>

          <form class="addForm" action="updateSlot.php" method="POST">
            <input type="hidden" name="slotID" value="<?= $slot_id ?>">
            <?php if (isset($message)) { ?>
              <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                <?= $message['message']; ?>
              </div>
            <?php } ?>
            <!--Slot name-->
            <div class="form-group">
              <label for="slotName">Slot Name</label>
              <input type="text" id="slotName" name="slotName" class="form-control <?= isset($errors['slotName']) ? 'is-invalid' : ''; ?>" value="<?= $old['slotName'] ?? $fetch['SLOT_TIME']; ?>">
              <?= isset($errors['slotName']) ? '<div class="invalid-feedback">' . $errors['slotName'] . '</div>' : ''; ?>
            </div>
            <!--submit button-->
            <button type="submit" class="btn btn-outline-secondary mb-3">Edit Slot</button>
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
  <script>
  </script>
</body>

</html>