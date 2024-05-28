<script>
        function confirmSubmission(event) {
            if (!confirm("Are you sure you want to remove this tag?")) {
                event.preventDefault();
            }
}
</script>

<form class="tag" action="/lao/project/controllers/tagsController.php" method="GET" onsubmit="confirmSubmission(event)">
    <?php 
        require '../controllers/tagsController.php';
        foreach ($tagToDisplay as $tag):
    ?>
        <span class="tag">
        
        <label for="html">
            <?php echo htmlspecialchars($tag['name']);?>
        </label>

        <?php if (isset($_SESSION["user_type"]) ? $_SESSION["user_type"] == "editor" : false):?>
            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">
            <button type="submit" name="tag_id" value="<?php echo htmlspecialchars($tag['id']); ?>">X</button>
        <?php endif;?>

        </span>
    <?php endforeach; ?>
</form>
<br>
