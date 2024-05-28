<?php
require_once '../models/User.php';

class Admin extends ModelBase {
    private function SQLstatementIsValid($SQLstatement) {
        $SQLstatement = trim($SQLstatement);
        if (strlen($SQLstatement) == 0 || substr($SQLstatement, 0, 2) == "--") return false;
        return true;
    }

    private function getSQLfileAsArray($pathToScript) {
        if (!file_exists($pathToScript)) {
            error_log("File '$pathToScript' doesn't exist");
            return []; 
        }
        $fileAsString = file_get_contents($pathToScript);
        $arrayOfStatements = explode(";", $fileAsString);
        return array_filter($arrayOfStatements, array($this, "SQLstatementIsValid"));
    }

    public function runSQLfile($sql_path) {
        $createScriptAsArray = $this->getSQLfileAsArray($sql_path);
        echo "<h3>Executing SQL from '$sql_path'...</h3>";
        foreach($createScriptAsArray as $sqlStatement) {
            $sqlStatement = trim($sqlStatement); // Ensure SQL statement is trimmed
            if (!$sqlStatement) continue;
            if ($this->db->query($sqlStatement)) {
                echo "<b>Executed successfully!</b><br>";
            } else {
                echo "<b>Error executing SQL: " . $this->db->error . "</b><br>";
            }
        }
    }

    public function populateUsers($data) {
        echo "<h4>Inserting data into users...</h4>";
        // Ensure all foreign key references are removed before deletion
        $this->db->query("DELETE FROM Account_to_type");
        $this->db->query("DELETE FROM Account");

        $userModel = new User();
        foreach ($data as $user) {
            $error = "";
            if (!$userModel->createUser($user[0], "password123", "admin", $error)) {
                echo "Failed to insert user {$user[0]}: $error<br>";
            }
        }
    }

    public function populateArticle($data) {
        echo "<h4>Inserting data into articles...</h4>";
        // First clear dependent and then the main table
        $this->db->query("DELETE FROM article_to_author");
        $this->db->query("DELETE FROM articles");

        $stmt = $this->db->prepare("INSERT INTO articles (title, text_content) VALUES (?, ?)");
        if (!$stmt) die("Prepared statement failed: " . $this->db->error);

        foreach ($data as $article) {
            $stmt->bind_param("ss", $article[0], $article[1]);
            if (!$stmt->execute()) {
                echo "Failed to insert article: " . $stmt->error . "<br>";
            }
        }
    }

    public function addRandomTags() {
        $this->db->query("DELETE FROM Article_to_tag");

        $articleQuery = $this->db->query("SELECT id FROM Articles");
        if ($articleQuery->num_rows == 0) return;

        $articleIds = [];
        while($row = $articleQuery->fetch_assoc())
            $articleIds[] = $row['id'];

        
        $tagsQuery = $this->db->query("SELECT id FROM Tags");
        if ($tagsQuery->num_rows == 0) return;
    
        $tagIds = [];
        while($row = $tagsQuery->fetch_assoc())
            $tagIds[] = $row['id'];
        
        
        foreach ($articleIds as $articleId) {
            $numOfTags = rand(0, count($tagIds) * 1.5);
            
            for ($i = 0; $i < $numOfTags; $i++) {
                $tagId = $tagIds[rand(0, count($tagIds))];
                $this->db->query("INSERT INTO Article_to_tag (article_id, tag_id) VALUES ($articleId, $tagId)");
            }
        }
        
        
    }
}
?>
