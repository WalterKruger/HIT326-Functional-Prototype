<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'editor') {
    header('Location: /lao/project/views/login.php');
    exit;
}

require_once '../models/Article.php';
$articleModel = new Article();
$pendingArticles = $articleModel->fetchPendingArticles(); // Make sure this function is properly defined in your Article model

include 'partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Articles</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<?php include 'partials/header.php'; ?>
<div class="container">
    <h1>Review Articles</h1>
    <?php foreach ($pendingArticles as $article): ?>
        <div class="article">
            <h2><?= htmlspecialchars($article['title']); ?></h2>
            <p><?= nl2br(htmlspecialchars($article['text_content'])); ?></p>
            <?php if (!empty($article['image_path'])): ?>
                <img src="<?= htmlspecialchars($article['image_path']); ?>" alt="Article Image" style="max-width:100%;height:auto;">
            <?php endif; ?>
            <a href="/lao/project/controllers/manage_article.php?action=approve&id=<?= $article['id']; ?>">Approve</a> |
            <a href="/lao/project/controllers/manage_article.php?action=reject&id=<?= $article['id']; ?>">Reject</a>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>

