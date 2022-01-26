<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart_style.css">
    <title>Cart</title>
</head>

<body>
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/assets/images/logoSmall.png" alt="DFOS" height="60" width="60">
    </div>
    <?php
    $page = 'cart';
    include 'header.php';
    if (!isset($_SESSION['user'])) {
        header('Location: /signin.php');
        exit();
    } else if (!isset($_SESSION['user']['EMAIL_VERIFIED_AT'])) {
        header('Location: /verifyEmail.php');
        exit();
    } else {
        $shops = $_SESSION['user']['cart'] ?? [];
    }
    ?>


    <section class="container-fluid p-5">
        <div class="row">

            <!--CART FLEX 1/2-->
            <form action="cart/deleteItem.php" method="POST" class="col-md-8 col-12">

                <!--flex cart title-->
                <div class="card-bg d-flex justify-content-between">

                    <!--flex 1 of flex cart title for selector -->
                    <div>
                        <input type="checkbox" id="select-all">
                        <label for="select-all"> Select All (<?= $cartSize ?> items) </label>
                    </div>

                    <!--flex 2 of cart title for delete -->
                    <div>
                        <button class="dlt-btn"><i class="far fa-trash-alt"></i>Delete</button>
                    </div>
                </div>

                <?php
                $price = 0.0;
                foreach ($shops as $shop_id => $shop) {
                ?>
                    <!--Cart 1-->
                    <div class="cart-product">
                        <input type="checkbox" class="shop-checkbox" id="shop-<?= $shop_id ?>">
                        <label for="shop-<?= $shop_id ?>"> <?= $shop['shop_name'] ?></label>
                        <div class="shop-products">
                            <?php
                            foreach ($shop['products'] as $product_id => $product) {
                                $price += $product['discounted_price'] * $product['quantity'];
                            ?>
                                <!--PRODUCT FLEX-->
                                <div class="product-flex row p-2">

                                    <!--PRODUCT FLEX 1-->
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div>
                                            <input type="checkbox" class="product-checkbox" id="product-<?= $product_id ?>" name="product[]" value="<?= $product_id ?>">
                                        </div>

                                        <!--product image-->
                                        <div class="product-img">
                                            <img src="<?= $product['image'] ?>">
                                        </div>

                                        <!--product description-->
                                        <div class="product-description d-flex flex-column align-items-center">
                                            <h5><a href="/product.php?id=<?= $product_id ?>"><?= $product['product_name'] ?></a></h5>
                                            <p><?= $product['stock'] ?> in stock</p>
                                        </div>

                                    </div>

                                    <!--PRODUCT FLEX 2-->
                                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                                        <div>
                                            <h4 style="color:#F1592A">£ <?= number_format((float)$product['discounted_price'], 2, '.', '') ?></h4>
                                            <span style="text-decoration: line-through;">£ <?= number_format((float)$product['price'], 2, '.', '') ?></span>
                                            <span> - <?= $product['discount_rate'] ?>%</span>
                                        </div>
                                    </div>

                                    <!--PRODUCT FLEX 3-->
                                    <div class="col-md-3 d-flex justify-content-end align-items-center">
                                        <div>
                                            <button class="value-button" onclick="decreaseValue(<?= $product_id ?>)">-</button>
                                            <input type="number" class="number-count" data-product="<?= $product_id ?>" data-old-value="<?= $product['quantity'] ?>" data-stock="<?= $product['stock'] ?>" id="number-<?= $product_id ?>" value="<?= $product['quantity'] ?>" />
                                            <button class="value-button" onclick="increaseValue(<?= $product_id ?>, <?= $product['stock'] ?>)">+</button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </form>




            <!--CART FLEX 2/2-->
            <div class="col-md-4 text-center">
                <div class="card-bg p-5">
                    <!--flex for subtotal item and amount -->
                    <div class="d-flex justify-content-between">

                        <!--flex for subtotal item -->
                        <div class="items">
                            <p style="display:inline" class="subtotal">Subtotal (<span class="quantity-total"><?= $cartSize ?></span> items) </p>
                        </div>

                        <!--flex for subtotal amount -->
                        <div class="amt">
                            <p style="display:inline;">£ <span class="subtotal-amt"><?= number_format((float)$price, 2, '.', '') ?></span></p>
                        </div>
                    </div>

                    <form action="checkout.php" class="voucher-form">
                        <input type="text" id="voucher" name="voucher" placeholder="Enter voucher code">
                        <input type="hidden" id="voucherDiscount" disabled value="0">
                        <button onclick="applyVoucher()" class="apply">Apply</button>

                        <!--flex for total items and amount -->
                        <div class="d-flex justify-content-between">

                            <!--flex for total item -->
                            <div class="total-items">
                                <p>Total</p>
                            </div>

                            <!--flex for total amount -->
                            <div class="total-amt">
                                <p style="color:#F1592A;">£ <span class="final-total"><?= number_format((float)$price, 2, '.', '') ?></span></p>
                            </div>
                        </div>

                        <button class="loadmore" type="submit">Proceed to checkout</button>
                    </form>
                </div>
            </div>


        </div>
    </section>



    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/adminlte/jquery.min.js"></script>


    <!--product quantity script-->
    <script>
        function increaseValue(i, stock) {
            event.preventDefault();
            var value = parseInt(document.getElementById('number-' + i).value, 10);
            value = isNaN(value) ? 1 : value;
            if (value >= stock) {
                alert('Out of stock');
            } else {
                value++;
                updateCart(i, value, $('#number-' + i));
            }
        }
        $('input[id^="number"]').on("keydown", function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                $(this).blur();
            }
        });

        $('input[id^="number"]').change(function() {
            event.preventDefault();
            var old = $(this).data('oldValue');
            var product = $(this).data('product');
            var stock = $(this).data('stock');
            if ($(this).val() <= 0) {
                alert('Quantity cannot be 0');
                $(this).val(old);
            } else if ($(this).val() > stock) {
                alert('Out of stock');
                $(this).val(old);
            } else {
                updateCart(product, $(this).val(), $(this));
            }
        });

        function decreaseValue(i) {
            event.preventDefault();
            var value = parseInt(document.getElementById('number-' + i).value, 10);
            value = isNaN(value) ? 1 : value;
            value < 2 ? value = 2 : '';
            value--;
            updateCart(i, value, $('#number-' + i));
        }
    </script>

    <!--select all checkbox script-->
    <script>
        $(document).ready(function() {
            $("#select-all").change(function() {
                var val = this.checked;
                $(".shop-checkbox").each(function() {
                    this.checked = val;
                });
                $(".product-checkbox").each(function() {
                    this.checked = val;
                });
            });

            $(".shop-checkbox").change(function() {
                var val = this.checked;
                $(this).siblings('.shop-products').find('.product-checkbox').each(function() {
                    this.checked = val;
                });
                if ($(this).is(":checked")) {
                    var unChecked = 0;
                    $(".shop-checkbox").each(function() {
                        if (!this.checked)
                            unChecked = 1;
                    })
                    if (unChecked == 0) {
                        $("#select-all").prop("checked", true);
                    }
                } else {
                    $("#select-all").prop("checked", false);
                }
            });
            $(".product-checkbox").change(function() {
                if ($(this).is(":checked")) {
                    var unChecked = 0;
                    $(this).parents('.shop-products').find(".product-checkbox").each(function() {
                        if (!this.checked)
                            unChecked = 1;
                    })
                    if (unChecked == 0) {
                        $(this).parents('.shop-products').siblings('.shop-checkbox').prop("checked", true);
                        $(".shop-checkbox").each(function() {
                            if (!this.checked)
                                unChecked = 1;
                        })
                        if (unChecked == 0) {
                            $("#select-all").prop("checked", true);
                        }
                    }
                } else {
                    $(this).parents('.shop-products').siblings('.shop-checkbox').prop("checked", false);
                    $("#select-all").prop("checked", false);
                }
            });
        });

        function showPreloader() {
            preloader = $('.preloader');
            preloader.css('height', '100vh');
            preloader.children().show();
        };

        function hidePreloader() {
            preloader = $('.preloader');
            preloader.css('height', '0');
            setTimeout(function() {
                preloader.children().hide();
            }, 200);
        };
    </script>

    <!-- Update cart script -->
    <script>
        function updateCart(product, quantity, $obj = null) {
            showPreloader();
            $.post('cart/updateItem.php', {
                    'product': product,
                    'quantity': quantity
                },
                function(data) {
                    response = JSON.parse(data);
                    setTimeout(function() {
                        hidePreloader()
                        if (response['status'] == 'success') {
                            total = response['totalPrice'];
                            $('.subtotal-amt').text(total);
                            $('.final-total').text(total - parseFloat($('#voucherDiscount').val()));
                            if ($obj != null) {
                                $obj.data('oldValue', quantity);
                                $obj.val(quantity);
                            }
                        } else {
                            alert(response['message']);
                        }
                    }, 400);
                });
        }
    </script>

    <!-- Apply Voucher Script -->
    <script>
        function applyVoucher() {
            showPreloader();
            event.preventDefault();
            $.post('cart/applyVoucher.php', {
                    'code': $('#voucher').val(),
                    'subtotal': $('.subtotal-amt').text()
                },
                function(data) {
                    response = JSON.parse(data);
                    setTimeout(function() {
                        hidePreloader()
                        if (response['status'] == 'success') {
                            $('#voucherDiscount').val(response['amount']);
                            $('.final-total').text(($('.subtotal-amt').text() - parseFloat($('#voucherDiscount').val())).toFixed(2));
                        } else {
                            alert(response['message']);
                        }
                    }, 400);
                });
        }
    </script>
</body>

</html>