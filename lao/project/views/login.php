<!-- Has to be at top as it starts a new session -->
<?php require_once '../controllers/LoginController.php'; ?>

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
