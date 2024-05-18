<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div>My Application</div>
    <nav>
        <a href="/lao/project/views/home.php">Home</a>
        <a href="/lao/project/views/articles.php">Articles</a>
        <a href="/lao/project/views/top.php">Top</a>
        <a href="/lao/project/views/profile.php">My Profile</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/lao/project/controllers/LogoutController.php">Logout</a>
        <?php endif; ?>
    </nav>
</header>
