<?php
namespace Models;

use Models\Model;
use PDO;

abstract class Course extends Model {
    protected $table = 'courses';
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

    abstract public function getTagsByCourseId($course_id);

    // abstract public function getMostEnrolledCourse();
    abstract public function getTopThreeEnrolledCourses();

    abstract public function addComment($userId, $courseId, $commentText);

    abstract public function getAllComments();
    

}


?>