<?php
require_once 'utils/sessionManager.php';
if(isset($_SESSION['user'])){
    header('Location: /');
}else {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        $old = $_SESSION['old'];
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
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
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <title>Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Registration-Form.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $page = "signup";
    include 'header.php';
    ?>
    <section class="register-photo">
        <div class="form-container" style="min-width: 500px;max-width: 500px;">
            <form method="POST" action="backend/registeruser.php">
                <?php if (isset($message)) { ?>
                    <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                        <?= $message['message']; ?>
                    </div>
                <?php } ?>
                <h2 class="text-center"><strong>Register</strong></h2>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>" type="text" placeholder="Name:" name="name" value="<?= $old['name'] ?? ''; ?>">
                    <?= isset($errors['name']) ? '<span class="text-danger ps-3">' . $errors['name'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" type="text" name="username" placeholder="Username:" value="<?= $old['username'] ?? ''; ?>">
                    <?= isset($errors['username']) ? '<span class="text-danger ps-3">' . $errors['username'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" type="email" name="email" placeholder="Email:" value="<?= $old['email'] ?? ''; ?>">
                    <?= isset($errors['email']) ? '<span class="text-danger ps-3">' . $errors['email'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['street']) ? 'is-invalid' : ''; ?>" type="text" name="street" placeholder="Street Address:" value="<?= $old['street'] ?? ''; ?>">
                    <?= isset($errors['street']) ? '<span class="text-danger ps-3">' . $errors['street'] . '</span>' : ''; ?>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <input class=" form-control <?= isset($errors['city']) ? 'is-invalid' : ''; ?>" type="text" name="city" placeholder="City:" value="<?= $old['city'] ?? ''; ?>">
                        <?= isset($errors['city']) ? '<span class="text-danger ps-3">' . $errors['city'] . '</span>' : ''; ?>
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control <?= isset($errors['state']) ? 'is-invalid' : ''; ?>" type="text" name="state" placeholder="State:" value="<?= $old['state'] ?? ''; ?>">
                        <?= isset($errors['state']) ? '<span class="text-danger ps-3">' . $errors['state'] . '</span>' : ''; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <input class="form-control <?= isset($errors['postal']) ? 'is-invalid' : ''; ?>" type="text" name="postal" placeholder="Postal/Zip Code:" value="<?= $old['postal'] ?? ''; ?>">
                        <?= isset($errors['postal']) ? '<span class="text-danger ps-3">' . $errors['postal'] . '</span>' : ''; ?>
                    </div>
                    <div class="col-sm-6">
                        <select id="country" name="country" class="form-select <?= isset($errors['country']) ? 'is-invalid' : ''; ?>" required>
                            <option <?= !isset($old['country']) ? 'selected' : ''; ?> disabled value="">Choose a Country</option>
                            <option <?php if (isset($old['country'])) echo $old['country'] == 'Nepal' ? 'selected' : ''; ?> value="Nepal">Nepal</option>
                            <option <?php if (isset($old['country'])) echo $old['country'] == 'India' ? 'selected' : ''; ?> value="India">India</option>
                            <option <?php if (isset($old['country'])) echo $old['country'] == 'Bhutan' ? 'selected' : ''; ?> value="Bhutan">Bhutan</option>
                        </select>
                        <?= isset($errors['country']) ? '<span class="text-danger ps-3">' . $errors['country'] . '</span>' : ''; ?>
                    </div>
                </div>
                <div class="mb-3">
                        <select id="gender" name="gender" class="form-select <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>" required>
                            <option <?= !isset($old['gender']) ? 'selected' : ''; ?> disabled value="">Choose Gender</option>
                            <option <?php if (isset($old['gender'])) echo $old['gender'] == '1' ? 'selected' : ''; ?> value="1">Male</option>
                            <option <?php if (isset($old['gender'])) echo $old['gender'] == '2' ? 'selected' : ''; ?> value="2">Female</option>
                            <option <?php if (isset($old['gender'])) echo $old['gender'] == '3' ? 'selected' : ''; ?> value="3">Other</option>
                            <option <?php if (isset($old['gender'])) echo $old['gender'] == '4' ? 'selected' : ''; ?> value="4">Prefer not to specify</option>
                        </select>
                        <?= isset($errors['gender']) ? '<span class="text-danger ps-3">' . $errors['gender'] . '</span>' : ''; ?>
                    </div>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" type="password" name="password" placeholder="Password:">
                    <?= isset($errors['password']) ? '<span class="text-danger ps-3">' . $errors['password'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3">
                    <input class="form-control <?= isset($errors['confirm']) ? 'is-invalid' : ''; ?>" type="password" name="confirm" placeholder="Confirm Password:">
                    <?= isset($errors['confirm']) ? '<span class="text-danger ps-3">' . $errors['confirm'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input <?= isset($errors['toc']) ? 'is-invalid' : ''; ?>" name="toc" type="checkbox">I agree to the to the <a href="toc.php">Terms and Condition</a>
                        </label>
                    </div>
                    <?= isset($errors['toc']) ? '<span class="text-danger ps-3">' . $errors['toc'] . '</span>' : ''; ?>
                </div>
                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Register</button></div><a class="already" href="signin.php" style="color: #fb7925;">Already have an account?</a>
            </form>
        </div>
    </section>
    <?php include 'footer.php' ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script>
            <?php
            if (isset($message)) {
                if ($message['color'] == "success") {
            ?>
                    setInterval(
                        function() {
                            window.location.replace('/signin.php');
                        }, 5000
                    );
            <?php
                }
            }
            ?>
    </script>
</body>

</html>