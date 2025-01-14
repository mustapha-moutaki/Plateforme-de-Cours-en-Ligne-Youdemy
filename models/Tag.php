<?php
namespace Models;

use Models\Model;
use PDO;
    class Tag extends Model {
        protected $table = 'tags';
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        

        public function createTag($name) {
            return $this->create($this->table, ['name' => $name]);
        }
    
        public function getAllTags() {
            return $this->select($this->table);
        }
    
        public function updateTag($id, $name) {
            return $this->update($this->table, ['name' => $name], 'id', $id);
        }

    
        public function deleteTag($id) {
            return $this->delete($this->table, 'id', $id);
        }

        public function countTags() {
            return $this->count('tags');
        }


        public function getTagById($id) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }


?>