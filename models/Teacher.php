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

       

    }

?>
