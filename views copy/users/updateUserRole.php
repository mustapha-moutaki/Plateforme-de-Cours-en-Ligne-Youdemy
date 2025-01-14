<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';

use App\Config\Database;
use App\Models\User;

$pdo = Database::makeconnection();
$roleModel = new User($pdo);

if (isset($_GET['update_role'])) {
    $updateId = $_GET['update_role'];

  
    $role = $roleModel->getUserById($updateId); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $tagName = $_POST['role'];


    if ($tagModel->updateRole($updateId, $tagName)) {
        header('Location: list_role.php');
        exit();
    } else {
        echo "Error updating the role.";
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT ROLE</title>
     <!-- Custom fonts for this template-->
     <link href="../../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../admin/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">
  <?php include '../../admin/components/sidebar.php'; ?>
<div class ="w-full h-screen flex justify-center items-center">
<form class="w-full max-w-sm" method="POST">
  <div class="flex items-center border-b border-teal-500 py-2">
  <?php if ($role): ?>
    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="update role" aria-label="role" name="role" value="<?= $role['role']; ?>">
    <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit" name="update_role">
      update
    </button>
  </div>
  <?php endif; ?>
</form>
</div>
</body>
</html>
