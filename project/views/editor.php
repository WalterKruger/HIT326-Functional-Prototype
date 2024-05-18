<?php
session_start();
require_once '../config/db.php';

// Check if the user is logged in and is an author
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header('Location: login.php'); // Redirect to login page if not authorized
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
<?php include '../views/partials/header.php'; ?>

<div class="container">
    <h1>Add New Article</h1>
    <form action="/lao/project/controllers/submit_article.php" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" cols="30" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

<?php include '../views/partials/footer.php'; ?>
</body>
</html>
