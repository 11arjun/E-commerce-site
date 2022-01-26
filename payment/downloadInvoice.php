<?php
require_once '../utils/database.php';
require_once '../utils/sessionManager.php';
require_once 'invoice.php';

if (!isset($_POST['order_id'])) {
    header('Location: /');
    exit();
} else {
    $user_id = $_SESSION['user']['USER_ID'];
    $order_id = $_POST['order_id'];
}
$sql = "SELECT * FROM ORDERS INNER JOIN SLOTS USING (SLOT_ID) INNER JOIN USERS USING (USER_ID) WHERE ORDER_ID = '$order_id'";
$order = fetch_row($sql);
if ($order['USER_ID'] != $user_id) {
    header('Location: /');
    exit();
} else {
    $products = fetch_all_row("SELECT * FROM ORDER_PRODUCT INNER JOIN PRODUCTS USING (PRODUCT_ID) WHERE ORDER_ID = '$order_id'");
    $payment = fetch_row("SELECT * FROM PAYMENTS WHERE ORDER_ID = '$order_id'");
}
$pdf = new Invoice('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->addCompany(
    "Online Appetite",
    "Pepsicola, Kathmandu\n" .
        "44600, Nepal\n" .
        "Tel: +977-9803286585\n" .
        "info@onlineappetite.com"
);
if ($payment['PAYMENT_METHOD'] == 'cash') {
    $pdf->watermark("Invoice Pending");
}
$pdf->SetTitle('Payment Invoice');
$pdf->Image('../assets/images/logosmall.png', 10, 17, null, 20);
$pdf->addDate(date('d/m/Y'));
$pdf->addClient("CL" . $order['USER_ID']);
$pdf->addPageNumber("1");
$pdf->addClientAddress(
    $order['FULL_NAME'],
    $order['STREET'] . "\n" .
        $order['CITY'] . ", " . $order['STATE'] . "\n" .
        $order['POSTAL'] . ", " . $order['COUNTRY'] . "\n" .
        $order['EMAIL'] . "\n"
);
$pdf->addPaymentMode(ucwords($payment['PAYMENT_METHOD']));
$pdf->addInvoiceDate(date('d/m/Y', strtotime($order['ORDER_DATE'])));
$pdf->addTxnID($payment['TXN_ID'] ?? $payment['PAYMENT_ID']);
$cols = array(
    "REFERENCE"    => 23,
    "PRODUCT"  => 56,
    "QUANTITY"     => 22,
    "RATE"     => 22,
    "DISCOUNT" => 26,
    "PRICE"      => 26,
    "TOTAL"          => 15
);
$pdf->addCols($cols);
$cols = array(
    "REFERENCE"    => "L",
    "PRODUCT"  => "L",
    "RATE"  => "C",
    "QUANTITY"     => "C",
    "DISCOUNT" => "R",
    "PRICE"      => "R",
    "TOTAL"          => "R"
);
$pdf->addLineFormat($cols);

$y    = 110;
$subtotal = 0;
foreach ($products as $i => $product) {
    $discount = $product['SITE_DISCOUNT'] + $product['PRODUCT_DISCOUNT'];
    $price = $product['PRICE'] - $discount;
    $total = $price * $product['QUANTITY'];
    $subtotal += $total;
    $voucher_discount = $order['VOUCHER_DISCOUNT'];
    $final_amount = $order['AMOUNT'];
    $line = array(
        "REFERENCE"    => "REF" . ($i + 1),
        "PRODUCT"  => $product['PRODUCT_NAME'],
        "QUANTITY"     => $product['QUANTITY'],
        "RATE"      => number_format($product['PRICE'] / 100, 2, '.', ''),
        "DISCOUNT" => number_format($discount / 100, 2, '.', ''),
        "PRICE"      => number_format($price / 100, 2, '.', ''),
        "TOTAL"          => number_format($total / 100, 2, '.', ''),
    );
    $size = $pdf->addLine($y, $line);
    $y   += $size + 3;
}
$pdf->SetXY(133, 247);
$pdf->Cell(26, 6, 'Subtotal', 1, 0);
$pdf->Cell(41, 6, number_format($subtotal / 100, 2, '.', ''), 1, 1, 'R');
$pdf->SetXY(133, 253);
$pdf->Cell(26, 6, 'Voucher Dis.', 1, 0);
$pdf->Cell(41, 6, number_format($voucher_discount / 100, 2, '.', ''), 1, 1, 'R');
$pdf->SetXY(133, 259);
$pdf->Cell(26, 6, 'Total', 1, 0);
$pdf->Cell(41, 6, number_format($final_amount/100, 2, '.', ''), 1, 1, 'R');
$pdf->Output('I','invoice.pdf');
