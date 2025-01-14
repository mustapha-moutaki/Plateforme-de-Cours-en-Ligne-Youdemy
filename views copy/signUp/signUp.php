<?php
require_once '../../vendor/autoload.php';
use App\Config\Database;
use App\Models\User;

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


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<section class="bg-gray-50">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow border sm:max-w-md xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                  Create an account
              </h1>
              <form class="space-y-4 md:space-y-6" action="signup.php" method="POST">
              <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your name</label>
                      <input type="name" name="username" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="jhon oeh" required="">
                  </div>
                  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                  </div>
                
                   
                  <button type="submit" class=" w-90 ml-40 text-white bg-blue-700  font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" name="signup">create account</button>
                  <p class="text-sm font-light text-gray-500">
                      Already have an account? <a href="#" class="font-medium text-primary-600 hover:underline">Login here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>

</body>
</html>