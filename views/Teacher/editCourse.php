<?php
require_once '../../vendor/autoload.php';
require_once '../../public/Helpers/utils.php';

use Config\Database;
use Models\Admin;
use Models\Category;
use Models\Tag;
use Models\Course;
use Models\VideoCourse;
use Models\DocumentCourse;

$pdo = Database::makeConnection();

$categoryModel = new Category($pdo);
$categories = $categoryModel->getAllCategories();

$tagModel = new Tag($pdo);
$tags = $tagModel->getAllTags();

$courseModel = new VideoCourse($pdo);

// Check if course ID is provided
if (!isset($_GET['edit_id'])) {
    die("Course ID is required.");
}

$courseId = $_GET['edit_id'];
$course = $courseModel->getCourseById($courseId);
// echo $course;
$tagsName = $tagModel->getAllTagsName();


if (!$course) {
    die("Course not found.");
}

if (isset($_POST['edit_course'])) {
    try {
        $pdo->beginTransaction();

        $title = $_POST['title'];
        $meta_description = $_POST['meta_description'];
        $category_id = $_POST['category'];
        $tags = $_POST['tags'] ?? [];
        $content_type = $_POST['content_type'];

        if ($content_type === 'video') {
            $content = convertToEmbedUrl($_POST['video_url']);
        } elseif ($content_type === 'document') {
            $content = convertToEmbedUrl($_POST['document']);
        } else {
            throw new Exception("Invalid content type selected.");
        }

        $courseModel->updateCourse($courseId, $title, $content, $meta_description, $category_id);

        // $courseModel->clearCourseTags($courseId);
        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $courseModel->addCourseTag($courseId, $tag_id);
            }
        }

        $pdo->commit();
        header("Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/Courses/EditCourse.php?course_id=$courseId");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles (same as before) */
    </style>
</head>
<body class="bg-light">
    <?php include_once '../../public/components/sidebar.php'; ?>

    <main class="main-content position-relative vh-100">
        <?php include_once '../../public/components/header.php'; ?>

        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h1 class="card-title text-center mb-4">Edit Course</h1>

                            <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Course Title</label>
                                    <input type="text" class="form-control" id="title" required 
                                           value="<?= htmlspecialchars($course['title']) ?>" 
                                           name="title">
                                </div>

                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" required><?= htmlspecialchars($course['meta_description']) ?></textarea>
                                </div>

                                <!-- Content Type -->
                                 <?php $course['docuemnt_cotent'] ?>
                                <div class="mb-3">
                                    <label for="content_type" class="form-label fw-semibold">Content Type</label>
                                    <select name="content_type" id="contentType" class="form-select" required>
                                        <option value="video">Video</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div>

                                <!-- Video URL or Document -->
                                <div class="mb-3">
                                <label for="mediaInput" class="form-label fw-semibold">Course Content (Video URL or Document)</label>
                                
                                <?php if (is_null($course['video_content'])): ?>
                                
                                    <textarea class="form-control" id="exampleTextarea" rows="5" name="document">
                                        <?= htmlspecialchars($course['document_content']) ?>
                                    </textarea>
                                <?php elseif (is_null($course['document_content'])): ?>
                                   
                                    <iframe src="<?= htmlspecialchars($course['video_content']) ?>" frameborder="0" class="w-100" height="300"></iframe>
                                    <input type="url" class="form-control mt-2" id="mediaUrl" name="video_url" 
                                        value="<?= htmlspecialchars($course['video_content']) ?>">
                                <?php endif; ?>
                               </div>


                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= htmlspecialchars($category['id']) ?>" 
                                                    <?= $category['id'] == $course['category_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                        <label class="form-label fw-semibold">Tags</label>
                        <div class="d-flex flex-wrap gap-3">
                            <?php foreach ($tags as $tag): ?>
                                <!-- Display tag names -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" 
                                        value="<?= htmlspecialchars($tag['id']) ?>" 
                                        id="tag<?= $tag['id'] ?>">
                                    <label class="form-check-label" for="tag<?= $tag['id'] ?>"><?= htmlspecialchars($tag['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100" name="edit_course">Update Course</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once '../../public/components/footer.php'; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
