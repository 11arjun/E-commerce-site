<?php
require_once 'utils/sessionManager.php';
if (isset($_SESSION['trader'])) {
    header('Location: /trader');
    exit();
} else {
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/trader_register_style.css">

    <title>Become A Seller</title>
</head>

<body>
    <?php
    $page = 'seller';
    include 'header.php';
    ?>
    <form class="trader-form my-3" method="POST" action="/backend/registerTrader.php">
        <?php if (isset($message)) { ?>
            <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                <?= $message['message']; ?>
            </div>
        <?php } ?>
        <h2 class="text-center">Trader Registration Form</h2>
        <br>
        <div class="row mb-3">
            <label for="businessName" class="col-sm-3 col-form-label <?= isset($errors['name']) ? 'text-danger' : ''; ?>" required>Business Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>" name="name" id="businessName" placeholder="Business Name" value="<?= $old['name'] ?? ''; ?>">
                <?= isset($errors['name']) ? '<div class="invalid-feedback">' . $errors['name'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="username" class="col-sm-3 col-form-label <?= isset($errors['username']) ? 'text-danger' : ''; ?>" required>Username</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Username" value="<?= $old['username'] ?? ''; ?>">
                <?= isset($errors['username']) ? '<div class="invalid-feedback">' . $errors['username'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-3 col-form-label <?= isset($errors['email']) ? 'text-danger' : ''; ?>">Email</label>
            <div class="col-sm-9">
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email" value="<?= $old['email'] ?? ''; ?>">
                <?= isset($errors['confirm']) ? '<div class="invalid-feedback">' . $errors['confirm'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-3 col-form-label <?= isset($errors['password']) ? 'text-danger' : ''; ?>" required>Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Password">
                <?= isset($errors['password']) ? '<div class="invalid-feedback">' . $errors['password'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="confirm" class="col-sm-3 col-form-label <?= isset($errors['confirm']) ? 'text-danger' : ''; ?>" required>Confirm</label>
            <div class="col-sm-9">
                <input type="password" class="form-control <?= isset($errors['confirm']) ? 'is-invalid' : ''; ?>" name="confirm" id="confirm" placeholder="Confirm Password">
                <?= isset($errors['confirm']) ? '<div class="invalid-feedback">' . $errors['confirm'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="gender" class="col-sm-3 col-form-label <?= isset($errors['gender']) ? 'text-danger' : ''; ?>" required>Gender</label>
            <div class="col-sm-9">
                <select id="gender" name="gender" class="form-select <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>" required>
                    <option <?= !isset($old['gender']) ? 'selected' : ''; ?> disabled value="">Choose Gender</option>
                    <option <?php if (isset($old['gender'])) echo $old['gender'] == '1' ? 'selected' : ''; ?> value="1">Male</option>
                    <option <?php if (isset($old['gender'])) echo $old['gender'] == '2' ? 'selected' : ''; ?> value="2">Female</option>
                    <option <?php if (isset($old['gender'])) echo $old['gender'] == '3' ? 'selected' : ''; ?> value="3">Other</option>
                    <option <?php if (isset($old['gender'])) echo $old['gender'] == '4' ? 'selected' : ''; ?> value="4">Prefer not to specify</option>
                </select>
                <?= isset($errors['gender']) ? '<div class="invalid-feedback">' . $errors['gender'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="number" class="col-sm-3 col-form-label <?= isset($errors['number']) ? 'text-danger' : ''; ?>">Contact No.</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= isset($errors['number']) ? 'is-invalid' : ''; ?>" id="number" name="number" placeholder="Phone Number" value="<?= $old['number'] ?? ''; ?>">
                <?= isset($errors['number']) ? '<div class="invalid-feedback">' . $errors['number'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-1">
            <label for="street" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= isset($errors['street']) ? 'is-invalid' : ''; ?>" id="street" name="street" placeholder="Street Address" value="<?= $old['street'] ?? ''; ?>">
                <label for="street" class="form-label d-flex justify-content-center <?= isset($errors['street']) ? 'text-danger' : ''; ?>">Street Address</label>
            </div>
        </div>
        <div class="mb-1 row">
            <div class="col-sm-4 offset-sm-3 justify-content-end">
                <input type="text" class="form-control col-4 <?= isset($errors['city']) ? 'is-invalid' : ''; ?>" id="city" name="city" placeholder="City" value="<?= $old['city'] ?? ''; ?>">
                <label for="city" class="label mr-2 d-flex justify-content-center <?= isset($errors['city']) ? 'text-danger' : ''; ?>">City</label>
            </div>

            <div class="col-sm-5">
                <input type="text" class="form-control col-4 <?= isset($errors['state']) ? 'is-invalid' : ''; ?>" id="state" name="state" placeholder="State/Province" value="<?= $old['state'] ?? ''; ?>">
                <label for="state" class="label mr-2 d-flex justify-content-center <?= isset($errors['state']) ? 'text-danger' : ''; ?>">State/Province</label>
            </div>

        </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-4 offset-sm-3 justify-content-end">
                <input type="text" class="form-control col-4 <?= isset($errors['postal']) ? 'is-invalid' : ''; ?>" id="postal" name="postal" placeholder="Postal Code" value="<?= $old['postal'] ?? ''; ?>">
                <label for="postal" class="label mr-2 d-flex justify-content-center <?= isset($errors['postal']) ? 'text-danger' : ''; ?>">Postal Code/Zip Code</label>
            </div>

            <div class="col-sm-5">
                <select id="country" name="country" class="form-select <?= isset($errors['country']) ? 'is-invalid' : ''; ?>" required>
                    <option <?= !isset($old['country']) ? 'selected' : ''; ?> disabled value="">Choose a Country</option>
                    <option <?php if (isset($old['country'])) echo $old['country'] == 'Nepal' ? 'selected' : ''; ?> value="Nepal">Nepal</option>
                    <option <?php if (isset($old['country'])) echo $old['country'] == 'India' ? 'selected' : ''; ?> value="India">India</option>
                    <option <?php if (isset($old['country'])) echo $old['country'] == 'Bhutan' ? 'selected' : ''; ?> value="Bhutan">Bhutan</option>
                </select>
                <label for="country" class="label mr-2 d-flex justify-content-center <?= isset($errors['country']) ? 'text-danger' : ''; ?>">Country</label>
            </div>

        </div>

        <!--Trading since-->

        <div class=" row">
            <label for="month" class="col-sm-3 col-form-label">
                Trading Since
            </label>


            <div class="col-sm-3 mb-3 justify-content-end">
                <select class="form-select" id="month" name="month">
                    <option <?php if (isset($old['month'])) echo $old['month'] == '1' ? 'selected' : ''; ?> value="1">January</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '2' ? 'selected' : ''; ?> value="2">February</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '3' ? 'selected' : ''; ?> value="3">March</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '4' ? 'selected' : ''; ?> value="4">April</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '5' ? 'selected' : ''; ?> value="5">May</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '6' ? 'selected' : ''; ?> value="6">June</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '7' ? 'selected' : ''; ?> value="7">July</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '8' ? 'selected' : ''; ?> value="8">August</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '9' ? 'selected' : ''; ?> value="9">September</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '10' ? 'selected' : ''; ?> value="10">October</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '11' ? 'selected' : ''; ?> value="11">November</option>
                    <option <?php if (isset($old['month'])) echo $old['month'] == '12' ? 'selected' : ''; ?> value="12">December</option>
                </select>
                <label for="month" class="label mr-2 d-flex justify-content-center">Month</label>
            </div>
            <div class="col-sm-3 mb-3">
                <select class="form-select" id="day" name="day">
                    <option value="1" selected>1</option>
                    <?php for ($i = 2; $i <= 31; $i++) { ?>
                        <option <?php if (isset($old['day'])) echo $old['day'] == $i ? 'selected' : ''; ?> value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                </select>
                <label for="day" class="label mr-2 d-flex justify-content-center">Day</label>
            </div>
            <div class="col-sm-3 mb-3">
                <select class="form-select" id="year" name="year">
                    <option value="1999" selected>1999</option>
                    <?php for ($i = 1999; $i <= 2021; $i++) { ?>
                        <option <?php if (isset($old['year'])) echo $old['year'] == $i ? 'selected' : ''; ?> value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                </select>
                <label for="year" class="label mr-2 d-flex justify-content-center">Year</label>
            </div>
        </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-4 offset-sm-3 check">
                <label class="label mr-2 d-flex justify-content-start <?= isset($errors['type']) ? 'text-danger' : ''; ?>">Type of Bussiness</label>
                <div class="form-check">
                    <input class="form-check-input" name="type" <?php if (isset($old['type'])) echo $old['type'] == 'small' ? 'checked' : ''; ?> type="radio" value="small" id="small">
                    <label class="form-check-label" for="small">
                        Small
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="type" <?php if (isset($old['type'])) echo $old['type'] == 'medium' ? 'checked' : ''; ?> type="radio" value="medium" id="medium">
                    <label class="form-check-label" for="medium">
                        Medium
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="type" <?php if (isset($old['type'])) echo $old['type'] == 'large' ? 'checked' : ''; ?> type="radio" value="large" id="large">
                    <label class="form-check-label" for="large">
                        Large
                    </label>
                </div>
                <?= isset($errors['type']) ? '<div class="text-danger">' . $errors['type'] . '</div>' : ''; ?>
            </div>
            <div class="col-sm-5 check">
                <label class="label mr-2 d-flex justify-content-start <?= isset($errors['payments']) ? 'text-danger' : ''; ?>">Preferred Payment</label>
                <div class="form-check">
                    <input class="form-check-input" name="payments[]" type="checkbox" <?php if (isset($old['type'])) echo in_array('card', $old['payments']) ? 'checked' : ''; ?> value="card" id="card">
                    <label class="form-check-label" for="card">
                        Card
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="payments[]" type="checkbox" <?php if (isset($old['type'])) echo in_array('cash', $old['payments']) ? 'checked' : ''; ?> value="cash" id="cash">
                    <label class="form-check-label" for="cash">
                        Cash
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="payments[]" type="checkbox" <?php if (isset($old['type'])) echo in_array('paypal', $old['payments']) ? 'checked' : ''; ?> value="paypal" id="paypal">
                    <label class="form-check-label" for="paypal">
                        Paypal
                    </label>
                </div>
                <?= isset($errors['payments']) ? '<div class="text-danger">' . $errors['payments'] . '</div>' : ''; ?>
            </div>
        </div>

        <div class="row mb-3">
            <label for="message" class="col-sm-3 col-form-label <?= isset($errors['message']) ? 'text-danger' : ''; ?>">Message</label>
            <div class="col-sm-9">
                <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : ''; ?>" id="message" name="message" rows="6" placeholder="Application message here..."><?= $old['message'] ?? ''; ?></textarea>
                <?= isset($errors['message']) ? '<div class="invalid-feedback">' . $errors['message'] . '</div>' : ''; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-9 offset-sm-3">
                <div class="form-check">
                    <input class="form-check-input <?= isset($errors['toc']) ? 'is-invalid' : ''; ?>" type="checkbox" id="toc" name="toc">
                    <label class="form-check-label" for="toc">
                        I agree the <a class="toc" href="toc.php">Terms and condition</a>
                    </label>
                    <?= isset($errors['toc']) ? '<div class="invalid-feedback">' . $errors['toc'] . '</div>' : ''; ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="w-100 traderbtn">Register</button>
            </div>
        </div>
        </div>
    </form>

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    </script>
</body>

</html>