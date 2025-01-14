<?php
namespace Models;

use Models\Model;
use PDO;

class Course extends Model {
    protected $table = 'courses';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new course
   // In Course Model (Models/Course.php)

    public function addCourse($title, $content, $meta_description, $category_id, $content_data) {
            $sql = "INSERT INTO courses (title, content, meta_description, category_id, content_type, content_data)
                    VALUES (:title, :content, :meta_description, :category_id, :content_data)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':meta_description' => $meta_description,
                ':category_id' => $category_id,
                ':content_data' => $content_data
            ]);
            return $this->pdo->lastInsertId(); // Returns the last inserted course ID
        }

        public function addCourseTag($course_id, $tag_id) {
            $sql = "INSERT INTO course_tag (course_id, tag_id) VALUES (:course_id, :tag_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':course_id' => $course_id,
                ':tag_id' => $tag_id
            ]);
        }


    // Method to fetch all courses
    public function getAllCourses() {
        return $this->select($this->table);
    }

    // Method to update course details
    public function updateCourse($id, $title, $description, $category) {
        return $this->update($this->table, [
            'title' => $title,
            'description' => $description,
            'category' => $category
        ], 'id', $id);
    }

    // Method to delete a course
    public function deleteCourse($id) {
        return $this->delete($this->table, 'id', $id);
    }

    // Method to count the number of courses
    public function countCourses() {
        return $this->count('courses');
    }

    // Method to fetch a course by its ID
    public function getCourseById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>