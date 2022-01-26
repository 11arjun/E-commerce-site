<?php
require_once 'utils/database.php';
if (empty($_GET['q'])) {
    header('Location: /');
    exit();
}
$searchbar = $_GET['q'];
$sortBy = $_GET['sort'] ?? '';
$style = $_GET['style'] ?? '';
$searchCategory = $_GET['category'] ?? '';
$rating = $_GET['rating'] ?? '';
$price = $_GET['price'] ?? '';
$filterCount = 0;
if (!empty($searchCategory)) {
    $filterCount++;
}
if (!empty($rating)) {
    $filterCount++;
}
if (!empty($price)) {
    $filterCount++;
}
if (!empty($price)) {
    $min = explode('-', $price)[0];
    $max = explode('-', $price)[1];
}
$sql = "SELECT PRODUCTS.*, (SELECT AVG(RATING) FROM REVIEWS WHERE REVIEWS.PRODUCT_ID = PRODUCTS.PRODUCT_ID) AS RATING FROM PRODUCTS WHERE PRODUCT_NAME LIKE '%$searchbar%' AND CONFIRMED_ON IS NOT NULL";

if (!empty($rating))
    $sql .= " AND RATING >= $rating";

if (!empty($searchCategory))
    $sql .= " AND CATEGORY_ID = $searchCategory";

if (!empty($price)) {
    if ($min !== '' && $max !== '')
        $sql .= " AND PRICE BETWEEN $min*100 AND $max*100 ";
    else if ($min !== '')
        $sql .= " AND PRICE >= $min*100";
    else if ($max !== '')
        $sql .= " AND PRICE <= $max*100";
}

switch ($sortBy) {
    case "priceasc":
        $sql .= " ORDER BY PRICE ASC";
        break;
    case "pricedesc":
        $sql .= " ORDER BY PRICE DESC";
        break;
    case "popularity":
    case "":
        $sql .= " ORDER BY
            CASE
              WHEN PRODUCT_NAME LIKE 'searchstring' THEN 1
              WHEN PRODUCT_NAME LIKE 'searchstring%' THEN 2
              WHEN PRODUCT_NAME LIKE '%searchstring' THEN 4
              ELSE 3
            END";
        break;
}
$searchProducts = fetch_all_row($sql);
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
    <link rel="stylesheet" href="css/search.css">

    <title><?= $searchbar ?> | OnlineAppetite</title>
</head>

