<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /lao/project/views/dashboard.php');
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../config/db.php';
    $conn = Database::getInstance()->getConnection(); // Get the database connection

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            header("Location: /lao/project/views/dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No such username.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/lao/project/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
    <a href="/lao/project/views/signup.php">Sign Up</a> | 
    <a href="/lao/project/views/forgot_password.php">Forgot Password?</a>
</div>
</body>
</html>
