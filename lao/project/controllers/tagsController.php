<?php
    if (session_status() == PHP_SESSION_NONE) session_start();

    require_once '../models/Tags.php';
    $model = new Tags();

    // POST request
    if (isset($_GET['tag_id'])) {
        switch ($_GET['action']) {
            case 'delete':
                $model->removeTagFromArticle((int)$_GET["article_id"], (int)$_GET["tag_id"]);
                break;
            
            case 'upvote':
                $model->voteForTag((int)$_GET["article_id"], (int)$_GET["tag_id"], $_SESSION['user_id'], true);
                break;
            
            case 'downvote':
                $model->voteForTag((int)$_GET["article_id"], (int)$_GET["tag_id"], $_SESSION['user_id'], false);
                break;
        }

        

        header("Location: /lao/project/views/articles.php");
        die();
    }

    $tagToDisplay = $model->getTags($article['id'], isset($_SESSION['user_id'])? $_SESSION['user_id'] : null);
    
?>