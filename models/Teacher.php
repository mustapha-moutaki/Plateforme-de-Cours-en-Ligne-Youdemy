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

        public function countTeacherCourses($teacherId) {
           $pdo = Database::makeconnection();
           $sql = "SELECT COUNT(*) FROM courses WHERE teacher_id = :teacherId";
           $stmt = $pdo->prepare($sql);
           $stmt ->bindvalue(':teacherId', $teacherId);
           $stmt ->execute();
           return $stmt->fetchColumn();
        }

        public function joinCourses($userId){
            $pdo = Database::makeConnection();
            $sql = "SELECT courses.id AS course_id, COUNT(course_enrollments.user_id) AS total_students
                    FROM course_enrollments
                    JOIN courses ON course_enrollments.course_id = courses.id
                    WHERE courses.teacher_id = :userId
                    GROUP BY courses.id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);  // Ensure userId is treated as an integer
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return results as an associative array
        }
        
        

    }

?>
