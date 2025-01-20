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

    
}
?>
