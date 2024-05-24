<?php
    require 'Base.php';

    class User extends ModelBase {

        public function login($username, $password, &$error_message) {
            $stmt = $this->db->prepare("SELECT id, password_hash FROM Account WHERE user_name = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $accountLookup = $stmt->get_result();
            
            if ($accountLookup->num_rows != 1) {
                $error_message = "Invalid username";
                return false;
            }

            $accountLookup = $accountLookup->fetch_assoc();

            if (! $this->inputPassMatchesTable($accountLookup["id"], $password) ) {
                $error_message = "Invalid password";
                return false;
            }
            
            // Set session info
            $_SESSION["user_id"] = $accountLookup["id"];
            $_SESSION["password"] = $accountLookup["password_hash"];

            // Upate login time
            $curDateTime = date("Y-m-d H:i:s");

            $stmt = $this->db->prepare("UPDATE Account SET last_login = ? WHERE id = ?");
            $stmt->bind_param("si", $curDateTime, $_SESSION["user_id"]);
            $stmt->execute();

            return true;
            
        }

        public function doesUserExist($username) {
            $stmt = $this->db->prepare("SELECT id FROM Account WHERE user_name = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $userLookup = $stmt->get_result();

            return ($userLookup->num_rows == 1);
        }

        public function createUser($username, $passwordPlainText, &$error) {
            $password_hash = password_hash($passwordPlainText, PASSWORD_DEFAULT);

            // Add account
            $stmt = $this->db->prepare("INSERT INTO Account (user_name, password_hash) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password_hash);

            if (!$stmt->execute()) {
                $error = "SQL failed to insert the account";
                return;
            }
        }

        private const TYPES = ["admin" => 1, "editor" => 2, "journalist" => 3, "user" => 4];
        public function setUserType($user_id, $type) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM Account_to_type WHERE account_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
    
                if ($stmt->get_result()->num_rows != 0) {
                    $stmt = $this->db->prepare("DELETE FROM Account_to_type WHERE account_id = ?");
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                }

                $type_id = $this::TYPES[$type];
    
                $stmt = $this->db->prepare("INSERT INTO Account_to_type (account_id, type_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $type_id);
                $stmt->execute();
            
            } catch(Exception $error) {
                die("Error when setting type: " . $error);
              }
           


        }


        public function getUserData($user_id) {
            $stmt = $this->db->prepare("SELECT user_name, email, creation_date, last_login FROM Account WHERE id = ?");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            
            $userLookup = $stmt->get_result();
            if ($userLookup->num_rows != 1) return null;

            return $userLookup->fetch_assoc();
        }
    }
?>
