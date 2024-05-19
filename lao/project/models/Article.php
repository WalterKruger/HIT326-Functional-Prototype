<?php
    require 'Base.php';

    class Article extends ModelBase {
        public function fetchAll() {
            $query = "SELECT * FROM articles";
            $result = $this->db->query($query);
            $this->echoSQLresultAsTable($result);
        }

        private function echoSQLresultAsTable($result) {
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

    // TODO: The database schema doesn't have 'aurthor_id' as a foreign key
    public function uploadArticle($title, $content, $author_id) {
        $stmt = $this->db->prepare("INSERT INTO articles (title, text_contnet) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);

        return $stmt->execute();
    }
    }
?>
