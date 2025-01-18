<?php
require_once '../../vendor/autoload.php';

use Config\Database; 
use Models\DocumentCourse; 
use Models\Category; 

$pdo = Database::makeConnection();


$completedMessage = '';

try {
  
    $courseModel = new DocumentCourse($pdo);


    $courseId = $_GET['course_id'] ?? null;

    if ($courseId) {
        $course = $courseModel->getCourseById($courseId);
    } else {
        throw new Exception("Course ID is missing.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markAsCompleted'])) {
        $courseId = $_POST['course_id'];
        $newStatus = 'complete';

        if ($courseModel->updateCourseStatus($courseId, $newStatus)) {
            $completedMessage = "Course marked as completed successfully!";
            $course = $courseModel->getCourseById($courseId); 
        } else {
            throw new Exception("Failed to update course status.");
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Course Details</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <style>
    .rating {
      display: flex;
      justify-content: flex-start;
      margin-top: 10px;
    }
    .rating input {
      display: none;
    }
    .rating label {
      font-size: 30px;
      color: #ddd;
      cursor: pointer;
    }
    .rating input:checked ~ label {
      color: #f39c12;
    }
    .rating label:hover,
    .rating label:hover ~ label {
      color: #f39c12;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include_once '../../public/components/sidebar.php'; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php include_once '../../public/components/header.php'; ?>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"><?php echo $course['title']; ?></h6>
              </div>
            </div>

            <div class="card-body px-4 pb-2">
             

            <div class="course-container" style="width: 90%; margin: 0 auto;">
            <?php if($course['video_content'] == null): ?>
                    <p>content :</p>
                    <p class="border-1 border-primary p-3"><?php echo $course['document_content']; ?></p>
            <?php elseif($course['document_content'] == null): ?>
                <iframe src="<?php echo $course['video_content'];?>" frameborder="0"></iframe>
            <?php endif; ?>
        </div>

<style>
    .course-container {
        width: 90%; 
        margin: 0 auto;
    }

    .course-container iframe {
        width: 100%;
        height: 400px;
    }
</style>



              <div class="description mt-3">
                <strong>Description:</strong>
                <p><?php echo $course['meta_description']; ?></p>
              </div>
            
              <div class="course-info mt-3">
                <strong>Date:</strong> <?php echo date('Y', strtotime($course['created_at'])); ?><br>
                <strong>Teacher:</strong> <?php echo $course['teacher_id']; ?>
              </div>
              
              <div class="rating mt-4 align-items-center">
                <strong>Rate this course:</strong>
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1">&#9733;</label>
              </div>

              <div class="comment-section mt-4">
                <h5>Leave a Comment:</h5>
                <form action="" method="POST">
                  <textarea name="comment" rows="4" class="form-control" placeholder="Write your comment here..." required></textarea>
                  <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                  <div class="d-flex justify-content-between align-items-center ">
                    <button type="submit" class="btn btn-primary mt-2 me-2">Submit</button>
                    <button type="submit" name="markAsCompleted" class="btn btn-secondary mt-2">Mark as Completed</button>


                    <?php if ($completedMessage): ?>
                  <div class="alert alert-success mt-3">
                    <?php echo $completedMessage; ?>
                  </div>
                <?php endif; ?>


                </div>

                  
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include_once '../../public/components/footer.php'; ?>
  </main>
</body>
</html>
