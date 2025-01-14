<?php
require_once '../../vendor/autoload.php';
use Config\Database;
use Models\Category;  


$pdo = new Database();
$categoryModel = new Category($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = htmlspecialchars(trim($_POST['category']));

    if (!empty($categoryName)) {

        $categoryModel->createCategory($categoryName);

        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/Categories/manageCategories.php');
        exit();
    } else {
        echo "category name cannot be empty!";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Categories</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php
    include_once '../../public/components/header.php';
  ?>
 <?php
    include_once '../../public/components/sidebar.php';
  ?>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
      <h2 class="text-center mb-4">Add a New Category</h2>

      <!-- Category Suggestions -->
      <div class="mb-4">
        <strong>Suggested Categories:</strong> Web Development, Design, Marketing, Data Science
      </div>

      <!-- Category Addition Form -->
      <form action="addCategory.php" method="POST">
        <div class="mb-3">
          <input type="text" class="form-control" id="categoryName" name="category" required placeholder="Enter category name" autocomplete="off">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-info w-100" name="add_category">Add Category</button>
      </form>
    </div>
  </div>
  <?php
    include_once '../../public/components/footer.php';
  ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
