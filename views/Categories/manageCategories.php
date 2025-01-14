<?php
require_once '../../vendor/autoload.php';
use Config\Database;  
use Models\Category; 

$pdo = Database::makeConnection();  

try {
    $CategoryModel = new Category($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all categories
$getAllCategories = $CategoryModel->getAllCategories();

// If there's a delete request, process it
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if ($CategoryModel->deleteCategory($deleteId)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/categories/manageCategories.php');
        exit();
    } else {
        echo "Failed to delete the Tag.";
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
  <div class="container-fluid py-5">
    <div class="row">
      <!-- Sidebar Column -->
      <div class="col-md-3">
        <?php
         include_once '../../public/components/sidebar.php';
        ?>
      </div>

      <!-- Main Content Column -->
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="text-dark">Manage Categories</h2>
         <a href="http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/Categories/addCategory.php"> <button class="btn btn-success" id="addCategoryButton">Add Category</button></a>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-primary">
                  <tr>
                    <th class="text-center">ID</th>
                    <th>Category Name</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
           
                <?php  foreach ($getAllCategories as $category):?>
                  <tr>
                    <td class="text-center"><?= $category['id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-warning me-2"><a href="editCategory.php?update_category=<?= $category['id']; ?>">Edit</a></button>
                      <button class="btn btn-sm btn-danger"><a href="http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/categories/manageCategories.php?delete_id=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a></button>
                    </td>
                  </tr>
                 
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
