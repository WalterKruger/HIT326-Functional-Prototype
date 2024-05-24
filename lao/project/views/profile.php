<?php
    if (session_status() == PHP_SESSION_NONE) 
        session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
<?php include 'partials/header.php'; ?>
<div class="container">
    <h1>My Profile</h1>
    <?php include '../controllers/ProfileController.php'; ?>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>
