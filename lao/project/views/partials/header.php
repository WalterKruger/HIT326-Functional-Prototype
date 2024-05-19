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
            <a href="/lao/project/views/profile.php">My Profile</a>
            <a href="/lao/project/views/logout.php">Logout</a>
        </nav>
    </div>
</header>
<div class="main-container">
