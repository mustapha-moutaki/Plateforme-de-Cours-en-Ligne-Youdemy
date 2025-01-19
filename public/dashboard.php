<?php
require_once '../vendor/autoload.php';

use Config\Database;
use Models\Tag;
use Models\Category;
use Models\Course;
use Models\VideoCourse;
use Models\DocumentCourse;
use Models\Teacher;
use Models\User;
$pdo = new database();
$conn = $pdo ->makeconnection();

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
  header('Location: sign-in.php');
  exit;
}

    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
$userRole = User::getUserRole($user_id);

$categoryModel = new Category($pdo);
$tagModel = new Tag($pdo);
$courseModel = new VideoCourse($pdo);
$teacherModel = new Teacher($pdo);


// Get the counts of categories and tags
$categoryCount = $categoryModel->countCategories();   
$getAllcategories = $categoryModel->getAllCategories();
$tagCount = $tagModel->countTags();  
$teacherCount = $teacherModel->countTeachers();  
$courseCount = $courseModel->countCourses(); 
$getAllCourses = $courseModel->getAllCoursesAccepted();
$coursemodelv = new DocumentCourse($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['joinCourse'])) {
  $userId = $_POST['user_id'];
  $courseId = $_POST['course_id'];

  // Enroll the user in the course
  $isEnrolled = $coursemodelv->enrollCourse($userId, $courseId);

  if ($isEnrolled) {
      header("Location: ../views/student/viewCourse.php?course_id=" . $courseId);
  }else {
    echo "
    <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
        <div style='font-family: Arial, sans-serif; background-color: #ffcc00; border: 1px solid #ffa500; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); text-align: center; max-width: 400px;'>
            <p style='margin: 0; font-size: 18px;'>You have already joined this course!</p>
            <br>
            <p>You can <a href='../views/student/mycourses.php' style='color: #007bff; text-decoration: none; font-weight: bold;'>check all your courses here</a>.</p>
        </div>
    </div>
    ";
}
  exit;
}
$userModel = new Teacher($pdo);
$countteacherCourses = $userModel ->  countTeacherCourses($user_id);

$totalstudentIncourse = $userModel -> joinCourses($user_id);

$teacherId = 3; // Example teacher ID
$courseData = $coursemodelv->getMostEnrolledCourse($teacherId);

$TopThreeTeachers = $userModel->topThreeTeachers($pdo);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
     Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
<?php
include_once './components/sidebar.php';
?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
   <?php
   include './components/header.php';
   ?>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
          <p class="mb-4">
            Check the courses, Teachers and Students.
          </p>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-uppercase text-primary font-weight-bold">Total Number of Courses</p>
                  <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
                  <h4 class="mb-0 text-dark"><?php echo $courseCount; ?></h4>
                  <?php endif; ?>
                 
                </div>
                <div class="icon icon-md icon-shape bg-gradient-primary text-white shadow text-center rounded-circle">
                  <i class="material-symbols-rounded">menu_book</i>
                </div>
              </div>
            </div>

            <hr class="horizontal my-0 bg-primary">
            <div class="card-footer p-3">
             
            </div>
          </div>
          
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-uppercase text-info font-weight-bold">Total Number of Tags</p>
                  <h4 class="mb-0 text-dark"><?php echo $tagCount; ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-info text-white shadow text-center rounded-circle">
                  <i class="material-symbols-rounded">label</i>
                </div>
              </div>
            </div>
            <hr class="horizontal my-0 bg-info">
            <div class="card-footer p-3">
              
            </div>
          </div>
          
          
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-uppercase text-warning font-weight-bold">Number of Categories</p>
                  <h4 class="mb-0 text-dark"><?php echo $categoryCount; ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-warning text-white shadow text-center rounded-circle">
                  <i class="material-symbols-rounded">category</i>
                </div>
              </div>
            </div>
            <hr class="horizontal my-0 bg-warning">
            <div class="card-footer p-3">
             
            </div>
          </div>
          
        </div>
        <div class="col-xl-3 col-sm-6">
        <div class="card">
  <div class="card-header p-3">
    <div class="d-flex justify-content-between">
      <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
        <div>
          <p class="text-sm mb-0 text-uppercase text-success font-weight-bold">Total Number of Teachers</p>
          <h4 class="mb-0 text-dark"><?php echo $teacherCount; ?></h4>
        </div>
      <?php elseif (isset($user['role']) && ($user['role'] == 'student' || $user['role'] == 'teacher')): ?>
        <div>
          <p class="text-sm mb-0 text-uppercase text-success">Top course</p>
          <h4 class="mb-0 text-dark text-md"><?php echo 'top course: '. $courseData['course_title']; ?></h4>
          <h4 class="mb-0 text-dark text-md"><?php echo 'student join: '.$courseData['total_students']; ?></h4>
        </div>
      <?php endif; ?>
      <div class="icon icon-md icon-shape bg-gradient-success text-white shadow text-center rounded-circle">
        <i class="material-symbols-rounded">school</i>
      </div>
    </div>
  </div>
  <hr class="horizontal my-0 bg-success">
  <div class="card-footer p-3"></div>
