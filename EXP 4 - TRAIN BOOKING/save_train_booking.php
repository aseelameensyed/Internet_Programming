<?php
$host = "localhost";
$db = "train_booking";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$from = $_POST['from'];
$to = $_POST['to'];
$date = $_POST['date'];
$train = $_POST['train'];
$start = $_POST['start'];
$end = $_POST['end'];
$seats = $_POST['seats'];
$total = $_POST['total'];

$sql = "INSERT INTO bookings (name, age, gender, phone, from_station, to_station, travel_date, train_name, start_time, end_time, seats, total_fare)
VALUES ('$name', $age, '$gender', '$phone', '$from', '$to', '$date', '$train', '$start', '$end', '$seats', $total)";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}
$conn->close();
?>