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
    $page = "Customers";
    include 'header.php';
    $customers = fetch_all_row('SELECT * FROM USERS LEFT JOIN CUSTOMERS ON USERS.USER_ID = CUSTOMERS.USER_ID WHERE USER_ROLE = 3');
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
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Customers</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Customers</h5>
          <table id="shopTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Registered on</th>
                <th class="no-sort">Email</th>
                <th class="no-sort">Email verified at</th>
                <th>Gender</th>
                <th>Image</th>
                <th class="no-sort no-search">Reset Password</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $customer) { ?>
                <tr>
                  <td><?= $customer['USER_ID'] ?></td>
                  <td><?= $customer['FULL_NAME'] ?></td>
                  <td><?= $customer['CREATED_AT'] ?></td>
                  <td><?= $customer['EMAIL'] ?></td>
                  <td class="text-center"><?= $customer['EMAIL_VERIFIED_AT'] ?? '-' ?></td>
                  <td><?= $customer['GENDER'] ?></td>
                  <td>
                    <div class="image-preview">
                      <img class="abs-image" src="<?= $customer['IMAGE'] ?? '../assets/images/adminlte/avatar2.png' ?>" alt="User Image">
                    </div>
                  </td>
                  <td>
                    <div class="d-flex">
                      <button class="btn btn-danger m-1" onclick="resetPassword('<?= $customer['CUSTOMER_ID'] ?>', this)">Reset Password</button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Registered on</th>
                <th>Email</th>
                <th>Email verified at</th>
                <th>Gender</th>
                <th>Image</th>
                <th>Reset Password</th>
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
  <script>
    function resetPassword(user, btn) {
      $(btn).prop('disabled', true);
      $.post('resetUserPassword.php', {
          'id': user
        },
        function(data) {
          $(btn).prop('disabled', false);
          response = JSON.parse(data);
          alert(response['message']);
        });
    }
  </script>
</body>

</html>