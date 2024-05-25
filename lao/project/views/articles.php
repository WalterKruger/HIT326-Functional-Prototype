<?php
require_once '../models/Article.php';
$articleModel = new Article();
$articles = $articleModel->fetchAllApproved();

include 'partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Articles</h1>
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?= htmlspecialchars($article['title']); ?></h2>
                <p><?= nl2br(htmlspecialchars($article['text_content'])); ?></p>
                <?php if (!empty($article['image_path'])): ?>
                    <img src="<?= $article['image_path']; ?>" alt="Article Image" style="max-width:100%;height:auto;">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php if (empty($articles)) echo '<p>No articles found.</p>'; ?>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>