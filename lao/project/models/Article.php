<?php
require_once 'Base.php';

class Article extends ModelBase {
    public function fetchAllApproved() {
        $query = "SELECT id, title, text_content, image_path, creation_date, modification_date FROM articles ORDER BY modification_date DESC";
        $result = $this->db->query($query);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function fetchTopArticles() {
        $query = "SELECT id, title, text_content, image_path, creation_date, modification_date FROM articles ORDER BY modification_date DESC LIMIT 5";
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function uploadArticle($title, $content, $imagePath, $authorId) {
        $stmt = $this->db->prepare("INSERT INTO articles (title, text_content, image_path, creation_date, modification_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        $stmt->bind_param("sss", $title, $content, $imagePath);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting article: " . $stmt->error);
        }
        $articleId = $this->db->insert_id;
        $stmt = $this->db->prepare("INSERT INTO Article_to_author (article_id, author_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $articleId, $authorId);
        if (!$stmt->execute()) {
            throw new Exception("Error linking article to author: " . $stmt->error);
        }
        return $articleId;
    }

    public function fetchPendingArticles() {
        $query = "SELECT * FROM articles WHERE modification_date = creation_date ORDER BY creation_date DESC";
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function approveArticle($articleId) {
        $stmt = $this->db->prepare("UPDATE articles SET modification_date = NOW() WHERE id = ?");
        $stmt->bind_param("i", $articleId);
        if (!$stmt->execute()) {
            throw new Exception("Error approving article: " . $stmt->error);
        }
        return true;
    }

    public function rejectArticle($articleId) {
        $stmt = $this->db->prepare("UPDATE articles SET modification_date = '1000-01-01 00:00:00' WHERE id = ?");
        $stmt->bind_param("i", $articleId);
        if (!$stmt->execute()) {
            throw new Exception("Error rejecting article: " . $stmt->error);
        }
        return true;
    }

    public function fetchComments($articleId) {
        $stmt = $this->db->prepare("SELECT Comment.*, Account.user_name FROM Comment JOIN Account ON Comment.account_id = Account.id WHERE article_id = ?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function addComment($articleId, $userId, $commentText) {
        $stmt = $this->db->prepare("INSERT INTO Comment (account_id, article_id, text_contnet) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $userId, $articleId, $commentText);
        if (!$stmt->execute()) {
            throw new Exception("Error adding comment: " . $stmt->error);
        }
    }    

    public function deleteComment($commentId) {
        $stmt = $this->db->prepare("DELETE FROM Comment WHERE id = ?");
        $stmt->bind_param("i", $commentId);
        if (!$stmt->execute()) {
            throw new Exception("Error deleting comment: " . $stmt->error);
        }
    }    
}
?>
