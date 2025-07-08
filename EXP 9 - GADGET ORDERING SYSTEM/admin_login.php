<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'aseel123' && $password === 'aseel1') {
        $_SESSION['admin'] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            background: #f0f0f0;
            text-align: center;
            padding-top: 100px;
        }
        form {
            display: inline-block;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        input {
            margin: 10px;
            padding: 10px;
            width: 220px;
        }
        button {
            padding: 10px 20px;
            background: black;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Admin Login</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <input type="text" name="username" placeholder="Admin ID" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

</body>
</html>