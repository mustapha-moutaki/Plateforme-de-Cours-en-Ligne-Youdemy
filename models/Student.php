<?php
namespace Models;

use Models\Model;
use Config\Database;
use PDO;
    class Student extends Model {
        protected $table = 'users';
        protected $pdo; 

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function countStudent($table) {
            return $this->countStudent($table); 
        }



        public function deleteStudent($id) {
            return $this->delete($this->table, 'id', $id);
        }

        
        public function getAllStudent() {
            return $this->selectStudent($this->table);
        }

        public function updateStatus($id, $status) {
            return $this->update($this->table, ['status' => $status], 'id', $id);
        }


    }

?>
