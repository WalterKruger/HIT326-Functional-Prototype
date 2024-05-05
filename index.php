<!doctype html>
<html>
<head>
     <meta charset='utf-8' />
     <title>Database testing</title>
</head>
<body>
     <p>Here is a HTML paragraph</p>

<?php
    require "model_functions.php";

    $TAB_HTML = "&emsp;"; 

    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "mydb";

    // Check connection
    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db->connect_error)
        die("Connection failed: " . $db->connect_error);
    

    

    // Create tables from SQL file
    $sql_path = "create_tables.sql";
    $createScriptAsArray = getSQLfileAsArray($sql_path);

    echo "<h3>Creating tables from '$sql_path'...</h3>";

    foreach($createScriptAsArray as $sqlStatement) {
        echo str_replace(",", ",<br>$TAB_HTML $TAB_HTML", $sqlStatement) . "<br><br>";
        
        if ($db->query($sqlStatement)) {
            echo "<b>Created successfully!</b>";
        } else {
            echo "<b>Error creating table: $db->error</b>";
        }

        echo "<br><br>";
    }


    
    

    echo "<br>";

    
    // Insert dummy data into table
    echo "<h4>Inserting data into table...</h4>";

    $db_table = "Account";

    // First clear table
    $db->query("DELETE FROM $db_table");

    $sql_statement = $db->prepare(
        "INSERT INTO $db_table (user_name, email) VALUES (?, ?)"
    );

    $data = [
        ["Walter Kruger", "walter@example.com"],
        ["John Doe", "john@example.com"],
        ["Jane Doe", "jane@example.com"],
        ["Smith person", "smith@example.com"]
    ];
    
    try {
        
        for ($i = 0; $i < count($data); $i++) {
            $sql_statement->bind_param("ss", $data[$i][0], $data[$i][1]);
            $sql_statement->execute();
        }
    
    } catch (Exception $insert_error) {
        die("Error: $insert_error");
    }

    
    // Get data from table and format it as an HTML table
    $result = $db->query("SELECT * FROM $db_table");

    echoSQLresultAsTable($result);

    ?>


        </body>
</html>


