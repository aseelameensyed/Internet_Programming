<?php
session_start();
include 'db_connect.php';

// Add Product
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $conn->query("INSERT INTO gadgets (name, price, image) VALUES ('$name', '$price', '$image')");
    header("Location: admin_panel.php");
    exit();
}

// Delete Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM gadgets WHERE id=$id");
    header("Location: admin_panel.php");
    exit();
}

// Logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}
?>