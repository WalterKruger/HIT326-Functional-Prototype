<?php
require 'config/db.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        require 'views/login.php';
        break;
    case 'signup':
        require 'views/signup.php';
        break;
    case 'articles':
        require 'controllers/ArticleController.php';
        $controller = new ArticleController();
        $controller->index();
        break;
    case 'dashboard':
        require 'views/dashboard.php';
        break;
    default:
        require 'views/home.php';
        break;
}
?>
