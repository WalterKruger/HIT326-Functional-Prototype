<?php
    session_start();
    
    // If already logged in, go to home page
    if (isset($_SESSION["user_id"])) {
        header("Location: /lao/project/views/home.php");
        exit;
    }
    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    
    require "../models/User.php";
    $userModel = new User();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $error = "";

    if ($userModel->login($username, $password, $error)) {
        header("Location: /lao/project/views/home.php");
        exit;
    }
?>
