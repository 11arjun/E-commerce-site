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
    $page = "Payments";
    include 'header.php';
    $payments = fetch_all_row('SELECT * FROM PAYMENTS');
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
                <li class="breadcrumb-item active">Payments</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Payments</h5>
          <table id="shopTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Invoice ID</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Txn ID</th>
                <th>Payment Fee</th>
                <th class="text-center no-sort no-searching">Print</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payments as $payment) { ?>
                <tr>
                  <td><?= $payment['PAYMENT_ID'] ?></td>
                  <td><?= $payment['ORDER_ID'] ?></td>
                  <td><?= number_format($payment['AMOUNT'] / 100, 2) ?></td>
                  <td><?= ucwords($payment['PAYMENT_METHOD']) ?></td>
                  <td><?= $payment['PAYMENT_DATE'] ?></td>
                  <td><?= $payment['TXN_ID'] ?? '-' ?></td>
                  <td><?= number_format($payment['PAYMENT_FEE'] / 100, 2) ?></td>
                  <td>
                    <div class="d-flex">
                      <form action="../payment/downloadInvoice.php" method="post">
                        <input type="hidden" name="order_id" value="<?= $payment['ORDER_ID'] ?>">
                        <button class="btn btn-success m-1">Print</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Invoice ID</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Txn ID</th>
                <th>Payment Fee</th>
                <th>Print</th>
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
            columns: [0, 1, 2, 3, 4, 5]
          }
        }, {
          extend: "excel",
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          }
        }, {
          extend: "print",
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
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