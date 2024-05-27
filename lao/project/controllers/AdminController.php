<?php
session_start();
require_once '../models/Admin.php';
require_once '../models/User.php';

$adminModel = new Admin();
$userModel = new User();

if (isset($_POST["action"])) {
    try {
        switch ($_POST["action"]) {
            case 'create_tables':
                $adminModel->runSQLfile($_SERVER["DOCUMENT_ROOT"] . "/lao/project/sql/create_tables.sql");
                break;
            case 'insert_users':
                $data = [["Walter Kruger", "walter@example.com"], ["John Doe", "john@example.com"]];
                $adminModel->populateUsers($data);
                break;
            case 'insert_articles':
                $data = [["First Title", "Sample content for first title"], ["Second Title", "Sample content for second title"]];
                $adminModel->populateArticle($data);
                break;
            case 'set_type':
                $userModel->setUserType($_SESSION["user_id"], $_POST["type"]);
                break;
        }
        header("Location: /lao/project/views/home.php?status=action_completed");
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
