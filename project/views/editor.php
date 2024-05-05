<?php
session_start();

// Check if the user is logged in and is a moderator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'moderator') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit;
}

include 'layouts/standard.layout.php'; // Assuming this layout includes header and footer

?>

<div class="editor-container">
    <h1>Add New Article</h1>
    <form action="submit_article.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="10" cols="30" required></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
</div>
