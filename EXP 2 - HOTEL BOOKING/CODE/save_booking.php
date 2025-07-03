<?php
// Database config
$host = "localhost";
$user = "root";
$password = ""; // default for XAMPP
$database = "hotel_reservation";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST values
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hotel = $_POST['hotel'];
$room = $_POST['room'];

// Prepare and insert into bookings table
$sql = "INSERT INTO bookings (name, email, phone, hotel, room_type)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $phone, $hotel, $room);

if ($stmt->execute()) {
    echo "success"; // IMPORTANT: Must return this
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>