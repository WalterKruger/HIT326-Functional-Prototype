<?php
session_start();
require_once '../models/Article.php';

if (isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['journalist', 'editor'])) {
    if (isset($_GET['comment_id'])) {
        $articleModel = new Article();
        $commentId = $_GET['comment_id'];

        try {
            $articleModel->deleteComment($commentId);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (Exception $e) {
            // Error handling, could log or display a message depending on setup
            die("Error deleting comment: " . $e->getMessage());
        }
    }
}
?>