</div>

<div class="card">
            <div class="card-header p-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-uppercase text-primary font-weight-bold"> top 3 teachers</p>
                  <?php if (isset($user['role']) && $user['role'] == 'admin' || $user['role'] == 'teacher' || $user['role'] == 'student'): ?>
                    <?php foreach($TopThreeTeachers as $teachertop): ?>

                      <div class="teacher-info">
    <span class="teacher-name"><?php echo $teachertop['username']; ?></span>
    <span class="courses-count"><?php echo '('. $teachertop['total_courses'].')'; ?></span>
</div>

                  <?php endforeach; ?>
                  <?php endif; ?>
                 
                </div>
                <div class="icon icon-md icon-shape bg-gradient-primary text-white shadow text-center rounded-circle">
                <i class="material-symbols-rounded" style="color: white;">star</i>
                </div>
              </div>
            </div>

            <hr class="horizontal my-0 bg-primary">
            <div class="card-footer p-3">
             
            </div>
          </div>
          
        </div>
      </div>
      <div class="container my-5">
    <!-- Category Selection -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Courses</h2>
      <select class="form-select w-25" id="categorySelect" onchange="filterCourses()">
        <option value="all" selected>All Categories</option>
        <?php foreach($getAllcategories as $category): ?>
        <option value="web"><?php echo $category['name']?></option>
        <?php endforeach; ?>
      </select>
    </div>

      <!-- Courses Cards -->
      <div class="row" id="coursesContainer">
    <?php foreach($getAllCourses as $course): ?>
    <div class="col-md-4 mb-4 course-card" data-category="web">
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if($course['video_content'] != null): ?>
                    <!-- If video content exists -->
                    <iframe src="<?= $course['video_content']; ?>" frameborder="0" class="w-full h-48 object-cover"></iframe>
                <?php elseif($course['document_content'] != null): ?>
                    <!-- If document content exists (fallback image and document) -->
                    <img src="https://i.pinimg.com/736x/1b/7b/e2/1b7be209fee3fd17943a981b5508384e.jpg" 
                         alt="Course Image" 
                         class="w-full h-48 object-cover">
                    <p class="mt-2"><?= $course['document_content']; ?></p>
                <?php endif; ?>
                <h5 class="card-title"><?php echo $course['title'] ?></h5>
                <p class="card-text"><i>learn:</i><br><?php echo $course['meta_description'] ?></p>
                <form method="POST" action="">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                        <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
                        <button type="submit" name="joinCourse" class="btn btn-primary">
                        Join Course
                    </button>
                    </form>

                <!-- Button to redirect to course view page and enroll the user -->
             
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

     <?php
     include_once './components/footer.php';
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
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
      
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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
  <script>
    function filterCourses() {
      const selectedCategory = document.getElementById("categorySelect").value;
      const courses = document.querySelectorAll(".course-card");

      courses.forEach(course => {
        if (selectedCategory === "all" || course.getAttribute("data-category") === selectedCategory) {
          course.style.display = "block";
        } else {
          course.style.display = "none";
        }
      });
    }

  </script>
</body>

</html>