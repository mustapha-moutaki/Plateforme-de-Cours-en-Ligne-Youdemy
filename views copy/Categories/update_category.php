<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';
use App\config\Database;
use App\Models\Admin;
use App\Models\Category;
use App\Model;

$pdo = Database::makeconnection();
$categoryModel = new Category($pdo);

if (isset($_GET['update_category'])) {
  $updateId = $_GET['update_category'];

  // إنشاء اتصال بقاعدة البيانات
  $pdo = Database::makeconnection();
  $categoryModel = new Category($pdo);

  // جلب بيانات الفئة
  $category = $categoryModel->getCategoryById($updateId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
  $categoryName = $_POST['category'];

  if ($categoryModel->updateCategory($updateId, $categoryName)) {
      header('Location: list_categories.php');
      exit();
  } else {
      echo "Error updating the category.";
  }
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit category</title>
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
  <div class="flex items-center border-b border-blue-500 py-2">
  <?php if ($category): ?>
    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="update category" aria-label="category" name="category" value="<?= $category['name']; ?>">
    <button class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit" name="update_category">
      update
    </button>
  </div>
  <?php endif; ?>
</form>
</div>
<!-- Bootstrap core JavaScript-->
<script src="../../admin/vendor/jquery/jquery.min.js"></script>
    <script src="../../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../admin/js/demo/chart-area-demo.js"></script>
    <script src="../../admin/js/demo/chart-pie-demo.js"></script>
        

    <!-- Page level plugins -->
    <script src="../../admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../admin/js/demo/datatables-demo.js"></script>
</body>
</html>
