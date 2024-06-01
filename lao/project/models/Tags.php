<?php
require_once 'Base.php';

class Tags extends ModelBase {

    private function getArticleTagId($articleID, $tagId) {
        $stmt = $this->db->prepare("SELECT id FROM Tag_for_article WHERE article_id = ? AND tag_id = ?");
        $stmt->bind_param('ii', $articleID, $tagId);
        $stmt->execute();
        $result = $stmt->get_result();

        return ($result->num_rows == 0)? null : $result->fetch_assoc()["id"];
    }

    public function getTags($articleID, $accountId) {
        $stmt = "SELECT tags.id, tags.tag_name, tag_vote.vote FROM tag_for_article
                    INNER JOIN tags ON tag_for_article.tag_id = tags.id
                    LEFT JOIN tag_vote ON tag_for_article.id = tag_vote.article_tag_id AND tag_vote.account_id = ?
                    WHERE tag_for_article.article_id = ?";
        
        $stmt = $this->db->prepare($stmt);
        $stmt->bind_param('ii', $accountId, $articleID);
        $stmt->execute();
        $result = $stmt->get_result();

        $tagData = [];
        while ($row = $result->fetch_assoc()) {
            $tagData[] = [
                'name' => $row['tag_name'], 
                'id' => $row['id'], 
                'vote' => isset($row['vote'])? $row['vote'] : -1
            ];
        }
        
        
        return $tagData;
    }

    public function getAllTags() {
        $stmt = $this->db->prepare("SELECT id, tag_name FROM Tags");
        $stmt->execute();
        $result = $stmt->get_result();

        $listOfTags = [];
        while ($row = $result->fetch_assoc()) {
            $listOfTags[] = ["id" => $row["id"], "name" => $row["tag_name"]];
        }

        return $listOfTags;
    }

    public function getUnsetTags($articleID) {
        $stmt = "SELECT tags.id, tags.tag_name FROM tags
                    LEFT JOIN tag_for_article ON tags.id = tag_for_article.tag_id 
                        AND tag_for_article.article_id = ?
                    WHERE tag_for_article.article_id IS NULL";
        
        $stmt = $this->db->prepare($stmt);
        $stmt->bind_param('i', $articleID);
        $stmt->execute();
        $result = $stmt->get_result();

        $unsetTags = [];
        while ($row = $result->fetch_assoc()) {
            $unsetTags[] = ["name" => $row["tag_name"], "id" => $row["id"]];
        }

        return $unsetTags;
    }


    public function removeTagFromArticle($articleID, $tagId) {
        if (!$this->permissionToModifyTable($_SESSION["user_id"], $_SESSION["passwordPlain"], "Article_to_tag", false))
            return;

        $articleTagId = $this->getArticleTagId($articleID, $tagId);
        if ($articleTagId == null) return;


        $stmt = $this->db->prepare("DELETE FROM Tag_vote WHERE article_tag_id = ?");
        $stmt->bind_param('i', $articleTagId);
        $stmt->execute();



        $stmt = $this->db->prepare("DELETE FROM Tag_for_article WHERE article_id = ? AND tag_id = ? LIMIT 1");
        $stmt->bind_param('ii', $articleID, $tagId);
        $stmt->execute();
    }


    public function addNewTag($articleID, $tagIdToAdd) {
        // Prevent adding the same tag twice
        $stmt = $this->db->prepare("SELECT * FROM Tag_for_article WHERE tag_id = ? AND article_id = ?");
        $stmt->bind_param('ii', $tagIdToAdd, $articleID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows != 0) return;

        $stmt = $this->db->prepare("INSERT INTO Tag_for_article (article_id, tag_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $articleID, $tagIdToAdd);
        $stmt->execute();
    }


    public function voteForTag($articleID, $tagId, $userId, $vote) {
        // Check for already existing vote
        $tagForArticleId = $this->getArticleTagId($articleID, $tagId);
        if ($tagForArticleId == null) return;


        $stmt = $this->db->prepare("SELECT * FROM Tag_vote WHERE article_tag_id = ? AND account_id = ?");
        $stmt->bind_param('ii', $tagForArticleId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows != 0) {
            $stmt->prepare("UPDATE Tag_vote SET vote = ? WHERE article_tag_id = ? AND account_id = ?");
            $stmt->bind_param('iii', $vote, $tagForArticleId, $userId);
            $stmt->execute();

            return;
        }


        $stmt->prepare("INSERT INTO Tag_vote (article_tag_id, account_id, vote) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $tagForArticleId, $userId, $vote);
        $stmt->execute();
    }
}

?>