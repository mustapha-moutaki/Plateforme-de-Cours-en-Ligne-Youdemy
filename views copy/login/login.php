<?php
require_once '../../vendor/autoload.php';

use App\Config\Database;
use App\Models\User;

session_start();

$db = Database::makeconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("error of checking csrf code!");
    }

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 

    try {
        $user = new User($db);
        $userData = $user->findByEmail($email);

        if ($userData && password_verify($password, $userData['password'])) {
            $_SESSION['user_id'] = $userData['id']; 
            $_SESSION['email'] = $userData['email'];

                if($email ==='mustaphastar06@gmail.com' && $password=123123){
                    header('Location:../../admin/index.php');
                    exit;
                }else{
                    header('Location:../../admin/index.php');
                }



        }else{
            echo"incorrect infos, please try again";
        }
        //     echo "login with success";

        //     header('Location:../../admin/index.php');
        //     exit;
        // } else {
        //     echo "incorrect infos, please try again";
        // }

    } catch (\Exception $e) {
        echo "error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<section class="bg-gray-50">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow border sm:max-w-md xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                  Login
              </h1>
              <form class="space-y-4 md:space-y-6" action="login.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                  </div>
                  <button type="submit" class="w-90 ml-40 text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" name="login">Login</button>
                  <p class="text-sm font-light text-gray-500">
                      Don't have an account? <a href="../signup/signup.php" class="font-medium text-primary-600 hover:underline">Sign up here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
</body>
</html>
