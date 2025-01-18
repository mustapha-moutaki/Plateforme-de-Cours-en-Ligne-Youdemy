<?php
namespace Models;

use Models\Model;
use PDO;
//i have to chage class course to abstract course and n3iyt 3la tous lesmethodes createcourse  <<hna>>
abstract class Course extends Model {
    protected $table = 'courses';
//<<han>>
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // abstract public function addCourse($title, $content, $meta_description, $category_id);
   abstract  public function addCourse($title, $content, $meta_description, $category_id, $teacher_id);
        
      abstract  public function addCourseTag($course_id, $tag_id);


    // Method to fetch all courses
   abstract  public function getAllCourses();

    // Method to update course details
   abstract  public function updateCourse($id, $title, $description, $category);

    // Method to delete a course
    abstract public function deleteCourse($id);

    // Method to count the number of courses
    abstract public function countCourses();

    // Method to fetch a course by its ID
    abstract public function getCoursesByUserId($userId);

   
    abstract public function updateCourseStatus($courseId, $status);

    abstract public function getCoursesByPage($page, $limit);

    abstract function updateStatus($update_course_status, $statusName);
    // abstract public function getTotalCourses();
    abstract public function enrollCourse($userId, $courseId);
    
    abstract public function getCoursesById($userId);

}



// public function create_by_document($data) {
//     try {
//         $stmt = $this->pdo->prepare("
//             INSERT INTO cours 
//             (title, description, contenu, featured_image, category_id, enseignant_id, scheduled_date, created_at, updated_at, contenu_document, contenu_video)
//             VALUES (:title, :description, :contenu, :featured_image, :category_id, :enseignant_id, :scheduled_date, NOW(), NOW(), :contenu_document, NULL)
//         ");
//         $stmt->execute([
//             'title' => $data['title'],
//             'description' => $data['description'],
//             'contenu' => 'document',
//             'featured_image' => $data['featured_image'],
//             'category_id' => $data['category_id'],
//             'enseignant_id' => $data['enseignant_id'],
//             'scheduled_date' => $data['scheduled_date'],
//             'contenu_document' => $data['contenu_document'],
//         ]);

//         $courseId = $this->pdo->lastInsertId();

//         if (!empty($data['tags'])) {
//             $this->addTags($courseId, $data['tags']);
//         }

//         return $courseId;
//     } catch (PDOException $e) {
//         echo "Error creating course (document): " . $e->getMessage();
//         return false;
//     }
// }

// public function create_by_video($data, $type) {
//     try {
//         $stmt = $this->pdo->prepare("
//             INSERT INTO cours 
//             (title, description, contenu, featured_image, category_id, enseignant_id, scheduled_date, created_at, updated_at, contenu_document, contenu_video)
//             VALUES (:title, :description, :contenu, :featured_image, :category_id, :enseignant_id, :scheduled_date, NOW(), NOW(), NULL, :contenu_video)
//         ");
//         $stmt->execute([
//             'title' => $data['title'],
//             'description' => $data['description'],
//             'contenu' => $type,
//             'featured_image' => $data['featured_image'],
//             'category_id' => $data['category_id'],
//             'enseignant_id' => $data['enseignant_id'],
//             'scheduled_date' => $data['scheduled_date'],
//             'contenu_video' => $data['contenu_video'],
//         ]);

//         $courseId = $this->pdo->lastInsertId();

//         if (!empty($data['tags'])) {
//             $this->addTags($courseId, $data['tags']);
//         }

//         return $courseId;
//     } catch (PDOException $e) {
//         echo "Error creating course (video): " . $e->getMessage();
//         return false;
//     }
// }

// public function __call($name, $args) {
//     if ($name === "create") {
//         if (count($args) === 1) {
//             return $this->create_by_document($args[0]);
//         } elseif (count($args) === 2) {
//             return $this->create_by_video($args[0], $args[1]);
//         } else {
//             throw new Exception("Invalid number of arguments for create method.");
//         }
//     } elseif ($name === "readAll") {
//         if (count($args) === 0) {
//             return $this->readAll_by_document();
//         } elseif (count($args) === 1) {
//             return $this->readAll_by_video($args[0]);
//         } else {
//             throw new Exception("Invalid number of arguments for readAll method.");
//         }
//     }
// }

?>