<?php
session_start();

// Save posted items into session once
if (isset($_POST['items']) && !empty($_POST['items'])) {
    $_SESSION['cart_items'] = $_POST['items'];
    $items = $_POST['items'];
} elseif (isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])) {
    $items = $_SESSION['cart_items'];
} else {
    echo "<h2 style='font-family:Arial;color:red;'>Missing product information. Please go back and add items to cart.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Order - Apple</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            background: #f5f5f7;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .summary {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        .summary h3 {
            margin-top: 0;
        }
        .item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-right: 15px;
        }
        .form input, .form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .form button {
            padding: 12px;
            width: 100%;
            background: #000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h2>Confirm Your Order</h2>
<div class="summary">
    <h3>Items in Cart:</h3>
    <?php
    $total = 0;
    foreach ($items as $item) {
        $name = htmlspecialchars($item['name']);
        $qty = (int)$item['qty'];
        $price = (float)$item['price'];
        $image = htmlspecialchars($item['image']);
        $subtotal = $qty * $price;
        $total += $subtotal;
        echo "<div class='item'>
                <img src='$image'>
                <div><b>$name</b><br>₹$price × $qty = ₹" . number_format($subtotal) . "</div>
              </div>";
    }
    echo "<p><strong>Total: ₹" . number_format($total) . "</strong></p>";
    ?>

    <form class="form" action="process_order.php" method="post">
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <input type="text" name="customer_phone" placeholder="Phone Number" required>
        <textarea name="customer_address" placeholder="Address" required></textarea>

        <?php
        foreach ($items as $index => $item) {
            echo "<input type='hidden' name='items[$index][id]' value='".htmlspecialchars($item['id'])."'>";
            echo "<input type='hidden' name='items[$index][name]' value='".htmlspecialchars($item['name'])."'>";
            echo "<input type='hidden' name='items[$index][price]' value='".htmlspecialchars($item['price'])."'>";
            echo "<input type='hidden' name='items[$index][qty]' value='".htmlspecialchars($item['qty'])."'>";
            echo "<input type='hidden' name='items[$index][image]' value='".htmlspecialchars($item['image'])."'>";
        }
        ?>
        <button type="submit">Place Order</button>
    </form>
</div>

</body>
</html>