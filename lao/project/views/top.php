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

            if (!empty($topArticles)):
                foreach ($topArticles as $article): ?>
                    <div class="article">
                        <h2><?= htmlspecialchars($article['title']); ?></h2>
                        <p><?= nl2br(htmlspecialchars($article['text_content'] ?? 'No content available')); ?></p>
                        <p>Posted on: <?= htmlspecialchars(date('Y-m-d', strtotime($article['creation_date'] ?? ''))); ?></p>
                        <p>Last updated: <?= htmlspecialchars(date('Y-m-d', strtotime($article['modification_date'] ?? ''))); ?></p>
                        <?php if (!empty($article['image_path'])): ?>
                            <img src="<?= htmlspecialchars($article['image_path']); ?>" alt="Article Image" style="max-width:100%;height:auto;">
                        <?php endif; ?>
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
                <?php endforeach;
            else: ?>
                <p>No articles found.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
