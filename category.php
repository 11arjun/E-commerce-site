<?php
require 'utils/database.php';
$category_id = $_GET['id'];
$pageCategory = fetch_row("SELECT * FROM CATEGORIES WHERE CATEGORY_ID = '$category_id'");
if (!$pageCategory) {
    header('Location: 404.php');
    exit();
}
$count = $_GET['more'] ?? '' == 'true' ? 30 : 15;
$products = fetch_all_row("SELECT PRODUCTS.*, (SELECT AVG(RATING) FROM REVIEWS WHERE REVIEWS.PRODUCT_ID = PRODUCTS.PRODUCT_ID) AS RATING FROM PRODUCTS WHERE CATEGORY_ID = '$category_id' AND CONFIRMED_ON IS NOT NULL ORDER BY CREATED_AT " . limit_result($count));
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

    <title><?= $pageCategory['CATEGORY_NAME'] ?></title>
</head>

<body>
    <?php
    $page = 'category';
    include 'header.php';
    ?>
    <div class="container-fluid text-center py-5">
        <h2>Category: <?= $pageCategory['CATEGORY_NAME'] ?></h2>
        <div class="products">
            <?php
            foreach ($products as $product) {
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
        <button class="loadmore" onclick="window.location.href='/category.php?id=<?= $category_id ?>&more=true'">LOAD MORE</button>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    </script>
</body>

</html>