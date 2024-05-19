<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/lao/project/css/styles.css">
</head>
<body>
    <?php include VIEWS . "/partials/header.php"; ?>
    <div class="container">

        <?php require PROJECT_DIR . "controllers/{$page}Controller.php"; ?>
    </div>
    <p>Base layout</p>
    <?php include VIEWS . "/partials/footer.php"; ?>
</body>
</html>
