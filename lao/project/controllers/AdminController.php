<?php

    if ($_POST["action"] ?? "" == "set_type") {
        require '../models/User.php';
        $model = new User();

        $model->setUserType($_SESSION["user_id"], $_POST["type"]);
        return;
    }
    
    require '../models/Admin.php';

    $model = new Admin();

    switch ($_POST["action"] ?? "") {
        case 'create_tables':
            $model->runSQLfile($_SERVER["DOCUMENT_ROOT"] . "/lao/project/sql/create_tables.sql");
            break;
        
        case 'insert_users':
            $data = [
                ["Walter Kruger", "walter@example.com"],
                ["John Doe", "john@example.com"],
                ["Jane Doe", "jane@example.com"],
                ["Smith person", "smith@example.com"],
                ["admin", "admin@example.com"]  // Test case
            ];
            $model->populateUsers($data);
            break;
        
        case 'insert_articles':
            $TEST_CONTENT = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut";
            $data = [
            ["First Tile", $TEST_CONTENT],
            ["Title 2", $TEST_CONTENT],
            ["New Title", $TEST_CONTENT],
            ["Final title", $TEST_CONTENT]
            ];
            $model->populateArticle($data);
            break;
    }
?>