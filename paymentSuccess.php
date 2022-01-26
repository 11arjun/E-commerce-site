<?php
$orderID = $_GET['OrderID'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Payment Success</title>
    <style>
        .success-content {
            height: calc(100vh - 115px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .response-text {
            display: inline-block;
            max-width: 550px;
            margin: 0 auto;
            font-size: 1.5em;
            text-align: center;
            background: #fff3de;
            padding: 42px;
            border-radius: 3px;
            border: #f5e9d4 1px solid;
            font-family: arial;
            line-height: 34px;
        }

        .download {
            background-color: wheat;
            border: none;
            width: 200px;
            box-shadow: 2px 2px 5px #333;
            padding: 10px;
            cursor: pointer;
        }

        .download:active {
            box-shadow: 0 2px 3px #222;
        }
    </style>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="success-content">
        <div class="response-text">
            You have placed your order successfully.<br> Thank you for
            shopping with us!
        </div>
        <button class="loadmore" onclick="window.location.href='/'">Go back to shopping</button>
        <form action="payment/downloadInvoice.php" target="_blank" method="POST">
            <input type="hidden" name="order_id" value="<?= $orderID ?>">
            <button class="download">Download Invoice</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/adminlte/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </script>
</body>

</html>