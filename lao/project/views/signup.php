<?php require_once '../controllers/SignUpController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/lao/project/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Sign Up</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Sign Up</button>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
    <a href="/lao/project/views/login.php">Login</a>
</div>
</body>
</html>
