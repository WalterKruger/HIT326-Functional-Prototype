<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = Database::getInstance()->getConnection();
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            header("Location: /lao/project/views/login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>
