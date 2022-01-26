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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/assets/images/logoSmall.png" alt="DFOS" height="60" width="60">
    </div>
    <?php
    $page = "Shops";
    include 'header.php';
    $shops = fetch_all_row("SELECT SHOPS.*, (SELECT COUNT(*) FROM PRODUCTS WHERE PRODUCTS.SHOP_ID = SHOPS.SHOP_ID) AS TOTAL_PRODUCTS FROM SHOPS");
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
                <li class="breadcrumb-item active">Shops</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Shops</h5>
          <table id="shopTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Shop ID</th>
                <th>Shop Name</th>
                <th>Verified on</th>
                <th class="no-sort">Verify</th>
                <th class="no-sort">Pan no./Vat no.</th>
                <th>Shop Type</th>
                <th>Products</th>
                <th class="no-sort no-search">View</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($shops as $shop) { ?>
                <tr>
                  <td><?= $shop['SHOP_ID'] ?></td>
                  <td><?= $shop['SHOP_NAME'] ?></td>
                  <td class="text-center"><?= $shop['VERIFIED_ON'] ?? '-' ?></td>
                  <td style="text-align: center;">
                    <?php if (!isset($shop['VERIFIED_ON'])) { ?><button class="btn btn-primary m-1" onclick="window.location.replace('verifyShop.php?id=<?= $shop['SHOP_ID'] ?>')">Verify</button>
                    <?php } else { ?><button class="btn disabled btn-primary m-1">Verified</button><?php } ?>
                  </td>
                  <td><?= $shop['GOV_NO'] ?></td>
                  <td><?= $shop['SHOP_TYPE'] ?></td>
                  <td><?= $shop['TOTAL_PRODUCTS'] ?></td>
                  <td>
                    <div class="d-flex">
                      <button class="btn btn-info m-1" onclick="window.location.href='../shopProfile.php?id=<?= $shop['SHOP_ID'] ?>'">View</button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Shop ID</th>
                <th>Shop Name</th>
                <th>Verified on</th>
                <th>Verify</th>
                <th>Pan no./Vat no.</th>
                <th>Shop Type</th>
                <th>Products</th>
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
        "autoWidth": false,
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