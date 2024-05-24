<?php require_once '../controllers/LogoutController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Application</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
    <script type="text/javascript">
        // Inline JavaScript to set a timeout for redirection
        setTimeout(function() {
            window.location.href = "home.php";
        }, 3000); // milliseconds
    </script>

<body>
    <div class="container">
        <?php include '../views/partials/header.php'; ?>
        <h1>Logged out successfully!</h1>
        <p>You will be redirected to the home page soon...</p>
    </div>
    <?php include '../views/partials/footer.php'; ?>
</body>
</html>

