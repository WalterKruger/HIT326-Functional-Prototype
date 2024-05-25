<?php
session_start();
require_once '../models/Article.php';
require_once '../models/Author.php';

$authorModel = new Author();
$articleModel = new Article();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    // Check if the author exists for the given user
    if (!$authorModel->authorExists($author_id)) {
        echo "No author found with ID: " . $author_id;
        exit;
    }

    // Handle file upload
    $imagePath = null;
    $target_dir = "../uploads/";
    // Create directory if it does not exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    if (!empty($_FILES['image']['name'])) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        } else {
            echo "Error uploading file.";
            exit;
        }
    }

    try {
        if ($articleModel->uploadArticle($title, $content, $imagePath, $author_id)) {
            header('Location: /lao/project/views/articles.php'); // Redirect to articles page
            exit;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Display errors related to article upload
    }
}
?>
