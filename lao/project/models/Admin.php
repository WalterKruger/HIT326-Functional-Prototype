<?php
    require 'Base.php';

    class Admin extends ModelBase {
        // Filter function
        private function SQLstatementIsValid($SQLstatement) {
            // Empty lines
            if (strlen( $SQLstatement ) == 0) return false;

            // SQL comments
            if ( substr(trim($SQLstatement), 2) == "--") return false;

            return true;
        }

        private function getSQLfileAsArray($pathToScript) {
            if (!file_exists($pathToScript))
                die("File '$pathToScript' doesn't exist"); 

            $fileAsString = file_get_contents($pathToScript);
            $arrayOfStatements = explode(";", $fileAsString);

            return array_filter($arrayOfStatements, array($this, "SQLstatementIsValid"));
        }

        public function runSQLfile($sql_path) {
            $createScriptAsArray = $this->getSQLfileAsArray($sql_path);

            echo "<h3>Creating tables from '$sql_path'...</h3>";

            $TAB_HTML = "&emsp;"; 

            foreach($createScriptAsArray as $sqlStatement) {
                echo str_replace(",", ",<br>$TAB_HTML $TAB_HTML", $sqlStatement) . "<br><br>";
                
                if ($this->db->query($sqlStatement)) {
                    echo "<b>Created successfully!</b>";
                } else {
                    echo "<b>Error creating table:" . $this->db->error . "</b>";
                }

                echo "<br><br>";
            }
        }

        public function populateUsers($data) {
            echo "<h4>Inserting data into table...</h4>";

            $db_table = "Account";

            // First clear table
            $this->db->query("DELETE FROM $db_table");

            $sql_statement = $this->db->prepare(
                "INSERT INTO $db_table (user_name, email) VALUES (?, ?)"
            );
            try {
                
                for ($i = 0; $i < count($data); $i++) {
                    $sql_statement->bind_param("ss", $data[$i][0], $data[$i][1]);
                    $sql_statement->execute();
                }
            
            } catch (Exception $insert_error) {
                die("Error: $insert_error");
            }
        }


        public function populateArticle($data) {
            $db_table = "articles";

            echo "<h4>Inserting data into $db_table...</h4>";

            // First clear table
            $this->db->query("DELETE FROM $db_table");

            $sql_statement = $this->db->prepare(
                "INSERT INTO $db_table (title, text_content) VALUES (?, ?)"
            );
            if (! $sql_statement) die ("Error: prepare statement was invalid");
            try {
                
                for ($i = 0; $i < count($data); $i++) {
                    $sql_statement->bind_param("ss", $data[$i][0], $data[$i][1]);
                    $sql_statement->execute();
                }
            
            } catch (Exception $insert_error) {
                die("Error: $insert_error");
            }
        }
    }
?>