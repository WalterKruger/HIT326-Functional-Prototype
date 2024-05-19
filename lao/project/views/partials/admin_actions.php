<form action="home.php" method="POST">
        <input type="radio" id="create_tables" name="action" value="create_tables">
        <label for="create_tables">Create tables</label><br>

        <input type="radio" id="insert_users" name="action" value="insert_users">
        <label for="insert_users">Insert dummy users</label><br>

        <input type="radio" id="insert_articles" name="action" value="insert_articles">
        <label for="insert_articles">Insert dummy articles</label><br>

        <input type="submit">
        
    </form>

    <?php require '../controllers/AdminController.php'; ?>