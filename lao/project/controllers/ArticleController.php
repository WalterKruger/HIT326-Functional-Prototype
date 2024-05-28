<?php
require_once '../models/Article.php';

$articleModel = new Article();
$articles = $articleModel->fetchTopArticles();

include '../views/articles.php'; // Include the view file
?>
