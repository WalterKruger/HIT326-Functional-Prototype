<?php
session_start();

require "../models/User.php";
$userModel = new User();
$error = ""; // Initialize the error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $passwordPlainText = $_POST["password"];
    $role = $_POST["role"] ?? 'user';  // Default role is 'user' unless specified

    // Check if the username already exists
    if ($userModel->doesUserExist($username)) {
        $error = "Username already exists.";
    } else {
        // If username does not exist, try to create a new user
        if ($userModel->createUser($username, $passwordPlainText, $role, $error)) {
            // If user is created successfully, log them in
            if ($userModel->login($username, $passwordPlainText, $error)) {
                // Redirect to home page after successful login
                header("Location: /lao/project/views/home.php");
                exit;
            } else {
                // Handle error if login fails
                $error = "Login failed: " . $error;
            }
        } else {
            // Display error if user creation fails
            $error = "Failed to create user: " . $error;
        }
    }
}

// Display errors or handle other logic as needed
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
