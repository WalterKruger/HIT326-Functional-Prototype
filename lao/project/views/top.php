<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Articles</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Top Articles</h1>
        <div class="articles-list">
            <?php 
            require_once '../models/Article.php';
            $articleModel = new Article();
            $topArticles = $articleModel->fetchTopArticles();  // Fetch top articles

            foreach ($topArticles as $article): ?>
                <div class="article">
                    <h2><?= htmlspecialchars($article['title']); ?></h2>
                    <p><?= nl2br(htmlspecialchars($article['text_content'])); ?></p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($topArticles)) echo '<p>No articles found.</p>'; ?>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
