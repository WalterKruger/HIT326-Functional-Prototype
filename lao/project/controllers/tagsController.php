<?php
    session_start();

    require_once '../models/Tags.php';
    $model = new Tags();

    // POST request
    if (isset($_GET['tag_id'])) {

        $model->removeTagFromArticle((int)$_GET["article_id"], (int)$_GET["tag_id"]);

        header("Location: /lao/project/views/articles.php");
        die();
    }

    $tagToDisplay = $model->getTags($article['id']);
    
?>