<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
    <link rel="stylesheet" href="/lao/project/css/login.css">
</head>
<body>
<?php include 'partials/header.php'; ?>
<div class="login-container">
    <h1>Login</h1>
    <?php include 'partials/LoginForm.php'; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            if (!username || !password) {
                alert("Both username and password are required!");
                event.preventDefault();  // Prevent form submission
            }
        });
    });
    </script>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>
