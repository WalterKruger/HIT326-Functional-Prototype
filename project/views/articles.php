<?php
session_start();
require_once '../config/db.php';
require_once '../models/Article.php'; // Make sure the Article class is included

$conn = Database::getInstance()->getConnection();

$articleModel = new Article();
$articles = $articleModel->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
    <?php include '../views/partials/header.php'; ?>
    <div class="container">
        <h1>Articles</h1>
        <?php if (!empty($articles)): ?>
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
    <?php include '../views/partials/footer.php'; ?>
</body>
</html>
