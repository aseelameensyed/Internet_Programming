<?php
$host = "localhost";
$db = "cake_shop";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$cake = $_POST['cake_type'];
$size = $_POST['size'];
$address = $_POST['address'];
$date = $_POST['delivery_date'];

$sql = "INSERT INTO orders (name, phone, cake_type, size, address, delivery_date)
VALUES ('$name', '$phone', '$cake', '$size', '$address', '$date')";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
