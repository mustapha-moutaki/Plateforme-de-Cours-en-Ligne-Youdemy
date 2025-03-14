<?php
require_once '../../vendor/autoload.php';
use Config\Database; 
use Models\Course; 
use Models\VideoCourse; 
use Models\DocumentCourse; 
use Models\Tag; 
use Models\Category; 
session_start();
$userId = $_SESSION['user_id'];
// Get the connection instance
$pdo = Database::makeConnection();  // Ensure the connection is successful

try {
    // Create an instance of Category model
    $courseModel = new videocourse($pdo);
    $tagModel = new Tag($pdo);
    $categoryModel = new Category($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


// Fetch all categories
$getAllCourses = $courseModel->getAllCourses();
$getAllTagsName =$tagModel->getAllTagsName();
$AllCategoriesName =$categoryModel->getAllCategoriesName();

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if ($courseModel->deleteCourse($deleteId)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/courses/manageCourses.php');
        exit();
    } else {
        echo "Failed to delete the course.";
    }
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update_course_status'])){
  $update_course_status = $_POST['course_id'];
  $statusName = $_POST['status'];
  if ($courseModel->updateStatus($update_course_status, $statusName)) {
    header("Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/courses/manageCourses.php");
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
    manage teachers
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />

 
</head>



<body class="g-sidenav-show  bg-gray-100">
  <?php
  include_once '../../public/components/sidebar.php';
  ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
    include_once '../../public/components/header.php';
    ?>
    <!-- End Navbar -->
    <div class="container my-5">
    <h2 class="mb-4">Manage Courses</h2>
   
    <!-- <a href="addCourse.php"><button class="btn btn-primary mb-4">Add Course</button></a> -->
  
    <!-- Courses Table -->
    <table class="table table-sm table-bordered table-hover text-center align-middle">
  <thead class="table-dark">
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
      <th scope="col">Created At</th>
      <th scope="col">Tags</th>
      <th scope="col">Action</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody id="courseTableBody">
    <?php foreach ($getAllCourses as $course): ?>
    <tr>
      <!-- Title -->
      <td class="text-truncate" style="max-width: 150px;"><?php echo $course['title']; ?></td>

      <!-- Description -->
      <td class="text-truncate" style="max-width: 200px;"><?php echo $course['meta_description']; ?></td>

      <!-- Category -->
      <td>
        <?php 
          $categoryName = ''; 
          foreach ($AllCategoriesName as $category) {
              if ($category['id'] == $course['category_id']) {
                  $categoryName = $category['categoryname']; 
                  break; 
              }
          }
          echo $categoryName; 
        ?>
      </td>

      <!-- Created At -->
      <?php 
        $date = new DateTime($course['created_at']);
        $formattedDate = $date->format('Y-m');
      ?>
      <td><?php echo $formattedDate; ?></td>

      <!-- Tags -->
      <td>
        <?php 
          $tags = $tagModel->getTagsByCourseId($course['id']);
          foreach ($tags as $tag) {
              echo "<span class='badge bg-warning text-dark me-1'>{$tag['tagname']}</span>";
          }
        ?>
      </td>

      <!-- Actions -->
      <td>
        <button class="btn btn-danger btn-sm">
          <a href="http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/courses/manageCourses.php?delete_id=<?php echo $course['id']; ?>" class="text-white text-decoration-none" onclick="return confirm('Are you sure you want to delete this course?')">
            Delete
          </a>
        </button>
      </td>

      <!-- Status -->
      <td>
        <form action="" method="POST" class="d-inline">
          <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
          <select class="form-select form-select-sm" name="status">
            <option value="refused" <?php echo ($course['status'] === 'refused') ? 'selected' : ''; ?>>Refused</option>
            <option value="accepted" <?php echo ($course['status'] === 'accepted') ? 'selected' : ''; ?>>Accepted</option>
            <option value="pending" <?php echo ($course['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
          </select>
          <button type="submit" name="update_course_status" class="btn btn-primary btn-sm mt-2">
            Save
          </button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  </div>

<?php
  include_once '../../public/components/footer.php';
  ?>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>