<body>
    <?php
    include 'header.php';
    $id = array_search($searchCategory, array_column($categories, 'CATEGORY_ID'));
    if ($id !== false) {
        $categoryName = $categories[$id]['CATEGORY_NAME'];
    }
    ?>
    <div class="container-fluid searchview">
        <div class="d-lg-flex py-4 px-lg-4">
            <div class="left-view d-none d-lg-block">
                <div class="categories">
                    <div class="title">Categories:</div>
                    <?php foreach ($categories as $category) { ?>
                        <a href="javascript:setSearchParam('category','<?= $category['CATEGORY_ID'] ?>')"><?= $category['CATEGORY_NAME'] ?></a>
                    <?php } ?>
                </div>
                <div class="price">
                    <div class="title">Price:</div>
                    <form onsubmit="priceSearch(this)" class="range">
                        <input type="number" class="min" placeholder="Min" min="0" value="<?= $min ?? '' ?>">
                        <input type="number" class="max" placeholder="Max" min="0" value="<?= $max ?? '' ?>">
                        <button><i class="fas fa-play"></i></button>
                    </form>
                </div>
                <div class="rating">
                    <div class="title">Rating:</div>
                    <a href="javascript:setSearchParam('rating','5')"><?php for ($i = 0; $i < 5; $i++) {
                                                                            echo '<i class="fas fa-star text-warning"></i>';
                                                                        } ?></a>
                    <a href="javascript:setSearchParam('rating','4')"><?php for ($i = 0; $i < 4; $i++) {
                                                                            echo '<i class="fas fa-star text-warning"></i>';
                                                                        }
                                                                        echo '<i class="fas fa-star text-grey"></i>';
                                                                        ?> And Up</a>
                    <a href="javascript:setSearchParam('rating','3')"><?php for ($i = 0; $i < 3; $i++) {
                                                                            echo '<i class="fas fa-star text-warning"></i>';
                                                                        }
                                                                        for ($i = 0; $i < 2; $i++) {
                                                                            echo '<i class="fas fa-star text-grey"></i>';
                                                                        }
                                                                        ?> And Up</a>
                    <a href="javascript:setSearchParam('rating','2')"><?php for ($i = 0; $i < 2; $i++) {
                                                                            echo '<i class="fas fa-star text-warning"></i>';
                                                                        }
                                                                        for ($i = 0; $i < 3; $i++) {
                                                                            echo '<i class="fas fa-star text-grey"></i>';
                                                                        }
                                                                        ?> And Up</a>
                    <a href="javascript:setSearchParam('rating','1')"><?php for ($i = 0; $i < 1; $i++) {
                                                                            echo '<i class="fas fa-star text-warning"></i>';
                                                                        }
                                                                        for ($i = 0; $i < 4; $i++) {
                                                                            echo '<i class="fas fa-star text-grey"></i>';
                                                                        }
                                                                        ?> And Up</a>

                </div>
            </div>
            <div id="filter-small" class="left-view filter-small d-flex d-lg-none">
                <div class="filters">
                    <div class="categories">
                        <div class="title">Categories:</div>
                        <?php foreach ($categories as $category) { ?>
                            <a href="javascript:setSearchParam('category','<?= $category['CATEGORY_ID'] ?>')"><?= $category['CATEGORY_NAME'] ?></a>
                        <?php } ?>
                    </div>
                    <div class="price">
                        <div class="title">Price:</div>
                        <form onsubmit="priceSearch(this)" class="range">
                            <input type="number" class="min" placeholder="Min" min="0" value="<?= $min ?? '' ?>">
                            <input type="number" class="max" placeholder="Max" min="0" value="<?= $max ?? '' ?>">
                            <button><i class="fas fa-play"></i></button>
                        </form>
                    </div>
                    <div class="rating">
                        <div class="title">Rating:</div>
                        <a href="javascript:setSearchParam('rating','5')"><?php for ($i = 0; $i < 5; $i++) {
                                                                                echo '<i class="fas fa-star text-warning"></i>';
                                                                            } ?></a>
                        <a href="javascript:setSearchParam('rating','4')"><?php for ($i = 0; $i < 4; $i++) {
                                                                                echo '<i class="fas fa-star text-warning"></i>';
                                                                            }
                                                                            echo '<i class="fas fa-star text-grey"></i>';
                                                                            ?> And Up</a>
                        <a href="javascript:setSearchParam('rating','3')"><?php for ($i = 0; $i < 3; $i++) {
                                                                                echo '<i class="fas fa-star text-warning"></i>';
                                                                            }
                                                                            for ($i = 0; $i < 2; $i++) {
                                                                                echo '<i class="fas fa-star text-grey"></i>';
                                                                            }
                                                                            ?> And Up</a>
                        <a href="javascript:setSearchParam('rating','2')"><?php for ($i = 0; $i < 2; $i++) {
                                                                                echo '<i class="fas fa-star text-warning"></i>';
                                                                            }
                                                                            for ($i = 0; $i < 3; $i++) {
                                                                                echo '<i class="fas fa-star text-grey"></i>';
                                                                            }
                                                                            ?> And Up</a>
                        <a href="javascript:setSearchParam('rating','1')"><?php for ($i = 0; $i < 1; $i++) {
                                                                                echo '<i class="fas fa-star text-warning"></i>';
                                                                            }
                                                                            for ($i = 0; $i < 4; $i++) {
                                                                                echo '<i class="fas fa-star text-grey"></i>';
                                                                            }
                                                                            ?> And Up</a>

                    </div>
                </div>
                <div class="filter-buttons">
                    <button class="btn btn-warning btn-lg" onclick="clearSearchParams()">Reset</button>
                    <button class="btn btn-info btn-lg" onclick="closeFilters()">Done</button>
                </div>
            </div>
            <div class="right-view ps-lg-5">
                <div class="d-block d-lg-flex align-items-center justify-content-between">
                    <div class="d-none d-lg-block">
                        <p><?= count($searchProducts) ?> items found for "<?= $searchbar ?>"<?= !empty($categoryName) ? " in $categoryName" : "" ?></p>
                        <div class="applied-filters">
                            <?php if (!empty($price)) { ?>
                                <span class="round-pill">Price: <?= $price ?> <i class="fas fa-times" onclick="unsetSearchParam('price')"></i></span>
                            <?php } ?>
                            <?php if (!empty($searchCategory)) { ?>
                                <span class="round-pill">Category: <?= $searchCategory ?> <i class="fas fa-times" onclick="unsetSearchParam('category')"></i></span>
                            <?php } ?>
                            <?php if (!empty($rating)) { ?>
                                <span class="round-pill">Rating: <?= $rating ?> <i class="fas fa-times" onclick="unsetSearchParam('rating')"></i></span>
                            <?php } ?>
                            <?php if ($filterCount > 0) { ?>
                                <span class="clear-all" onclick="clearSearchParams()"> Clear All</span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="d-flex display-options  align-items-center">
                        <div class="d-flex align-items-center">
                            Sort By: <div class="sort">
                                <div class="custom-select-wrapper">
                                    <div class="custom-select">
                                        <div class="custom-select__trigger"><span>
                                                <?php
                                                switch ($sortBy) {
                                                    case 'popularity':
                                                        echo "Best Match";
                                                        break;
                                                    case 'priceasc':
                                                        echo "Price low to high";
                                                        break;
                                                    case 'pricedesc':
                                                        echo "Price high to low";
                                                        break;
                                                    default:
                                                        echo "Best Match";
                                                        break;
                                                }
                                                ?>
                                            </span>
                                            <div class="arrow"></div>
                                        </div>
                                        <div class="custom-options">
                                            <span class="custom-option<?= empty($sortBy) || $sortBy == "popularity" ? " selected" : "" ?>" data-value="popularity">Best Match</span>
                                            <span class="custom-option<?= $sortBy == "priceasc" ? " selected" : "" ?>" data-value="priceasc">Price low to high</span>
                                            <span class="custom-option<?= $sortBy == "pricedesc" ? " selected" : "" ?>" data-value="pricedesc">Price high to low</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="large-filter d-none d-lg-block">
                            <div class="view ms-3">
                                View:
                                <button <?= empty($style) || $style == 'wf' ? 'class="active"' : '' ?> onclick="setSearchParam('style','wf')"><i class="fas fa-th-large"></i></button>
                                <button <?= $style == 'list' ? 'class="active"' : '' ?> onclick="setSearchParam('style','list')"><i class="fas fa-th-list"></i></button>
                            </div>
                        </div>
                        <div class="small-filter d-flex d-lg-none align-items-center">
                            <span class="px-2 open-filter-button" onclick="openFilters()">
                                <div class="filter-logo">
                                    <i class="fas fa-filter"></i>
                                    <?php if ($filterCount > 0) { ?>
                                        <span class="filter-badge"><?= $filterCount ?></span>
                                    <?php } ?>
                                </div> Filter
                            </span>
                            <div class="view">
                                <?php if ($style == 'list') { ?><button class="active" onclick="setSearchParam('style','wf')"><i class="fas fa-th-large"></i></button>
                                <?php } else { ?><button class="active" onclick="setSearchParam('style','list')"><i class="fas fa-th-list"></i></button><?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="color: #aaa;">
                <div class="search-wf<?= $style == "list" ? " d-none" : "" ?>">
                    <?php
                    foreach ($searchProducts as $product) {
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
                <div class="search-list<?= $style != "list" ? " d-none" : "" ?>">
                    <?php
                    foreach ($searchProducts as $product) {
                        $discounts = fetch_all_row("SELECT RATE FROM DISCOUNTS WHERE ((DISCOUNT_TYPE = 'all') OR (DISCOUNT_TYPE = 'category' AND TARGET_ID = '" . $product['CATEGORY_ID'] . "') OR (DISCOUNT_TYPE = 'product' AND TARGET_ID = '" . $product['PRODUCT_ID'] . "')) AND STARTS_ON < CURRENT_DATE AND EXPIRES_ON > CURRENT_DATE ORDER BY DISCOUNT_TYPE");
                        $discounted_price = round($product['PRICE'] / 100.0, 2);
                        foreach ($discounts as $discount) {
                            $discounted_price = $discounted_price * (100 - $discount['RATE']) * 0.01;
                        }
                        $discount_rate = (round($product['PRICE'] / 100.0, 2) - $discounted_price) * 100 / round($product['PRICE'] / 100.0, 2);
                    ?>
                        <div class="list-product" onclick="window.location.href='/product.php?id=<?= $product['PRODUCT_ID'] ?>'">
                            <img class="product-image" src="<?= $product['IMAGE1'] ?>" alt="">
                            <div class="d-flex w-100 align-content-center justify-content-between">
                                <div class="product-data">
                                    <div class="product-name py-2"><?= $product['PRODUCT_NAME'] ?></div>
                                    <div class="d-block d-md-none">
                                        <div class="price pb-2">£ <?= number_format((float)$discounted_price, 2, '.', '') ?></div>
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
                                    </div>
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
                                    <div class="description mt-3 d-none d-md-block"><?= $product['DESCRIPTION'] ?></div>
                                </div>
                                <div class="d-none d-md-block price-large">
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
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script>
        document.querySelector('.custom-select-wrapper').addEventListener('click', function() {
            this.querySelector('.custom-select').classList.toggle('open');
        });
        for (const option of document.querySelectorAll(".custom-option")) {
            option.addEventListener('click', function() {
                if (!this.classList.contains('selected')) {
                    this.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                    this.classList.add('selected');
                    this.closest('.custom-select').querySelector('.custom-select__trigger span').textContent = this.textContent;
                    sort = this.dataset.value;
                    setSearchParam('sort', sort)
                }
            })
        }
        window.addEventListener('click', function(e) {
            const select = document.querySelector('.custom-select')
            if (!select.contains(e.target)) {
                select.classList.remove('open');
            }
        });

        function priceSearch(form) {
            event.preventDefault();
            min = form.querySelector('.min').value;
            max = form.querySelector('.max').value;
            if (min != '' || max != '') {
                price = min + '-' + max;
                setSearchParam('price', price)
            }
        }

        function setSearchParam(key, value) {
            const query = new URLSearchParams(window.location.search);
            query.set(key, value);
            window.location.search = query;
        }

        function unsetSearchParam(key) {
            const query = new URLSearchParams(window.location.search);
            query.delete(key);
            window.location.search = query;
        }

        function clearSearchParams() {
            const query = new URLSearchParams(window.location.search);
            query.delete('price');
            query.delete('category');
            query.delete('rating');
            window.location.search = query;
        }
    </script>
    <script>
        function openFilters() {
            document.getElementById('filter-small').style.right = "0";
        }
    </script>
    <script>
        function closeFilters() {
            document.getElementById('filter-small').style.right = "-250px";
        }
    </script>
</body>

</html>