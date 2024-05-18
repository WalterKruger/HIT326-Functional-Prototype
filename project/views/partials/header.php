<?php session_start(); ?>
<header>
    <div>My Application</div>
    <nav>
        <a href="/lao/project/views/home.php">Home</a>
        <a href="/lao/project/views/articles.php">Articles</a>
        <a href="/lao/project/views/top.php">Top</a>
        <a href="/lao/project/views/profile.php">My Profile</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
            <a href="/lao/project/views/editor.php">Add Article</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/lao/project/controllers/LogoutController.php">Logout</a>
        <?php else: ?>
            <a href="/lao/project/views/login.php">Login</a>
            <a href="/lao/project/views/signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
