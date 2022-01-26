<?php
include 'utils/database.php';
include 'utils/sessionManager.php';
$email = $_GET['email']??'';
$token = $_GET['token']??'';
$reset = fetch_row("SELECT * FROM VERIFY_EMAIL WHERE EMAIL = '$email'");
$user = fetch_row("SELECT * FROM USERS WHERE EMAIL = '$email' AND USER_ROLE = 3");
if (!empty($reset)) {
    $expires = strtotime('+1 hour', strtotime($reset['CREATED_AT']));
}
if (empty($reset)) {
    $message = ['message' => "Verify email link is invalid", 'color' => "danger"];
} else if (empty($user)) {
    $message = ['message' => "Verify email link is invalid", 'color' => "danger"];
} else if ($reset['TOKEN'] != $token) {
    $message = ['message' => "Verify email token is invalid", 'color' => "danger"];
} else if ($expires < strtotime("now")) {
    $message = ['message' => "Verify email token expired", 'color' => "danger"];
} else {
    $sql = "UPDATE CUSTOMERS SET EMAIL_VERIFIED_AT = CURRENT_TIMESTAMP WHERE USER_ID = '" . $user['USER_ID'] . "'";
    if (!query($sql)) {
        $message = ["message" => "Error updating your data", 'color' => "danger"];
    } else {
        $message = ["message" => "Email verified successfully.", 'color' => "success"];
        $_SESSION['user']['EMAIL_VERIFIED_AT'] = date("Y-m-d H:i:s");
        query("DELETE FROM VERIFY_EMAIL WHERE EMAIL = '$email'");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Login-Form.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <section class="login-clean">
        <form onsubmit="event.preventDefault()">
            <h1 class="text-center" style="margin: 30px;margin-top: -2px; color: black;">Account Activation</h1>
            <h3 class="text-center"><?= $message['message'] ?></h3>
            <div class="mb-3">
                <?php if ($message['color'] == 'success') { ?>
                    <button class="btn btn-primary d-block w-100" onclick="window.location.replace('/')">Continue Shopping</button>
                <?php } else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) { ?>
                    <button class="btn btn-primary d-block w-100" onclick="window.location.replace('sendVerificationEmail.php')">Resend Email</button>
                <?php } ?>
            </div>
        </form>
    </section>
    <?php include 'footer.php' ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>