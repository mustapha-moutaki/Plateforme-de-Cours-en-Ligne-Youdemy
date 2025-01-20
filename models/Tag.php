<?php
namespace Models;

use Models\Model;
use PDO;
    class Tag extends Model {
        protected $table = 'tags';
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        

        public function createTag($name) {
            return $this->create($this->table, ['name' => $name]);
        }
    
        public function getAllTags() {
            return $this->select($this->table);
        }
    
        public function updateTag($id, $name) {
            return $this->update($this->table, ['name' => $name], 'id', $id);
        }

    
        public function deleteTag($id) {
            return $this->delete($this->table, 'id', $id);
        }

        public function countTags() {
            return $this->count('tags');
        }


        public function getTagById($id) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function getAllTagsName() {
            $sql = "SELECT id, name FROM tags";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns array of tags
        }
        public function InsertTagsMasse($tags) {
            // Split tags into an array and remove duplicates
            $arraytags = array_unique(array_map('trim', explode(',', $tags)));
        
            // Use the create method to insert each tag
            foreach ($arraytags as $value) {
                $this->create('tags', ['name' => $value]);
            }
        }


        public function getAllTagsForCourses() {
            $sql = "SELECT c.id AS course_id, c.title AS course_title, 
                       GROUP_CONCAT(t.name SEPARATOR ', ') AS tags
                FROM courses c
                LEFT JOIN course_tag ct ON c.id = ct.course_id
                LEFT JOIN tags t ON ct.tag_id = t.id
                GROUP BY c.id";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }


            public function getAllTagsNameforcours() {
                $query = "SELECT tags.name AS tagname, tags.id 
                          FROM tags 
                          JOIN course_tag ON course_tag.tag_id = tags.id";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

//new modification
            public function get_tag($id) {

                $sql = "SELECT name FROM tags WHERE id = :id";
                $stmt = $pdo->prepare($sql);
              
                $stmt->bindParam(':id', $id);
              
                $stmt->execute();
              
              
                $tag = $stmt->fetch(PDO::FETCH_ASSOC);
              
                if ($tag) {
                    return $tag['name']; 
                }
                return null;
              }




              public function getTagsByCourseId($courseId) {
                $query = "SELECT t.name AS tagname 
                          FROM tags t 
                          JOIN course_tag ct ON ct.tag_id = t.id 
                          WHERE ct.course_id = :course_id";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['course_id' => $courseId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            public function deleteCourseTags($courseId) {
                                                       
                $stmt = $this->pdo->prepare("DELETE FROM course_tags WHERE course_id = :courseId");
                $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
                $stmt->execute();
            }

    }


?>