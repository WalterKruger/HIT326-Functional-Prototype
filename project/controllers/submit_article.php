<?php
session_start();
require '../config/db.php'; // Adjust path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role'] === 'moderator') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id']; // Ensure the user ID is stored in session upon login

    $stmt = $conn->prepare("INSERT INTO articles (title, content, author_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $author_id);

    if ($stmt->execute()) {
        echo "Article added successfully!";
        header('Location: view_articles.php'); // Redirect to view articles page or wherever appropriate
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
else {
    header('Location: index.php'); // Redirect if not a POST request or not a moderator
}
?>
