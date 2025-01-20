<?php
require_once '../../vendor/autoload.php';
use Config\Database; 
use Models\Tag;  
session_start();
$userId = $_SESSION['user_id'];
// Get the connection instance
$pdo = Database::makeConnection();  // Ensure the connection is successful

try {
    // Create an instance of Category model
    $TagModel = new Tag($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all categories
$getAllTags = $TagModel->getAllTags();

// If there's a delete request, process it
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if ($TagModel->deleteTag($deleteId)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/Tags/manageTags.php');
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
  <title>Manage Tags</title>
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
          <h2 class="text-dark">Manage Tags</h2>
          <a href="http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/tags/addTag.php"><button class="btn btn-primary" id="addTagButton">Add Tag</button></a>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-dark">
                  <tr>
                    <th class="text-center">ID</th>
                    <th>Tag Name</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
               
                  <?php  foreach ($getAllTags as $tag):?>
                  <tr>
                    <td class="text-center"><?= $tag['id'] ?></td>
                    <td><?= $tag['name'] ?></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-warning me-2"> <a href="editTag.php?update_tag=<?= $tag['id']; ?>">Edit</a></button>
                      <button class="btn btn-sm btn-danger"><a href="http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/Tags/manageTags.php?delete_id=<?php echo $tag['id']; ?>" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</a></button>
                    </td>
                  </tr>
                  <?php  endforeach;?>
                 
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
