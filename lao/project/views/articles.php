<?php
session_start();
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
                <p><?= nl2br(htmlspecialchars($article['text_content'] ?? 'No content available')); ?></p>
                <p>Posted on: <?= htmlspecialchars(date('Y-m-d', strtotime($article['creation_date']))); ?></p>
                <p>Last updated: <?= htmlspecialchars(date('Y-m-d', strtotime($article['modification_date']))); ?></p>
                <?php if (!empty($article['image_path'])): ?>
                    <img src="<?= htmlspecialchars($article['image_path']); ?>" alt="Article Image" style="max-width:100%;height:auto;">
                <?php endif; ?>
                
                <!-- List all tags -->
                <?php include 'partials/list_tags.php'?>

                <!-- Display comments section -->
                <?php
                $comments = $articleModel->fetchComments($article['id']);
                foreach ($comments as $comment) {
                    echo "<p><strong>" . htmlspecialchars($comment['user_name']) . ":</strong> " . htmlspecialchars($comment['text_contnet']) . "</p>";
                    if (isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['journalist', 'editor'])) {
                        echo '<a href="/lao/project/controllers/DeleteCommentController.php?comment_id=' . $comment['id'] . '" onclick="return confirm(\'Are you sure you want to delete this comment?\')">Delete</a>';
                    }
                }
                ?>
                <!-- Only show comment input if user is logged in -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="/lao/project/controllers/SubmitCommentController.php" method="post">
                        <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                        <textarea name="comment_text" required></textarea>
                        <button type="submit">Add Comment</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php if (empty($articles)) echo '<p>No articles found.</p>'; ?>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>
