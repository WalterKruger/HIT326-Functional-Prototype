<?php
    require_once '../models/Tags.php';
    $model = new Tags();

    // POST request
    /*if (isset($_GET["tagToAdd"])) {
        header("Location: /lao/project/views/articles.php");
        die();
    }*/

    $unSetTags = $model->getUnsetTags($article['id']);

?>