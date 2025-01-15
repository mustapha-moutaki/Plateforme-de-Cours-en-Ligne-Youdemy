<?php
require_once '../../vendor/autoload.php';
use Config\Database;
use Models\Admin;
use Models\Category;
use Models\Tag;
use Models\Course;

$pdo = Database::makeConnection();

$categoryModel = new Category($pdo);
$categories = $categoryModel->getAllCategories();

$tagModel = new Tag($pdo);
$tags = $tagModel->getAllTags();

if (isset($_POST['add_course'])) {
    // Get form values
    echo"------------------------------------------------added-------------------------added";
    $title = $_POST['title'];
    $content = $_POST['content'];
    $meta_description = $_POST['meta_description'];
    $category_id = $_POST['category'];
    $tags = $_POST['tags'] ?? [];
    $content_type = $_POST['content_type'];

    // Initialize course model and create course
    $courseModel = new Course($pdo);
    
    try {
        $pdo->beginTransaction();

        
        $content = '';
        if ($content_type === 'video') {
            $content = $_POST['video_url']; 
        } elseif ($content_type === 'document') {
            // Handle document upload
            if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['document_file']['tmp_name'];
                $fileName = $_FILES['document_file']['name'];
                $fileDestPath = '../../uploads/' . $fileName;

                if (move_uploaded_file($fileTmpPath, $fileDestPath)) {
                    $content_data = $fileName; // Store document filename
                } else {
                    throw new Exception("Failed to upload document.");
                }
            } else {
                throw new Exception("No document uploaded or error occurred.");
            }
        }

        // Insert course data into database
        $course_id = $courseModel->addCourse($title, $content, $meta_description, $category_id);

        // Add tags (if any) associated with the course
        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $courseModel->addCourseTag($course_id, $tag_id);
            }
        }

        $pdo->commit();
        header("Location: http://localhost/devblog_dashboard/admin/index.php");
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
    <title>Create Course</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <style>
        .form-control, .form-select {
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #0a58ca;
            transform: translateY(-2px);
        }
        .btn-primary:active {
            background-color: #0d6efd;
            transform: translateY(0);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
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
                            <h1 class="card-title text-center mb-4">Create New Course</h1>
                            

                            <form id="courseForm" method="POST" enctype="multipart/form-data">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Course Title</label>
                                    <input type="text" class="form-control" id="title" required placeholder="Enter course title" name="title">
                                </div>

                                <!-- Description -->
                                <!-- <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Course Description</label>
                                    <textarea class="form-control" id="description" name="content" required></textarea>
                                </div> -->

                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" required></textarea>
                                </div>

                                <!-- Media URL or Document File -->
                                <div class="mb-3">
                                    <select name="content_type" id="">
                                        <option value="" name="video">video</option>
                                        <option value="" name="document">document</option>
                                    </select>

                                    <label for="mediaInput" class="form-label fw-semibold">Course Content (Video URL or Document File)</label>
                                    <input type="url" class="form-control" id="mediaUrl" placeholder="Enter video URL (YouTube, Vimeo, etc.)" name="video_url">
                                    <input type="file" class="form-control mt-3" id="mediaFile" name="document_file" accept=".pdf,.doc,.docx">
                                </div>

                                <div class="mb-3">
 

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                    <?php foreach ($categories as $category) : ?>
                                     <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                                     <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tags</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php foreach ($tags as $tag): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['id']) ?>" id="tag<?= $tag['id'] ?>">
                                                <label class="form-check-label" for="tag<?= $tag['id'] ?>"><?= $tag['name'] ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100" name="add_course">Publish Course</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once '../../public/components/footer.php'; ?>
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Initialize TinyMCE -->
    <!-- <script>
        tinymce.init({
            selector: '#description',
            plugins: 'lists link image media',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | outdent indent | link image media'
        });
    </script> -->
</body>
</html>
