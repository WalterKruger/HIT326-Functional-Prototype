<?php
    session_start();
    
    // If already logged in, go to home page
    if (isset($_SESSION["user_id"])) {
        // TODO: Change to dashboard page?
        header("Location: /lao/project/views/home.php");
        exit;
    }
    
    
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        return;

    
    require "../models/User.php";
    $articleModel = new User();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $error = "";

    if ($articleModel->login($username, $password, $error)) {
        //$articleModel->setUserType($_SESSION["user_id"], "admin");
        header("Location: /lao/project/views/home.php");
        exit;
    }

    
?>