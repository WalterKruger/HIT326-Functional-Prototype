<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit;
}

$conn = Database::getInstance()->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<?php include '../views/partials/header.php'; ?>

<div class="container">
    <h1>Dashboard</h1>
    <?php if ($_SESSION['role'] === 'author'): ?>
        <p>Welcome, Author! You can manage your articles here.</p>
        <a href="/lao/project/views/editor.php" class="button">Add New Article</a>
        <div class="articles-container">
            <h2>Your Articles</h2>
            <?php
            $stmt = $conn->prepare("SELECT * FROM articles WHERE author_id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0): 
                while ($article = $result->fetch_assoc()): ?>
                    <div class="article">
                        <h3><?= htmlspecialchars($article['title']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
                        <a href="/lao/project/views/edit_article.php?id=<?= $article['id']; ?>" class="button">Edit</a>
                        <a href="/lao/project/controllers/delete_article.php?id=<?= $article['id']; ?>" class="button" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                <?php endwhile; 
            else: ?>
                <p>No articles found.</p>
            <?php endif;
            $stmt->close();
            ?>
        </div>
    <?php else: ?>
        <p>Welcome, Visitor! Enjoy reading the articles.</p>
        <div class="articles-container">
            <h2>All Articles</h2>
            <?php
            $stmt = $conn->prepare("SELECT * FROM articles");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0): 
                while ($article = $result->fetch_assoc()): ?>
                    <div class="article">
                        <h3><?= htmlspecialchars($article['title']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
                    </div>
                <?php endwhile; 
            else: ?>
                <p>No articles found.</p>
            <?php endif;
            $stmt->close();
            ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../views/partials/footer.php'; ?>
</body>
</html>
