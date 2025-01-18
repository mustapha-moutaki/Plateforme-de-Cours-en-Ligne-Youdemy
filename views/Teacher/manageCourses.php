<?php
require_once '../../vendor/autoload.php';
use Config\Database; 
use Models\Course; 
use Models\VideoCourse; 
session_start();
// Get the connection instance
$pdo = Database::makeConnection();  // Ensure the connection is successful

try {
    // Create an instance of Course model
    $courseModel = new videocourse($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$userId = $_SESSION['user_id'];
// Fetch all courses

$getAllCourses = $courseModel->getCoursesByUserId($userId); 

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if ($courseModel->deleteCourse($deleteId)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/teacher/manageCourses.php');
        exit();
    } else {
        echo "Failed to delete the course.";
    }}

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
        $courseid = $_POST['course_id'];
        if ($studentModel->updateCourse($courseid)) {
          header("Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/student/managestudents.php");
          exit();
        }
      }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Manage Courses
  </title>
  
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include_once '../../public/components/sidebar.php'; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include_once '../../public/components/header.php'; ?>
    <!-- End Navbar -->

    <div class="container-fluid py-2">
    <a href="\Plateforme-de-Cours-en-Ligne-Youdemy\views\Courses\addCourse.php"><button class="btn btn-primary mb-4">Add Course</button></a>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                
                <h6 class="text-white text-capitalize ps-3">teacher: manage Courses</h6>
              </div>
            </div>

            <div class="card-body px-4 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-left mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($getAllCourses as $course): ?>
                    <tr>
                      <td><?php echo $course['id']; ?></td>
                      <td><?php echo $course['title']; ?></td>
                      <td><?php echo $course['meta_description']; ?></td>
                      <td>
                      <form method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                <a href="editCourse.php?edit_id=<?php echo $course['id']; ?>" class="btn btn-primary">
            Edit
        </a>

                    <button class="btn btn-sm btn-danger"><a href="?delete_id=<?php echo $course['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a></button>
            </form>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include_once '../../public/components/footer.php'; ?>
    </div>
  </main>
</body>

</html>
