<?php
    require_once '../models/Tags.php';
    $model = new Tags();

    // POST request
    if (isset($_GET["tagToAdd"])) {

        $model->addNewTag((int)$_GET["article_id"], (int)$_GET["tagToAdd"]);
        
        header("Location: /lao/project/views/articles.php");
        die();
    }

    $tagsToAddOption = $model->getUnsetTags($article['id']);

?>