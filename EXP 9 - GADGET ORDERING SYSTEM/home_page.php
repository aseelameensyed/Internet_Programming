<?php include 'db_connect.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Apple</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Helvetica">
    <style>
        body {
            margin: 0;
            font-family: Helvetica, sans-serif;
            background: #f5f5f7;
        }
        header {
            background: #000;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            display: flex;
            align-items: center;
            font-size: 24px;
        }
        header h1 img {
            height: 30px;
            margin-right: 10px;
        }
        .admin-btn {
            background: #444;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }
        .cart-icon {
            cursor: pointer;
        }
        .cart-icon img {
            height: 26px;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 40px;
        }
        .product-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .product-card img {
            height: 200px;
            object-fit: contain;
            margin-bottom: 15px;
            max-width: 100%;
        }
        .product-card h3 {
            margin: 10px 0;
        }
        .product-card p {
            font-weight: bold;
            color: #444;
        }
        .product-card button {
            background: #000;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }
        #cart {
            position: fixed;
            top: 0;
            right: -350px;
            width: 300px;
            height: 100%;
            background: white;
            box-shadow: -4px 0 8px rgba(0,0,0,0.2);
            padding: 20px;
            transition: 0.3s;
            z-index: 9999;
            overflow-y: auto;
        }
        #cart.open {
            right: 0;
        }
        #cart h2 {
            margin-top: 0;
        }
        #cart-box div {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        #cart-box img {
            height: 50px;
            width: 50px;
            margin-right: 10px;
            object-fit: contain;
        }
        #cart-box button {
            margin-left: 4px;
            padding: 4px 8px;
            background: #ddd;
            border: none;
            border-radius: 4px;
        }
        #cart button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <a href="admin_login.php" class="admin-btn">Admin Panel</a>
    <h1><img src="https://1000logos.net/wp-content/uploads/2017/02/Apple-Logosu.png" alt="Apple Logo">Apple</h1>
    <div class="cart-icon" onclick="toggleCart()">
        <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Cart">
    </div>
</header>

<div class="container">
<?php
$result = $conn->query("SELECT * FROM gadgets");
while ($row = $result->fetch_assoc()) {
    $id = htmlspecialchars($row['id']);
    $name = htmlspecialchars($row['name']);
    $price = (float)$row['price'];
    $image = htmlspecialchars($row['image']);

    echo "<div class='product-card'>
            <img src='$image' alt='Product'>
            <h3>$name</h3>
            <p>₹" . number_format($price) . "</p>
            <button onclick='addToCart(\"$id\", \"$name\", $price, \"$image\")'>Add to Cart</button>
          </div>";
}
?>
</div>

<!-- Cart Sidebar -->
<div id="cart">
    <h2>Your Cart</h2>
    <div id="cart-box"></div>
    <p id="cart-total" style="font-weight: bold;"></p>
    <button onclick="proceedOrder()">Proceed</button>
</div>

<script>
let cart = [];

function addToCart(id, name, price, image) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ id, name, price, image, qty: 1 });
    }
    renderCart();
    document.getElementById('cart').classList.add('open');
}

function renderCart() {
    const cartBox = document.getElementById("cart-box");
    cartBox.innerHTML = "";
    let total = 0;

    cart.forEach((item, i) => {
        total += item.qty * item.price;
        cartBox.innerHTML += `
        <div>
            <img src="${item.image}">
            <div style="flex:1;">
                <b>${item.name}</b><br>₹${item.price} × ${item.qty}
            </div>
            <button onclick="decreaseQty(${i})">−</button>
            <button onclick="increaseQty(${i})">+</button>
        </div>`;
    });

    document.getElementById("cart-total").innerText = "Total: ₹" + total;
}

function increaseQty(i) {
    cart[i].qty++;
    renderCart();
}

function decreaseQty(i) {
    cart[i].qty--;
    if (cart[i].qty <= 0) cart.splice(i, 1);
    renderCart();
}

function toggleCart() {
    document.getElementById("cart").classList.toggle("open");
}

function proceedOrder() {
    if (cart.length === 0) return alert("Cart is empty!");
    const form = document.createElement("form");
    form.method = "post";
    form.action = "confirm_order.php";
    cart.forEach((item, index) => {
        form.innerHTML += `<input type="hidden" name="items[${index}][id]" value="${item.id}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][name]" value="${item.name}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][price]" value="${item.price}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][qty]" value="${item.qty}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][image]" value="${item.image}">`;
    });
    document.body.appendChild(form);
    form.submit();
}
</script>

</body>
</html>