<?php
namespace Models;

namespace Models;
use Models\Model;
use Config\Database;
use PDO;
    class Category extends Model {
        protected $table = 'Categories';
        protected $pdo; 

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function createCategory($name) {
            return $this->create($this->table, ['name' => $name]);
        }
    
        public function getAllCategories() {
            return $this->select($this->table);
        }
    
        public function updateCategory($id, $name) {
            return $this->update($this->table, ['name' => $name], 'id', $id);
        }
    
        public function deleteCategory($categoryId) {
            $sql = "DELETE FROM categories WHERE id = :id";
            $stmt = $this->pdo->prepare($sql); // Ensure $this->pdo is set
            return $stmt->execute(['id' => $categoryId]);
        }

        public function countCategories() {
            return $this->count('categories');
        }

        

        public function getCategoryById($id) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }



        public function getAllCategoriesName() {
            $query = "SELECT categories.name as categoryname, categories.id 
                      FROM categories 
                      JOIN courses ON courses.category_id = categories.id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>
