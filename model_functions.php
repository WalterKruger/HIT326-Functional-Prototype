<?php

    // Filter function
    function SQLstatementIsValid($SQLstatement) {
        // Empty lines
        if (strlen( $SQLstatement ) == 0) return false;

        // SQL comments
        if ( substr(trim($SQLstatement), 2) == "--") return false;

        return true;
    }

    function getSQLfileAsArray($pathToScript) {
        if (!file_exists($pathToScript))
            die("File '$pathToScript' doesn't exist"); 

        $fileAsString = file_get_contents($pathToScript);
        $arrayOfStatements = explode(";", $fileAsString);

        return array_filter($arrayOfStatements, "SQLstatementIsValid");
    }



    function echoSQLresultAsTable($result) {
        if ($result->num_rows > 0) {
            echo "<table><tr>";

            // Column lables
            foreach($result->fetch_fields() as $field)
                echo "<th>$field->name</th>";
            
            echo "</tr>";

            // Data for HTML table's rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $value)
                    echo "<td>$value</td>";
                
                echo "</tr>";
            }
            
            echo "</table>";
        
        } else
            echo "Table is empty<br>";
        

    }
?>