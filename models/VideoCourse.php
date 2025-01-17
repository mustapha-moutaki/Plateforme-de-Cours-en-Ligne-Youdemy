<?php
namespace Models;
use PDO;
class VideoCourse extends Course {
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

    public function updateCourse($id, $title, $description, $category) {
        return $this->update($this->table, [
            'title' => $title,
            'description' => $description,
            'category' => $category
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
        $stmt = $this->pdo->prepare("SELECT * FROM courses LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCourses() {
        return $this->count('courses');
    }
    
    // public function getTotalCourses() {
    //     $db = \Config\Database::connect(); // Charge la connexion configurée
    //     $query = $db->query("SELECT COUNT(*) as total FROM courses");
    //     $result = $query->getRowArray();
    //     return $result['total'];
    // }
}
