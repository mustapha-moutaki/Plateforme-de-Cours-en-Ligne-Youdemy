<?php
namespace Models;
use PDO;
class VideoCourse extends Course {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // Initialize the PDO instance
    }

    
    public function addCourse($title, $content, $meta_description, $category_id, $teacher_id) {
        $sql = "INSERT INTO courses (title, video_content, meta_description, category_id, teacher_id)
                VALUES (:title, :video_url, :meta_description, :category_id, :teacher_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':video_url' => $content,
            ':meta_description' => $meta_description,
            ':category_id' => $category_id,
            ':teacher_id' => $teacher_id,
        ]);
        return $this->pdo->lastInsertId();
    }


    public function addCourseTag($course_id, $tag_id) {
        $sql = "INSERT INTO course_tag (course_id, tag_id) VALUES (:course_id, :tag_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':course_id' => $course_id,
            ':tag_id' => $tag_id
        ]);
    }

    public function getAllCourses() {
        return $this->select($this->table);
    }

    public function getAllCoursesAccepted() {
        $where = "status = :status"; // Adding condition for accepted status
        $params = [':status' => 'accepted']; // Binding the 'accepted' status
        return $this->select($this->table, "*", $where, $params);
    }
    

    public function updateCourse($id, $title, $meta_description, $category) {
        return $this->update($this->table, [
            'title' => $title,
            'meta_description' => $meta_description,
            'name' => $category
        ], 'id', $id);
    }

    public function deleteCourse($id) {
        return $this->delete($this->table, 'id', $id);
    }

    public function getCoursesByUserId($userId) {
        $query = "SELECT * FROM {$this->table} WHERE teacher_id = :userId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCourseStatus($courseId, $status) {
        $sql = "UPDATE courses SET status = :status WHERE id = :course_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function getCoursesByPage($page, $limit) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE status = 'accepted' LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCourses() {
        return $this->count('courses');
    }

    public function updateStatus($courseId, $status) {
        
        $sql = "UPDATE courses SET status = :status WHERE id = :course_id";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    public function getMostEnrolledCourse($teacherId):array {
        $pdo = Database::makeConnection();
        $sql = "SELECT courses.title AS course_title, COUNT(course_enrollments.user_id) AS total_students
                FROM course_enrollments
                JOIN courses ON course_enrollments.course_id = courses.id
                WHERE courses.teacher_id = :teacherId
                GROUP BY courses.id
                ORDER BY total_students DESC
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT); // Bind teacherId
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the single result
        return $result ?: null; // Return result or null if no courses found
    }

    public function enrollCourse($userId, $courseId) {
        try {
            $checkSql = "SELECT COUNT(*) FROM course_enrollments WHERE user_id = :user_id AND course_id = :course_id";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([':user_id' => $userId, ':course_id' => $courseId]);
            $isEnrolled = $checkStmt->fetchColumn();

            if ($isEnrolled > 0) {
                return false; // User is already enrolled
            }

            $sql = "INSERT INTO course_enrollments (user_id, course_id) VALUES (:user_id, :course_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();

            return true; // Successfully enrolled
        } catch (PDOException $e) {
            error_log("Enrollment Error: " . $e->getMessage());
            return false; // Error during enrollment
        }
    }


    
    public function getCoursesById($userId) {
        $sql = "SELECT courses.*, course_enrollments.user_id, course_enrollments.course_status
                FROM courses 
                JOIN course_enrollments ON courses.id = course_enrollments.course_id 
                WHERE course_enrollments.user_id = :userId";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        // $stmt->bindParam(':course_status', $course_status, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    public function getTagsByCourseId($course_id){
        $sql = "SELECT t.id, t.name 
                FROM tags t 
                JOIN course_tag ct ON ct.tag_id = t.id 
                WHERE ct.course_id = :course_id";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['course_id' => $course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}