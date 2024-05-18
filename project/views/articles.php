<?php
require_once '../models/Article.php';

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
<?php include 'partials/header.php'; ?>
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
<?php include 'partials/footer.php'; ?>
</body>
</html>
