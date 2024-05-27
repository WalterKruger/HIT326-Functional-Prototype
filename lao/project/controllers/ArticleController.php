<?php
require_once '../models/Article.php';

$articleModel = new Article();
$articles = $articleModel->fetchAllSorted();

include '../views/articles.php'; // Include the view file
?>
