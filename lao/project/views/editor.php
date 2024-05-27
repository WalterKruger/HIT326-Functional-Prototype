<?php
session_start();
if ($_SESSION['user_type'] != 'journalist') {
    header('Location: /lao/project/views/home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Article</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<?php include 'partials/header.php'; ?>

<div class="container">
    <h1>Add New Article</h1>
    <form action="/lao/project/controllers/submit_article.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title" class="label">Title:</label>
            <input type="text" id="title" name="title" required class="input-text">
        </div>
        <div class="form-group">
            <label for="content" class="label">Content (Markdown supported):</label>
            <textarea id="content" name="content" required class="textarea"></textarea>
        </div>
        <div class="form-group">
            <label for="image" class="label">Upload Image:</label>
            <input type="file" id="image" name="image" class="input-text">
        </div>
        <button type="submit" class="button">Submit</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>
