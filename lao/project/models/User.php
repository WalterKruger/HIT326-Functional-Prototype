<?php
    require 'Base.php';

    class User extends ModelBase {
        
        public function create($username, $password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);
            return $stmt->execute();
        }

        public function verifyUser($username, $password) {
            $stmt = $this->db->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashedPassword);
                $stmt->fetch();
                return password_verify($password, $hashedPassword) ? $id : false;
            }
            return false;
        }
    }
?>
