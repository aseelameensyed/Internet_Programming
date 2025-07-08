<?php
include 'db_connect.php';
session_start();

// Validate input
if (
    empty($_POST['customer_name']) ||
    empty($_POST['customer_phone']) ||
    empty($_POST['customer_address']) ||
    empty($_POST['items'])
) {
    echo "<h2 style='font-family:Arial;color:red;'>All fields are required. Please go back and fill in the details.</h2>";
    exit;
}

$customer_name = $conn->real_escape_string($_POST['customer_name']);
$customer_phone = $conn->real_escape_string($_POST['customer_phone']);
$customer_address = $conn->real_escape_string($_POST['customer_address']);
$items = $_POST['items'];

// Prepare order summary
$summary = "";
$total = 0;
foreach ($items as $item) {
    $name = $conn->real_escape_string($item['name']);
    $qty = (int)$item['qty'];
    $price = (float)$item['price'];
    $image = $conn->real_escape_string($item['image']);

    $summary .= "$name × $qty @ ₹$price each\n";
    $total += $qty * $price;
}

// Save order to database
$stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, order_details, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssd", $customer_name, $customer_phone, $customer_address, $summary, $total);

if ($stmt->execute()) {
    // Success - clear session
    unset($_SESSION['cart_items']);
} else {
    echo "<h2 style='font-family:Arial;color:red;'>Failed to place order. Please try again later.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Placed - Apple</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            background: #f5f5f7;
            padding: 20px;
        }
        .box {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: green;
        }
        .item {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .item img {
            height: 60px;
            width: 60px;
            margin-right: 15px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Thank You! Your Order Has Been Placed.</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($customer_name) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($customer_phone) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($customer_address) ?></p>
    <h3>Order Summary:</h3>

    <?php
    foreach ($items as $item) {
        $img = htmlspecialchars($item['image']);
        $name = htmlspecialchars($item['name']);
        $qty = (int)$item['qty'];
        $price = (float)$item['price'];
        $subtotal = $qty * $price;

        echo "<div class='item'>
                <img src='$img'>
                <div>
                    <b>$name</b><br>
                    ₹$price × $qty = ₹" . number_format($subtotal) . "
                </div>
              </div>";
    }
    ?>
    <p><strong>Total: ₹<?= number_format($total) ?></strong></p>
</div>

</body>
</html>