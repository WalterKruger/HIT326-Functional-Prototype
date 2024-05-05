<!DOCTYPE html
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
    <link rel="stylesheet" href="/lao/project/css/login.css">  <!-- Include only if specific styles from login.css are needed -->

</head>
<body>
    <h1>Login</h1>
    <form action="/lao/project/controllers/LoginController.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>

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

</body>
</html>
