<?php if (isset($_SESSION["user_type"]) ? $_SESSION["user_type"] == "editor" : false):?>
    
    <?php require '../controllers/addTagsController.php'; ?>

    <form action="/lao/project/controllers/addTagsController.php" method="GET">
        <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">

        <?php foreach ($tagsToAddOption as $tag):?>
            <input type="radio" required id="<?php echo $article['id']."_".$tag['id'];?>" name="tagToAdd" value="<?php echo $tag['id'];?>">
            <label for="<?php echo $article['id']."_".$tag['id'];?>"> <?php echo $tag['name'];?> </label>

        <?php endforeach; ?>

        <?php if (count($tagsToAddOption) != 0):?>
        <button type="submit">Confirm</button>
        <?php endif;?>
    </form>

<?php endif;?>