<?php
require_once '../models/Article.php';

class ArticleController {
    public function showArticles() {
        $articleModel = new Article();
        $articles = $articleModel->fetchAll();
        require '../views/articles.php';
    }
}
?>
