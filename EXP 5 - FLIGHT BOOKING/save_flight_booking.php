<?php
$host = "localhost";
$db = "flight_booking";
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
$flight = $_POST['flight'];
$depart = $_POST['depart'];
$arrive = $_POST['arrive'];
$count = $_POST['count'];
$total = $_POST['total'];

$sql = "INSERT INTO bookings (name, age, gender, phone, from_city, to_city, flight_date, flight_name, depart_time, arrive_time, passengers, total_fare)
VALUES ('$name', $age, '$gender', '$phone', '$from', '$to', '$date', '$flight', '$depart', '$arrive', $count, $total)";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}
$conn->close();
?>
