<?php
session_start();
require_once '../models/Article.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articleModel = new Article();
    $articleId = $_POST['article_id'];
    $userId = $_SESSION['user_id'];
    $commentText = $_POST['comment_text'];

    try {
        $articleModel->addComment($articleId, $userId, $commentText);
        header("Location: /lao/project/views/articles.php");
        exit;
    } catch (Exception $e) {
        // Error handling, could log or display a message depending on setup
        die("Error adding comment: " . $e->getMessage());
    }
}
