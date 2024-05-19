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
    }
?>