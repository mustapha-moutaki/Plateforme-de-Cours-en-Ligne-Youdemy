<?php
require_once '../vendor/autoload.php';

use Config\Database;
use Models\AbstractUser;
use Models\FormValidator;
use Models\User;

$pdo = Database::makeconnection();
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed!");
    }

    // Sanitize input
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $userType = $_POST['user_type'];

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password) || empty($userType)) {
        die("Please fill all inputs.");
    }

    $validator = new FormValidator();
    $validator->validateUsername($username);
    $validator->validateEmail($email);
    $validator->validatePassword($password);

    // Check for validation errors
    if ($validator->isValid()) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $user = new User(Database::makeconnection());
            $_SESSION['username'] = $username;

            if ($user->register($username, $email, $hashedPassword, $userType)) {
                $_SESSION['user_id'] = $user->getPdo()->lastInsertId();
                header('Location: /Plateforme-de-Cours-en-Ligne-Youdemy/public/dashboard.php');
                exit;
            } else {
                echo "Please try again.";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        foreach ($validator->getErrors() as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}
?>

<!--?php
require_once '../vendor/autoload.php';
use Config\Database;
use Models\User;

Database::makeconnection();
// Start the session for CSRF token handling
session_start();
// Generate a CSRF token if it's not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {

    // Check the CSRF token to prevent CSRF attacks
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed!");
    }

    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        // Instantiate the User class
        $user = new User(Database::makeconnection());
        $_SESSION['username'] = $username;
        // Register the user
        if ($user->register($username, $email, $password)) {
            echo "User registered successfully!";
            $userId = $user->getPdo()->lastInsertId();
    
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
        
            header('Location:../../admin/index.php');
            exit;
        } else {
            echo "Error: User could not be registered.";
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    
}


?-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
 
  <title>
  sign up
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

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('https://i.pinimg.com/736x/d1/54/66/d154660a6ae3104de2b0a314667a5ab6.jpg'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  <h4 class="font-weight-bolder">Sign Up</h4>
                  <p class="mb-0">Enter your email and password to register</p>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="input-group input-group-outline mb-3">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" name="username">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="email">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" class="form-control" name="password">
                    </div>

                    <div class="form-group">
    <label for="user_type">Choose User Type:</label><br>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="teacher" name="user_type" value="teacher" required>
        <label class="form-check-label" for="teacher">Teacher</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="student" name="user_type" value="student" required>
        <label class="form-check-label" for="student">Student</label>
    </div>
</div>








                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0" name="signup">Sign Up</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    Already have an account?
                    <a href="/Plateforme-de-Cours-en-Ligne-Youdemy/public/sign-in.php" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
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