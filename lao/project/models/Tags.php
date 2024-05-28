<?php
require_once 'Base.php';

class Tags extends ModelBase {

    public function getTags($articleID) {
        $stmt = $this->db->prepare("SELECT tag_id, weight FROM Article_to_tag WHERE article_id = ?");
        $stmt->bind_param('i', $articleID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return [];

        // TODO: Get all with a weight of at least 20%, up to max five
        $tagIdWithPresence = [];
        while($row = $result->fetch_assoc()) {
            $tagIdWithPresence[] = $row['tag_id'];
        }

        
        $placeholders = implode(',', $tagIdWithPresence);
        $matchingTagNames = $this->db->query("SELECT tag_name, id FROM Tags WHERE id IN ($placeholders)");
        
        $tagNames = [];
        while ($row = $matchingTagNames->fetch_assoc()) {
            $tagNames[] = ['name' => $row['tag_name'], 'id' => $row['id']];
        }
        
        return $tagNames;
    }

    public function removeTagFromArticle($articleID, $tagId) {
        if (!$this->permissionToModifyTable($_SESSION["user_id"], $_SESSION["passwordPlain"], "Article_to_tag", false))
            return;

        $stmt = $this->db->prepare("DELETE FROM Article_to_tag WHERE article_id = ? AND tag_id = ?");
        $stmt->bind_param('ii', $articleID, $tagId);
        $stmt->execute();
    }
}

?>