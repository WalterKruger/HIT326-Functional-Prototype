<?php
session_start();
require_once '../models/Article.php';
$articleModel = new Article();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'editor') {
    header('Location: /lao/project/views/login.php');
    exit;
}

// Check if the action and id are set
if (isset($_GET['action']) && isset($_GET['id'])) {
    $articleId = (int)$_GET['id'];
    if ($_GET['action'] == 'approve') {
        if ($articleModel->approveArticle($articleId)) {
            header('Location: /lao/project/views/articles.php'); // Redirect to articles page on success
        } else {
            echo "Error approving the article.";
        }
    } elseif ($_GET['action'] == 'reject') {
        if ($articleModel->rejectArticle($articleId)) {
            header('Location: /lao/project/views/review_articles.php'); // Stay on the review page or redirect as needed
        } else {
            echo "Error rejecting the article.";
        }
    }
    exit;
}
?>
