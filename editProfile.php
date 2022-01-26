<?php
require_once 'utils/sessionManager.php';
require_once 'utils/database.php';
if (!isset($_SESSION['user'])) {
    header('Location: /signin.php');
} else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
    header('Location: /verifyEmail.php');
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
    <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Profile</title>
</head>

<body>
    <?php
    $page = 'profile';
    include 'header.php';
    $user_id = $_SESSION['user']['USER_ID'];
    $user = fetch_row("SELECT * FROM USERS WHERE USER_ID ='$user_id'");
    $user['GENDER'] = $old['gender'] ?? $user['GENDER'];
    $user['COUNTRY'] = $old['country'] ?? $user['COUNTRY'];
    ?>
    <div class="container-fluid d-flex justify-content-center">
        <div class="w-75 p-5 my-5 bg-dark text-light">
            <h5 class="mb-2">Edit Profile</h5>
            <?php if (isset($message)) { ?>
                <div class="alert alert-<?= $message['color'] ?> text-center" role="alert">
                    <?= $message['message']; ?>
                </div>
            <?php } ?>
            <form action="/backend/updateProfile.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="img">
                            <img src="<?= $user['IMAGE'] ?? '/assets/images/adminlte/avatar2.png' ?>" alt="" class="img-circle elevation-2" id="imagePreview" style="max-width: 250px;">
                        </div>
                        <div class="form-group mt-4">
                            <label for="profileImage">Profile Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="profileImage" class="custom-file-input <?= isset($errors['profileImage']) ? 'is-invalid' : ''; ?>" id="profileImage">
                                    <label class="custom-file-label" for="profileImage">Choose image</label>
                                </div>
                            </div>
                            <?= isset($errors['profileImage']) ? '<div class="text-danger">' . $errors['profileImage'] . '</div>' : ''; ?>
                        </div>
                    </div>
                    <div class="col-md-7 offset-md-1 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="full_name" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['FULL_NAME'] ?>" value="<?= $old['full_name'] ?? '' ?>">
                            <?= isset($errors['full_name']) ? '<div class="invalid-feedback">' . $errors['full_name'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['USERNAME'] ?>" value="<?= $old['username'] ?? '' ?>">
                            <?= isset($errors['username']) ? '<div class="invalid-feedback">' . $errors['username'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" placeholder="<?= $user['EMAIL'] ?>" value="<?= $old['email'] ?? '' ?>">
                            <?= isset($errors['email']) ? '<div class="invalid-feedback">' . $errors['email'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>">
                                <option <?= $user['GENDER'] == '1' ? 'selected' : ''; ?> value="1">Male</option>
                                <option <?= $user['GENDER'] == '2' ? 'selected' : ''; ?> value="2">Female</option>
                                <option <?= $user['GENDER'] == '3' ? 'selected' : ''; ?> value="3">Others</option>
                                <option <?= $user['GENDER'] == '4' ? 'selected' : ''; ?> value="4">Prefer Not to Specify</option>
                            </select>
                            <?= isset($errors['gender']) ? '<div class="invalid-feedback">' . $errors['gender'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group">
                            <div class="my-2">
                                <strong>Address</strong>
                                <input type="text" id="st1" name="street" class="form-control <?= isset($errors['street']) ? 'is-invalid' : ''; ?>" placeholder="Street Address" value="<?= $user['STREET'] ?>">
                            </div>
                            <div class="row my-2">
                                <div class="col-6">
                                    <input type="text" id="city" name="city" class="form-control <?= isset($errors['city']) ? 'is-invalid' : ''; ?>" placeholder="City" value="<?= $user['CITY'] ?>">
                                </div>
                                <div class="col-6">
                                    <input type="text" id="state" name="state" class="form-control <?= isset($errors['state']) ? 'is-invalid' : ''; ?>" placeholder="State/Province" value="<?= $user['STATE'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" id="postal" name="postal" class="form-control <?= isset($errors['postal']) ? 'is-invalid' : ''; ?>" placeholder="Postal Code" value="<?= $user['POSTAL'] ?>">
                                </div>
                                <div class="col-6">
                                    <select id="country" name="country" class="form-control <?= isset($errors['country']) ? 'is-invalid' : ''; ?>" required>
                                        <option <?= $user['COUNTRY'] == 'Nepal' ? 'selected' : ''; ?> value="Nepal">Nepal</option>
                                        <option <?= $user['COUNTRY'] == 'India' ? 'selected' : ''; ?> value="India">India</option>
                                        <option <?= $user['COUNTRY'] == 'Bhutan' ? 'selected' : ''; ?> value="Bhutan">Bhutan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <button class="btn btn-secondary mb-2" type="submit">Update</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-secondary mb-2" onclick="event.preventDefault(); window.location.href='/profile.php'">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.row -->
        </div>
    </div><!-- /.container-fluid -->

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <!-- bs-custom-file-input -->
    <script src="/js/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        bsCustomFileInput.init();
        document.getElementById('profileImage').onchange = evt => {
            const [file] = document.getElementById('profileImage').files
            if (file) {
                document.getElementById('imagePreview').src = URL.createObjectURL(file)
            }
        }
    </script>
</body>

</html>