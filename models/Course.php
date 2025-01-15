<?php
namespace Models;

use Models\Model;
use PDO;
//i have to chage class course to abstract course and n3iyt 3la tous lesmethodes createcourse  <<hna>>
class Course extends Model {
    protected $table = 'courses';
//<<han>>
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new course
   // In Course Model (Models/Course.php)


   //we can use magic methode call---------------------------------
    // had logic kaml khso ikon f extend classes vediocourse or ola nkhdem b call magic methode
    public function addCourse($title, $content, $meta_description, $category_id) {
            $sql = "INSERT INTO courses (title, content, meta_description, category_id)
                    VALUES (:title, :content, :meta_description, :category_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':meta_description' => $meta_description,
                ':category_id' => $category_id,
                ':content' => $content
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

class VideoCourse extends Course {
    public function addCourse($title, $content, $meta_description, $category_id) {
        $sql = "INSERT INTO video_courses (title, video_url, meta_description, category_id)
                VALUES (:title, :video_url, :meta_description, :category_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':video_url' => $content,
            ':meta_description' => $meta_description,
            ':category_id' => $category_id,
        ]);
        return $this->pdo->lastInsertId();
    }
}



class DocumentCourse extends Course {
    public function addCourse($title, $content, $meta_description, $category_id) {
        $sql = "INSERT INTO document_courses (title, document_path, meta_description, category_id)
                VALUES (:title, :document_path, :meta_description, :category_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':document_path' => $content,
            ':meta_description' => $meta_description,
            ':category_id' => $category_id,
        ]);
        return $this->pdo->lastInsertId();
    }














    public function getCourses($page, $limit) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM courses LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>