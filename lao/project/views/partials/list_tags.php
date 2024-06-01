<head>
    <link rel="stylesheet" href="/lao/project/css/popup.css">
</head>

<script>
    function confirmSubmission(event) {
        if (!confirm("Are you sure you want to remove this tag?"))
            event.preventDefault();
    }
    function openNav(popUpId)  { document.getElementById("addPopup_" + popUpId).style.width = "50%"; }
    function closeNav(popUpId) { document.getElementById("addPopup_" + popUpId).style.width = "0%"; }
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


<?php if (isset($_SESSION['user_type'])): ?>
    <?php require '../controllers/proposeTagsController.php'; ?>

    <div id="addPopup_<?php echo $article['id']?>" class="overlay">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav('<?php echo $article['id']?>')">&times;</a>
        <div class="overlay-content">
            <?php foreach ($unSetTags as $unSetTag):?>
                <button><?php echo $unSetTag['name'];?></button>


            <?php endforeach; ?>
        </div>
    </div>

    <span class="add-tag-button" onclick="openNav('<?php echo $article['id']?>')">Propose new tags</span>
<?php endif;?>

<br>
