<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM gadgets WHERE id=$id");
    header("Location: admin_panel.php");
    exit();
}

// Handle add/edit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $conn->query("UPDATE gadgets SET name='$name', price=$price, image='$image' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO gadgets (name, price, image) VALUES ('$name', $price, '$image')");
    }

    header("Location: admin_panel.php");
    exit();
}

// Fetch all products
$products = $conn->query("SELECT * FROM gadgets");
$editing = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $editing = $conn->query("SELECT * FROM gadgets WHERE id=$edit_id")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }
        form {
            max-width: 500px;
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        input {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
        button {
            padding: 10px 16px;
            background: black;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        a.btn {
            background: red;
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .return-btn {
            margin-bottom: 20px;
            display: inline-block;
            background: green;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Admin Panel</h2>
<a class="return-btn" href="home_page.php">⬅ Return to Home Page</a>

<form method="post">
    <h3><?= $editing ? "Edit Product" : "Add New Product" ?></h3>
    <input type="text" name="name" placeholder="Product Name" value="<?= $editing['name'] ?? '' ?>" required>
    <input type="number" name="price" placeholder="Price" value="<?= $editing['price'] ?? '' ?>" required>
    <input type="text" name="image" placeholder="Image URL" value="<?= $editing['image'] ?? '' ?>" required>
    <?php if ($editing): ?>
        <input type="hidden" name="edit_id" value="<?= $editing['id'] ?>">
    <?php endif; ?>
    <button type="submit"><?= $editing ? "Update" : "Add" ?></button>
</form>

<table>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price (₹)</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
            <td><img src="<?= $row['image'] ?>" width="50"></td>
            <td><?= $row['name'] ?></td>
            <td><?= number_format($row['price']) ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>" class="btn">Edit</a>
                <a href="?delete=<?= $row['id'] ?>" class="btn" onclick="return confirm('Delete this item?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>