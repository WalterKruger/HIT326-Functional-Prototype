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
        $stmt = $this->db->prepare("SELECT id, tag_id FROM Tag_for_article WHERE article_id = ?");
        $stmt->bind_param('i', $articleID);
        $stmt->execute();
        $result = $stmt->get_result();

        $tagForArticleResult = [];
        while ($row = $result->fetch_assoc()) {
            $tagForArticleResult[] = ["tag_id" => $row["tag_id"], "articleTagId" => $row["id"]];
        }

        $tagData = [];
        foreach ($tagForArticleResult as $tagForArticle) {
            $tagId = $tagForArticle["tag_id"];

            // Get the lable of the tag
            $stmt = $this->db->prepare("SELECT tag_name FROM Tags WHERE id = ?");
            $stmt->bind_param('i', $tagId);
            $stmt->execute();
            $result = $stmt->get_result();

            $tagName = $result->fetch_assoc()["tag_name"];


            // Check if the user has voted
            $stmt = $this->db->prepare("SELECT vote FROM Tag_vote WHERE article_tag_id = ? AND account_id = ?");
            $stmt->bind_param('ii', $tagForArticle["articleTagId"], $accountId);
            $stmt->execute();
            $result = $stmt->get_result();

            $userVote = ($result->num_rows == 0)? -1 : $result->fetch_assoc()["vote"];


            $tagData[] = ['name' => $tagName, 'id' => $tagId, 'vote' => $userVote];
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