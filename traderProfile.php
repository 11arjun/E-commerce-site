<?php
require_once 'utils/database.php';
$user_id = $_GET['id'];
$user = fetch_row("SELECT * FROM USERS LEFT JOIN TRADERS on USERS.USER_ID = TRADERS.USER_ID WHERE USERS.USER_ID ='$user_id'");
if (!$user || $user['USER_ROLE'] != 2) {
    header('Location: 404.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title><?= $user['FULL_NAME'] ?></title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="container-fluid d-flex justify-content-center">
        <div class="w-75 p-5 my-5 bg-dark text-light">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="img">
                        <img src="<?= $user['IMAGE'] ?? '/assets/images/adminlte/avatar2.png' ?>" alt="" class="img-circle w-100 elevation-2">
                    </div>
                    <div class="mt-4 text-center">
                        <strong>Registered on: </strong>
                        <hr>
                        <span><?= date('jS M Y', strtotime($user['CREATED_AT'])) ?></span>
                    </div>
                </div>
                <div class="col-md-8 offset-md-1 col-sm-6 col-12">
                    <div class="row">
                        <div class="col-6">
                            <i>Business Name</i>
                            <p><?= $user['FULL_NAME'] ?></p>
                            <i>Gender</i>
                            <p><?php
                                switch ($user['GENDER']) {
                                    case 1:
                                        echo 'Male';
                                        break;
                                    case 2:
                                        echo 'Female';
                                        break;
                                    case 3:
                                        echo 'Other';
                                        break;
                                    case 4:
                                        echo 'Not Specified';
                                        break;
                                }
                                ?></p>
                            <i>Street Address</i><br>
                            <p><?= $user['STREET']; ?></p>
                            <i>City</i><br>
                            <p><?= $user['CITY']; ?></p>
                            <i>Postal Code</i><br>
                            <p><?= $user['POSTAL']; ?></p>
                            <i>Business type</i><br>
                            <p><?= $user['BUSINESS_TYPE']; ?></p>
                        </div>
                        <div class="col-6">
                            <i>Business Email</i>
                            <p><?= $user['EMAIL'] ?></p>
                            <i>Contact No.</i>
                            <p><?= $user['CONTACT_NO'] ?></p>
                            <i>State/Province</i><br>
                            <p><?= $user['STATE']; ?></p>
                            <i>Country</i><br>
                            <p><?= $user['COUNTRY']; ?></p>
                            <i>Trading Since</i><br>
                            <p><?= $user['TRADING_SINCE']; ?></p>
                            <i>Preferred Payments</i><br>
                            <p><?= $user['PREFERRED_PAYMENTS']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div><!-- /.container-fluid -->
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    </script>
</body>

</html>