<?php
require_once __DIR__ . '/../config/db.php'; // More robust and flexible


class Article {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function fetchAll() {
        $query = "SELECT * FROM articles";
        $result = $this->db->query($query);
        $articles = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }
}
?>
