<?php
$orderID = $_GET['OrderID']??'';
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

    <title>Payment Cancelled</title>
    <style>
        .cancelled-content {
            height: calc(100vh - 115px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;
        }
    </style>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="cancelled-content px-5">
        <h1>Cancelled</h1>
        <p>Your payment has been cancelled. Would you like to <a href="/checkout.php">begin the process again?</a></p>
        <button class="btn btn-warning" onclick="window.location.href='/checkout.php'">Begin the process again?</button>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/adminlte/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </script>
</body>

</html>