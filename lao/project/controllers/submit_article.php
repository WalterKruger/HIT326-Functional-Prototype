<?php
session_start();

require_once '../models/Article.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role'] === 'moderator') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id']; // Ensure the user ID is stored in session upon login

    $model = new Article();

    if ($model->uploadArticle($title, $content, $author_id)) {
        echo "Article added successfully!";
        //header('Location: view_articles.php'); // Redirect to view articles page or wherever appropriate
    } else {
        echo "Error: " . $stmt->error;
    }
    
}
else {
    header('Location: ../views/home.php'); // Redirect if not a POST request or not a moderator
}
?>
