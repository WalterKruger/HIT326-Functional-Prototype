<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /lao/project/views/login.php');
    exit;
}
?>

<?php include 'partials/header.php'; ?>

<div class="container">
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard!</p>
    <p>Here you can find the latest articles and updates.</p>
    <?php
    require_once '../models/Article.php';
    $articleModel = new Article();
    $articles = $articleModel->fetchAll();
    if (!empty($articles)): ?>
        <div class="articles-list">
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <h2><?= htmlspecialchars($article['title']); ?></h2>
                    <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No articles found.</p>
    <?php endif; ?>
</div>

<?php include 'partials/footer.php'; ?>
