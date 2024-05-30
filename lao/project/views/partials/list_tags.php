<script>
        function confirmSubmission(event) {
            if (!confirm("Are you sure you want to remove this tag?")) {
                event.preventDefault();
            }
}
</script>

<?php require '../controllers/tagsController.php'; ?>

<div class="tags-container">
<?php foreach ($tagToDisplay as $tag):?>
    <form action="/lao/project/controllers/tagsController.php" method="GET">
    <span class="tag-container">
        <label for="html">
            <?php echo htmlspecialchars($tag['name']); ?>
        </label>


        <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">
        <input type="hidden" name="tag_id" value="<?php echo htmlspecialchars($tag['id']); ?>">


        <?php if (isset($_SESSION["user_id"])):?>
            <div class="vote-buttons">
                <button 
                    <?php if ($tag['vote'] == 1) echo "style='background-color: blue;'";?>
                    type="submit" name="action" value="upvote">+
                </button>

                <button
                    <?php if ($tag['vote'] == 0) echo "style='background-color: blue;'";?>
                    type="submit" name="action" value="downvote">-
                </button>

            </div>
        <?php endif;?>

        <?php if (isset($_SESSION["user_type"]) ? $_SESSION["user_type"] == "editor" : false):?>
            <button type="submit" name="action" value="delete" class="delete" onclick="confirmSubmission(event)">X</button>
        <?php endif;?>
    
    </span>
    </form>
<?php endforeach; ?>
</div>

<br>
