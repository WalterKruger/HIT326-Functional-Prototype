<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Application</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<header>
    <div class="navbar">
        <div class="brand">My Application</div>
        <nav>
            <a href="/lao/project/views/home.php">Home</a>
            <a href="/lao/project/views/articles.php">Articles</a>
            <a href="/lao/project/views/top.php">Top</a>

            <?php if (isset($_SESSION["user_id"])): ?>
                <a href="/lao/project/views/profile.php">My Profile</a>
                <a href="/lao/project/views/logout.php">Logout</a>
            <?php else: ?>
                <a href="/lao/project/views/login.php">Login</a>
                <a href="/lao/project/views/signup.php">Signup</a>
            <?php endif; ?>

        </nav>
    </div>
</header>
<div class="main-container">
<br><br><br>
