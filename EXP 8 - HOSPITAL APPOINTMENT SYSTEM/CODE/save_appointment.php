<?php
include 'db.php';

$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$department = $_POST['department'];
$doctor = $_POST['doctor'];
$date = $_POST['date'];
$slot = $_POST['slot'];

$sql = "INSERT INTO appointments (name, age, gender, department, doctor, date, slot)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssss", $name, $age, $gender, $department, $doctor, $date, $slot);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "error";
}

$conn->close();
?>