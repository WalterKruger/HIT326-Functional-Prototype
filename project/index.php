<?php
require 'config/db.php';
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        require 'controllers/LoginController.php';
        $controller = new LoginController();
        $controller->login();
        break;
    case 'register':
        require 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
    case 'articles':
        require 'controllers/ArticleController.php';
        $controller = new ArticleController();
        $controller->showArticles();
        break;
    default:
        include 'views/home.php';
}
?>
