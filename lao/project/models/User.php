<?php
require 'Base.php';

class User extends ModelBase {

    // Validate user credentials
    public function validateUser($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM Account WHERE user_name = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return password_verify($password, $row['password_hash']) ? $row : false;
        }
        return false;
    }

    // Log in the user
    public function login($username, $password, &$error_message) {
        $user_data = $this->validateUser($username, $password);
        if ($user_data) {
            $_SESSION["user_id"] = $user_data['id'];
            $_SESSION["user_type"] = $this->getUserType($user_data['id']);
            $_SESSION["passwordPlain"] = $password;

            $curDateTime = date("Y-m-d H:i:s");
            $stmt = $this->db->prepare("UPDATE Account SET last_login = ? WHERE id = ?");
            $stmt->bind_param("si", $curDateTime, $user_data['id']);
            $stmt->execute();
            return true;
        } else {
            $error_message = "Invalid username or password";
            return false;
        }
    }

    // Check if username already exists
    public function doesUserExist($username) {
        $stmt = $this->db->prepare("SELECT id FROM Account WHERE user_name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }

    public function createUser($username, $passwordPlainText, $role, &$error) {
        if ($this->doesUserExist($username)) {
            $error = "User already exists";
            return false;
        }
    
        $password_hash = password_hash($passwordPlainText, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Account (user_name, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);
        
        if (!$stmt->execute()) {
            $error = "SQL failed to insert the account: " . $this->db->error;
            return false;
        }
    
        $userId = $this->db->insert_id;
    
        if (in_array($role, ['journalist', 'editor', 'admin'])) {
            if (!$this->createAuthor($userId, $username)) {
                $error = "Failed to create author record";
                return false;
            }
        }
    
        return true;
    }
    
    private function createAuthor($accountId, $authorName) {
        $stmt = $this->db->prepare("INSERT INTO Author (account_id, full_name) VALUES (?, ?)");
        $stmt->bind_param("is", $accountId, $authorName);
        if (!$stmt->execute()) {
            return false; // Handle this error appropriately
        }
        return true;
    }
    
    
    

    // Sets or updates the user type in the database and updates session
    public function setUserType($userId, $type) {
        $typeId = $this->getTypeIdByName($type);
        if (!$this->doesUserExistById($userId)) {
            throw new Exception("User does not exist with ID: " . $userId);
        }
        $stmt = $this->db->prepare("SELECT * FROM Account_to_type WHERE account_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = $this->db->prepare("UPDATE Account_to_type SET type_id = ? WHERE account_id = ?");
            $stmt->bind_param("ii", $typeId, $userId);
        } else {
            $stmt = $this->db->prepare("INSERT INTO Account_to_type (account_id, type_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $userId, $typeId); // Corrected 'typeId' to '$typeId'
        }
        if (!$stmt->execute()) {
            throw new Exception("Failed to set or update user type: " . $stmt->error);
        }
        $_SESSION['user_type'] = $type;
    }

    // Get type ID by type name
    private function getTypeIdByName($typeName) {
        $stmt = $this->db->prepare("SELECT type_id FROM Account_type WHERE type_name = ?");
        $stmt->bind_param("s", $typeName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['type_id'];
        }
        throw new Exception("Type not found");
    }

    // Fetch user data
    public function getUserData($user_id) {
        $stmt = $this->db->prepare("SELECT user_name, email, creation_date, last_login FROM Account WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 1) return null;
        return $result->fetch_assoc();
    }

    // Check if user with specific ID exists
    public function doesUserExistById($userId) {
        $stmt = $this->db->prepare("SELECT id FROM Account WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);  // Returns true if user exists, false otherwise
    }
}
?>