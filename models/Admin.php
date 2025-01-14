<?php
namespace Models;

use PDO;

class Admin extends User {
    public function __construct($db) {
        parent::__construct($db);
    }

    // Method to assign admin role to a user
    public function assignAdminRole($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = 'admin' WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to delete an article (any article)
    public function deleteArticle($articleId) {
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to accept an article (approve an author article)
    public function acceptArticle($articleId) {
        $stmt = $this->pdo->prepare("UPDATE articles SET status = 'approved' WHERE id = :id");
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Get tag by ID
    public function getTagById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tags WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get category by ID
    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all authors
    public function getAllAuthors() {
        $stmt = $this->pdo->query("SELECT author_id, name FROM authors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
