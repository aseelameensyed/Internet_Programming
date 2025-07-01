<?php
$host = "localhost";
$db = "bus_booking";
$user = "root";
$pass = "";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$from = $_POST['from'];
$to = $_POST['to'];
$date = $_POST['date'];
$bus = $_POST['bus'];
$start = $_POST['start'];
$end = $_POST['end'];
$seats = $_POST['seats'];
$total = $_POST['total'];

// Insert into DB
$sql = "INSERT INTO bookings (name, age, gender, phone, from_city, to_city, travel_date, bus_name, start_time, end_time, seats, total_fare)
VALUES ('$name', $age, '$gender', '$phone', '$from', '$to', '$date', '$bus', '$start', '$end', '$seats', $total)";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}
$conn->close();
?>