<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = Database::getInstance()->getConnection();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            header("Location: /lao/project/views/dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No such username.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
    <link rel="stylesheet" href="/lao/project/css/login.css">
</head>
<body>
<?php include '../views/partials/header.php'; ?>

<div class="login-container">
    <h1>Login</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
    <p><a href="/lao/project/views/forgot_password.php">Forgot Password?</a></p>
    <p>Don't have an account? <a href="/lao/project/views/signup.php">Sign Up</a></p>
</div>

<?php include '../views/partials/footer.php'; ?>
</body>
</html>
