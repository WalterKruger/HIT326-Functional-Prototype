<?php
require_once 'Base.php';

class Article extends ModelBase {
    public function fetchAllApproved() {
        $query = "SELECT * FROM articles WHERE modification_date > creation_date ORDER BY modification_date DESC";
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function fetchTopArticles() {
        // This method will fetch the top articles based on some criteria, for example, the most recent approved articles
        $query = "SELECT * FROM articles WHERE modification_date > creation_date ORDER BY modification_date DESC LIMIT 5";
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
        // Fetch articles where creation and modification dates are the same
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

    // Since we can't use 'status', simulate rejection by setting modification date far in the past
    public function rejectArticle($articleId) {
        $stmt = $this->db->prepare("UPDATE articles SET modification_date = '1000-01-01 00:00:00' WHERE id = ?");
        $stmt->bind_param("i", $articleId);
        if (!$stmt->execute()) {
            throw new Exception("Error rejecting article: " . $stmt->error);
        }
        return true;
    }
}
?>
