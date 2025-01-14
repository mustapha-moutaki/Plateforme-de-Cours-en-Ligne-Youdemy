<?php
namespace Models;

namespace Models;
use Models\Model;
use Config\Database;
use PDO;
    class Teacher extends Model {
        protected $table = 'users';
        protected $pdo; 

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function countTeachers() {
            return $this->countTeacher('users');
        }



        public function deleteTeacher($id) {
            return $this->delete($this->table, 'id', $id);
        }

        
        public function getAllTeachers() {
            return $this->selectTeachers($this->table);
        }

        public function updateStatus($id, $status) {
            return $this->update($this->table, ['status' => $status], 'id', $id);
        }

    }

?>
