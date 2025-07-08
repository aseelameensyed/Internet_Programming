<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "beauty_parlor";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];
$notes = $_POST['notes'];

$sql = "INSERT INTO appointments (name, phone, email, service, date, time, notes)
        VALUES ('$name', '$phone', '$email', '$service', '$date', '$time', '$notes')";

if ($conn->query($sql) === TRUE) {
    header("Location: parlor_appointment.html?success=1");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>