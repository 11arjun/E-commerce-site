<?php
require_once 'utils/sessionManager.php';

$message = $_SESSION['message'] ?? [];
unset($_SESSION['message']);
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/customercare.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <title>Customer Care</title>
</head>

<body>
    <?php
    $page = 'customerCare';
    include 'header.php';
    ?>
    <div class="container-fluid py-2">
        <h2 class="text"> How May We Help You</h2>
        <P class="text" style> Please Convey Us Your Message, Thank You!
    </div>
    <div class="container py-4">
        <form class="contact-form" method="POST" action="sendContact.php">
            <?php if (!empty($message)) { ?>
                <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                    <?= $message['message']; ?>
                </div>
            <?php } ?>
            <div class="form-group my-2">
                <input type="text" name="name" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" placeholder="Fullname">
                <div class="invalid-feedback"><?= $errors['name']??'' ?></div>
            </div>
            <div class="form-group my-2">
                <input type="email" name="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" placeholder="someone@example.com">
                <div class="invalid-feedback"><?= $errors['email']??'' ?></div>
            </div>
            <div class="form-group my-2">
                <input type="Subject" name="subject" class="form-control<?= isset($errors['subject']) ? ' is-invalid' : '' ?>" placeholder="Subject">
                <div class="invalid-feedback"><?= $errors['subject']??'' ?></div>
            </div>
            <div class="form-group my-2">
                <textarea class="form-control<?= isset($errors['message']) ? ' is-invalid' : '' ?>" name="message" rows="3" placeholder="Please Input a text Message"></textarea>
                <div class="invalid-feedback"><?= $errors['message']??'' ?></div>
            </div>
            <button type="submit" class="btn btn-success my-2">Send</button>
        </form>
    </div>
    <script>
        // Wrap every letter in a span
        var textWrapper = document.querySelector('.text');
        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

        anime.timeline({
                loop: true
            })
            .add({
                targets: '.text .letter',
                scale: [4, 1],
                opacity: [0, 1],
                translateZ: 0,
                easing: "easeOutExpo",
                duration: 950,
                delay: (el, i) => 70 * i
            }).add({
                targets: '.text',
                opacity: 0,
                duration: 1000,
                easing: "easeOutExpo",
                delay: 5000
            });
    </script>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    </script>
</body>

</html>