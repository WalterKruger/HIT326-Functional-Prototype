<?php
// Logic for handling password reset can be implemented here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/lao/project/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Forgot Password</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit">Reset Password</button>
    </form>
    <a href="/lao/project/views/login.php">Login</a> | 
    <a href="/lao/project/views/signup.php">Sign Up</a>
</div>
</body>
</html>
