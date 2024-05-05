<?php
include_once '../models/Article.php';


class ArticleController {
    public function index() {
        $articleModel = new Article();
        $articles = $articleModel->fetchAll();
        include 'views/articles.php';
    }
}
