<?php
    session_start();

    $error = "";
    if ($_SERVER["REQUEST_METHOD"] != "POST") return;
    
    require "../models/User.php";
    $userModel = new User();
    
    $username = trim($_POST["username"]);
    $passwordPlainText = $_POST["password"];

    if ($userModel->doesUserExist($username)) {
        $error = "Username already exists.";
        return;
    }

    //$error = "User created successfully.";
    $userModel->createUser($username, $passwordPlainText, $error);
    if (!empty($error)) return;

    // Login
    if ($userModel->login($username, $passwordPlainText, $error) ) {
        $userModel->setUserType($_SESSION["user_id"], "admin");

        header("Location: /lao/project/views/home.php");
        exit;
    }
    
?>