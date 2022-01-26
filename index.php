<?php
require_once 'utils/database.php';
$more = $_GET['more'] ?? '' == 'true' ? 30 : 15;
$latestProducts = fetch_all_row("SELECT PRODUCTS.*, (SELECT AVG(RATING) FROM REVIEWS WHERE REVIEWS.PRODUCT_ID = PRODUCTS.PRODUCT_ID) AS RATING FROM PRODUCTS WHERE CONFIRMED_ON IS NOT NULL ORDER BY CREATED_AT " . limit_result(5));
$products = fetch_all_row("SELECT PRODUCTS.*, (SELECT AVG(RATING) FROM REVIEWS WHERE REVIEWS.PRODUCT_ID = PRODUCTS.PRODUCT_ID) AS RATING FROM PRODUCTS WHERE CONFIRMED_ON IS NOT NULL ORDER BY " . random_order() . " " . limit_result($more));
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
    <title>OnlineAppetite</title>
</head>

<body>
    <?php
    $page = 'home';
    include 'header.php';
    ?>
    <div id="indexCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#indexCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#indexCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#indexCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#indexCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#indexCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="assets/images/slider1.jpeg" class="d-block w-100" alt="slider1">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-3">Online Appetite</h2>
                    <p class="display-6">Online Appetite is the leading online marketplace in uk connecting thousands of
                        sellers with millions of customers in uk.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="assets/images/slider2.jpeg" class="d-block w-100" alt="slider2">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-3">Online Appetite</h2>
                    <p class="display-6">Online Appetite is the leading online marketplace in uk connecting thousands of
                        sellers with millions of customers in uk.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="assets/images/slider3.jpeg" class="d-block w-100" alt="slider3">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-3">Online Appetite</h2>
                    <p class="display-6">Online Appetite is the leading online marketplace in uk connecting thousands of
                        sellers with millions of customers in uk.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="assets/images/slider4.jpeg" class="d-block w-100" alt="slider4">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-3">Online Appetite</h2>
                    <p class="display-6">Online Appetite is the leading online marketplace in uk connecting thousands of
                        sellers with millions of customers in uk.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="assets/images/slider5.jpeg" class="d-block w-100" alt="slider5">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-3">Online Appetite</h2>
                    <p class="display-6">Online Appetite is the leading online marketplace in uk connecting thousands of
                        sellers with millions of customers in uk.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#indexCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#indexCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container-fluid text-center py-5">
        <div class="category-container">
            <h3>Categories</h3>
            <div class="index-categories">
                <?php
                foreach ($categories as $category) {
                ?>
                    <div class="index-category" onclick="window.location.href='/category.php?id=<?= $category['CATEGORY_ID'] ?>'">
                        <img class="category-image" src="<?= $category['IMAGE'] ?>" alt="Category Image">
                        <div class="category-data text-center">
                            <span class="category-name py-2"><?= $category['CATEGORY_NAME'] ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="latest-container">
            <h3>Latest Products</h3>
            <div class="products">
                <?php
                foreach ($latestProducts as $index => $product) {
                    if ($index > 4) {
                        break;
                    }
                    $discounts = fetch_all_row("SELECT RATE FROM DISCOUNTS WHERE ((DISCOUNT_TYPE = 'all') OR (DISCOUNT_TYPE = 'category' AND TARGET_ID = '" . $product['CATEGORY_ID'] . "') OR (DISCOUNT_TYPE = 'product' AND TARGET_ID = '" . $product['PRODUCT_ID'] . "')) AND STARTS_ON < CURRENT_DATE AND EXPIRES_ON > CURRENT_DATE ORDER BY DISCOUNT_TYPE");
                    $discounted_price = round($product['PRICE'] / 100.0, 2);
                    foreach ($discounts as $discount) {
                        $discounted_price = $discounted_price * (100 - $discount['RATE']) * 0.01;
                    }
                    $discount_rate = (round($product['PRICE'] / 100.0, 2) - $discounted_price) * 100 / round($product['PRICE'] / 100.0, 2);
                ?>
                    <div class="product" onclick="window.location.href='/product.php?id=<?= $product['PRODUCT_ID'] ?>'">
                        <img class="product-image" src="<?= $product['IMAGE1'] ?>" alt="">
                        <div class="product-data">
                            <span class="product-name py-2"><?= $product['PRODUCT_NAME'] ?></span>
                            <span class="price pb-2">£ <?= number_format((float)$discounted_price, 2, '.', '') ?></span>
                            <?php
                            if (round($product['PRICE'] / 100.0, 2) != $discounted_price) {
                            ?>
                                <div>
                                    <span class="discount">£ <?= number_format((float)$product['PRICE'] / 100, 2, '.', '') ?></span> -
                                    <span class="rate"><?= round($discount_rate, 2) ?>%</span>
                                </div>
                            <?php
                            }
                            ?>
                            <?php if ($product['RATING'] > 0) { ?>
                                <div class="stars d-inline-block">
                                    <?php
                                    for ($i = 0; $i < (int)$product['RATING']; $i++) {
                                        echo '<small class="fas fa-star text-warning"></small>';
                                    }
                                    $remaining = 5 - (int)$product['RATING'];
                                    if ($product['RATING'] != (int)$product['RATING']) {
                                        echo '<small class="fas fa-star-half-alt text-warning"></small>';
                                        $remaining--;
                                    }
                                    for ($i = 0; $i < $remaining; $i++) {
                                        echo '<small class="far fa-star text-warning"></small>';
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="products-container">
            <h3>Just For You</h3>
            <div class="products">
                <?php
                foreach ($products as $index => $product) {
                    if ($index >= $more) {
                        break;
                    }
                    $discounts = fetch_all_row("SELECT RATE FROM DISCOUNTS WHERE ((DISCOUNT_TYPE = 'all') OR (DISCOUNT_TYPE = 'category' AND TARGET_ID = '" . $product['CATEGORY_ID'] . "') OR (DISCOUNT_TYPE = 'product' AND TARGET_ID = '" . $product['PRODUCT_ID'] . "')) AND STARTS_ON < CURRENT_DATE AND EXPIRES_ON > CURRENT_DATE");
                    $discounted_price = round($product['PRICE'] / 100.0, 2);
                    foreach ($discounts as $discount) {
                        $discounted_price = $discounted_price * (100 - $discount['RATE']) * 0.01;
                    }
                    $discount_rate = (round($product['PRICE'] / 100.0, 2) - $discounted_price) * 100 / round($product['PRICE'] / 100.0, 2);
                ?>
                    <div class="product" onclick="window.location.href='/product.php?id=<?= $product['PRODUCT_ID'] ?>'">
                        <img class="product-image" src="<?= $product['IMAGE1'] ?>" alt="">
                        <div class="product-data">
                            <span class="product-name py-2"><?= $product['PRODUCT_NAME'] ?></span>
                            <span class="price pb-2">£ <?= number_format((float)$discounted_price, 2, '.', '') ?></span>
                            <?php
                            if (round($product['PRICE'] / 100.0, 2) != $discounted_price) {
                            ?>
                                <div>
                                    <span class="discount">£ <?= number_format((float)$product['PRICE'] / 100, 2, '.', '') ?></span> -
                                    <span class="rate"><?= round($discount_rate, 2) ?>%</span>
                                </div>
                            <?php
                            }
                            ?>
                            <?php if ($product['RATING'] > 0) { ?>
                                <div class="stars d-inline-block">
                                    <?php
                                    for ($i = 0; $i < (int)$product['RATING']; $i++) {
                                        echo '<small class="fas fa-star text-warning"></small>';
                                    }
                                    $remaining = 5 - (int)$product['RATING'];
                                    if ($product['RATING'] != (int)$product['RATING']) {
                                        echo '<small class="fas fa-star-half-alt text-warning"></small>';
                                        $remaining--;
                                    }
                                    for ($i = 0; $i < $remaining; $i++) {
                                        echo '<small class="far fa-star text-warning"></small>';
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <button class="loadmore" onclick="window.location.href='/?more=true'">LOAD MORE</button>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/adminlte/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>