<?php
    class ModelBase {
        protected $db;

        public function __construct() {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "project";

            // Create connection
            $this->db = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        public function getUserType($user_id) {
            // Get the type_id, from the user_id
            $stmt = $this->db->prepare("SELECT * FROM Account_to_type WHERE account_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $toTypeResult = $stmt->get_result();
            if ($toTypeResult->num_rows != 1) return null;

            $toTypeResult = $toTypeResult->fetch_assoc();

            $type_id = $toTypeResult["type_id"];

            // Find the type name based on the type_id
            $stmt = $this->db->prepare("SELECT type_name FROM Account_type WHERE type_id = ?");
            $stmt->bind_param("i", $type_id);
            $stmt->execute();

            $typeResult = $stmt->get_result();
            if ($typeResult->num_rows != 1) return null;

            return $typeResult->fetch_assoc()["type_name"];

        }


        public function inputPassMatchesTable($user_id, $passwordPlain) {
            $stmt = $this->db->prepare("SELECT password_hash FROM Account WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $accountLookup = $stmt->get_result();
            if ($accountLookup->num_rows != 1) return false;

            $accountLookup = $accountLookup->fetch_assoc();

            return password_verify($passwordPlain, $accountLookup["password_hash"]);
        }


        public function permissionToModifyTable($user_id, $passwordPlain, $table, $onlyAddNew) {
            if ($onlyAddNew && $table == "Account")
                return true;

            if (! $this->inputPassMatchesTable($user_id, $passwordPlain))
                return false;
            
            $userType = $this->getUserType($user_id);

            switch ($table) {
                case "Tags": case "Account_type": case "Account_to_type":
                    return isset(["admin", "editor"][$userType]);
                
                case "Articles": case "Author": case "Article_to_author":
                    return isset(["admin", "editor", "journalist"][$userType]);
                
                case "Account":
                    return true;
                
                default:
                    // TODO: This is true for testing. Make this false later
                    return true;
                }
                
        }
    }
?>