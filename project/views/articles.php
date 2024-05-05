<?php
require_once 'C:/xampp/htdocs/lao/project/models/Article.php';

$articleModel = new Article();
$articles = $articleModel->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/styles.css"> <!-- Ensure this is a valid path -->
</head>
<body>
    <div class="articles-container">
        <h1>Articles</h1>
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?= htmlspecialchars($article['title']); ?></h2>
                <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
