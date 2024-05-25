<?php
require_once 'Base.php';

class Author extends ModelBase {
    // Method to check if an author exists for a given account ID
    public function authorExists($accountId) {
        $stmt = $this->db->prepare("SELECT id FROM Author WHERE account_id = ?");
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }
}
?>
