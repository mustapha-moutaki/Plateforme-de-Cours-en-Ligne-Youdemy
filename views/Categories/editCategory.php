<?php
require_once '../../vendor/autoload.php';

use Config\Database;
use Models\Admin;
use Models\category;

$pdo = Database::makeconnection();
$categoryModel = new category($pdo);

if (isset($_GET['update_category'])) {
    $updateId = $_GET['update_category'];

  
    $category = $categoryModel->getCategoryById($updateId); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $categoryName = $_POST['category'];


    if ($categoryModel->updatecategory($updateId, $categoryName)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/categories/managecategories.php');
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
  <title>Edit category</title>
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
      <h2 class="text-center mb-4">Edit category</h2>

      <!-- category Suggestions -->
      <div class="mb-4">
        <strong>Suggested categorys:</strong> HTML, CSS, Database, Docker
      </div>

      <!-- category Edit Form -->
      <form method="POST">
        <div class="mb-3">
        <?php if ($category): ?>
          <input type="text" class="form-control" id="categoryName" name="category" required placeholder="Enter category name" value="<?= $category['name']; ?>" autocomplete="off">
             <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-info w-100" name="update_category">Update category</button>
     
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
