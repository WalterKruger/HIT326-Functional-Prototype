<?php 
    // If already isn't logged in
    if (empty($_SESSION["user_id"])) {
        // TODO: Change to dashboard page?
        header("Location: /lao/project/views/login.php");
        exit;
    }

    require "../models/User.php";
    $model = new User();

    $userData = $model->getUserData($_SESSION["user_id"]);

    if ($userData == null) {
        echo "No user found";
        return;
    }

    foreach ($userData as $key => $value) {
        echo "$key:&emsp;$value <br>";
    }

    echo "Account type: " . $model->getUserType($_SESSION["user_id"]);
?>