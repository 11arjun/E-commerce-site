<?php
require_once '../utils/sessionManager.php';
require_once '../utils/database.php';
if(!isset($_SESSION['trader']))
{
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
    $page = "Dashboard";
    include 'header.php';

    $trader_id = $_SESSION['trader']['USER_ID'];

    $total_products = fetch_row("SELECT COUNT(*) AS C FROM PRODUCTS WHERE TRADER_ID = '$trader_id'")['C'];
    $total_shops = fetch_row("SELECT COUNT(*) AS C FROM SHOPS WHERE TRADER_ID = '$trader_id'")['C'];
    $pending_orders = fetch_row("SELECT COUNT(*) AS C FROM ORDER_PRODUCT INNER JOIN ORDERS USING (ORDER_ID) INNER JOIN PRODUCTS USING (PRODUCT_ID) WHERE TRADER_ID = '$trader_id' AND ORDERS.STATUS = 2 AND ORDER_PRODUCT.STATUS = 1")['C'];
    $completed_orders = fetch_row("SELECT COUNT(*) AS C FROM ORDER_PRODUCT INNER JOIN PRODUCTS USING (PRODUCT_ID) WHERE TRADER_ID = '$trader_id' AND STATUS = 2")['C'];
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
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Statistics</h5>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-gifts"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">My Products</span>
                  <span class="info-box-number"><?= $total_products ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-store-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">My Shops</span>
                  <span class="info-box-number"><?= $total_shops ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-shopping-basket"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Pending Orders</span>
                  <span class="info-box-number"><?= $pending_orders ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Completed Orders</span>
                  <span class="info-box-number"><?= $completed_orders ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
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