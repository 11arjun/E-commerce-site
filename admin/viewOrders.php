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
    $page = "Orders";
    include 'header.php';
    $orders = fetch_all_row('SELECT * FROM ORDERS INNER JOIN SLOTS USING (SLOT_ID)');
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
                <li class="breadcrumb-item active">Orders</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Orders</h5>
          <table id="shopTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Slot Time</th>
                <th>Amount</th>
                <th>Voucher Code</th>
                <th>Voucher Discount</th>
                <th>Status</th>
                <th class="no-sort no-search">Print/Confirm/Cancel</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order) { ?>
                <tr>
                  <td><?= $order['ORDER_ID'] ?></td>
                  <td><?= $order['USER_ID'] ?></td>
                  <td><?= $order['ORDER_DATE'] ?></td>
                  <td><?= $order['SLOT_TIME'] ?></td>
                  <td><?= number_format($order['AMOUNT'] / 100, 2) ?></td>
                  <td><?= $order['VOUCHER_CODE'] ?? '-' ?></td>
                  <td><?= number_format($order['VOUCHER_DISCOUNT'] / 100, 2) ?></td>
                  <td><?php
                      switch ($order['STATUS']) {
                        case 1:
                          echo 'Pending';
                          break;
                        case 2:
                          echo 'Confirmed';
                          break;
                        case 3:
                          echo 'Cancelled';
                          break;
                      }
                      ?></td>
                  <td>
                    <div class="d-flex">
                      <form action="../payment/downloadInvoice.php" method="post">
                        <input type="hidden" name="order_id" value="<?= $order['ORDER_ID'] ?>">
                        <button class="btn btn-primary m-1">Print</button>
                      </form>
                      <?php if ($order['STATUS'] == 1) {
                      ?>
                        <button class="btn btn-success m-1" onclick="window.location.replace('confirmOrder.php?id=<?= $order['ORDER_ID'] ?>')">Confirm</button>
                        <button class="btn btn-danger m-1" onclick="window.location.replace('cancelOrder.php?id=<?= $order['ORDER_ID'] ?>')">Cancel</button>
                      <?php
                      } elseif ($order['STATUS'] == 2) {
                      ?>
                        <button class="btn disabled btn-success m-1">Confirmed</button>
                        <button class="btn disabled btn-secondary m-1">Cancel</button>
                      <?php
                      } else {
                      ?>
                      <button class="btn disabled btn-secondary m-1">Confirm</button>
                      <button class="btn disabled btn-danger m-1">Cancelled</button>
                      <?php
                      }
                      ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Slot Time</th>
                <th>Amount</th>
                <th>Voucher Code</th>
                <th>Voucher Discount</th>
                <th>Status</th>
                <th>Print/Confirm/Cancel</th>
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
            columns: [0, 1, 2, 3, 4]
          }
        }, {
          extend: "excel",
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        }, {
          extend: "print",
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
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