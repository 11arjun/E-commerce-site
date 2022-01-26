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
  <!-- DataTables -->
  <link rel="stylesheet" href="/css/datatables-bs4/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/css/datatables-responsive/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/css/datatables-buttons/buttons.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
  <style>
    .image-preview {
      position: relative;
      width: 50px;
      height: 50px;
    }

    .image-preview .abs-image {
      position: absolute;
      top: 0%;
      left: 0%;
      max-width: 50px;
      max-height: 50px;
      transition: transform 250ms ease-in;
    }

    .image-preview .abs-image:hover {
      transform: scale(400%);
      z-index: 10;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/assets/images/logoSmall.png" alt="DFOS" height="60" width="60">
    </div>
    <?php
    $page = "Products";
    include 'header.php';
    $products = fetch_all_row('SELECT PRODUCTS.*, CATEGORY_NAME FROM PRODUCTS INNER JOIN CATEGORIES ON PRODUCTS.CATEGORY_ID = CATEGORIES.CATEGORY_ID');
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
                <li class="breadcrumb-item active">Products</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Products</h5>
          <table id="shopTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Confirmed on</th>
                <th class="no-sort">Confirm</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Shop ID</th>
                <th class="no-sort">Image</th>
                <th class="no-sort no-search">View</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) { ?>
                <tr>
                  <td><?= $product['PRODUCT_ID'] ?></td>
                  <td><?= $product['PRODUCT_NAME'] ?></td>
                  <td class="text-center"><?= $product['CONFIRMED_ON'] ?? '-' ?></td>
                  <td style="text-align: center;">
                    <?php if (!isset($product['CONFIRMED_ON'])) { ?><button class="btn btn-primary m-1" onclick="window.location.replace('confirmProduct.php?id=<?= $product['PRODUCT_ID'] ?>')">Verify</button>
                    <?php } else { ?><button class="btn disabled btn-primary m-1">Verified</button><?php } ?>
                  </td>
                  <td><?= number_format((float)$product['PRICE'] / 100.0, 2, '.', '') ?></td>
                  <td><?= $product['STOCK'] ?></td>
                  <td><?= $product['CATEGORY_NAME'] ?></td>
                  <td><?= $product['SHOP_ID'] ?></td>
                  <td>
                    <div class="d-flex">
                      <div class="image-preview">
                        <img class="abs-image px-1" src="<?= $product['IMAGE1'] ?>" alt="Product Image">
                      </div>
                      <div class="image-preview">
                        <img class="abs-image px-1" src="<?= $product['IMAGE2'] ?>" alt="Product Image">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex">
                      <button class="btn btn-info m-1" onclick="window.location.href='../product.php?id=<?= $product['PRODUCT_ID'] ?>'">View</button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Confirmed on</th>
                <th>Confirm</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Shop ID</th>
                <th>Image</th>
                <th>View</th>
              </tr>
            </tfoot>
          </table>
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
  <!-- DataTables  & Plugins -->
  <script src="/js/datatables/jquery.dataTables.min.js"></script>
  <script src="/js/datatables-bs4/dataTables.bootstrap4.min.js"></script>
  <script src="/js/datatables-responsive/dataTables.responsive.min.js"></script>
  <script src="/js/datatables-responsive/responsive.bootstrap4.min.js"></script>
  <script src="/js/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="/js/datatables-buttons/buttons.bootstrap4.min.js"></script>
  <script src="/js/jszip/jszip.min.js"></script>
  <script src="/js/datatables-buttons/buttons.html5.min.js"></script>
  <script src="/js/datatables-buttons/buttons.print.min.js"></script>
  <script src="/js/datatables-buttons/buttons.colVis.min.js"></script>
  <script>
    $(function() {
      $("#shopTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "buttons": [{
          extend: "csv",
          exportOptions: {
            columns: [0, 1, 2, 4, 5, 6]
          }
        }, {
          extend: "excel",
          exportOptions: {
            columns: [0, 1, 2, 4, 5, 6]
          }
        }, {
          extend: "print",
          exportOptions: {
            columns: [0, 1, 2, 4, 5, 6]
          }
        }, "colvis"],
        "columnDefs": [{
          "targets": 'no-sort',
          "orderable": false,
        }, {
          "targets": 'no-search',
          "searchable": false,
        }]
      }).buttons().container().appendTo('#shopTable_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>