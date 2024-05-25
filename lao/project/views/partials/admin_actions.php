<form action="../controllers/AdminController.php" method="POST">

    <input type="radio" id="create_tables" name="action" value="create_tables">
    <label for="create_tables">Create tables</label><br>

    <input type="radio" id="insert_users" name="action" value="insert_users">
    <label for="insert_users">Insert dummy users</label><br>

    <input type="radio" id="insert_articles" name="action" value="insert_articles">
    <label for="insert_articles">Insert dummy articles</label><br>

    <?php if (isset($_SESSION["user_id"])): ?>
        <input type="radio" id="set_type" name="action" value="set_type">
        <label for="set_type">Set account type</label>
        <select name="type" id="type">
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
            <option value="journalist">Journalist</option>
            <option value="user">User</option>
        </select><br>
    <?php endif; ?>

    <input type="submit">
</form>
