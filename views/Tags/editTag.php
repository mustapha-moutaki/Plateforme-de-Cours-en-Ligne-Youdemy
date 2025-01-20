<?php
require_once '../../vendor/autoload.php';

use Config\Database;
use Models\Admin;
use Models\Tag;
session_start();
$userId = $_SESSION['user_id'];

$pdo = Database::makeconnection();
$tagModel = new Tag($pdo);

if (isset($_GET['update_tag'])) {
    $updateId = $_GET['update_tag'];

  
    $tag = $tagModel->getTagById($updateId); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tag'])) {
    $tagName = $_POST['tag'];


    if ($tagModel->updateTag($updateId, $tagName)) {
        header('Location: http://localhost/Plateforme-de-Cours-en-Ligne-Youdemy/views/tags/manageTags.php');
        exit();
    } else {
        echo "Error updating the tag.";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Tag</title>
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
      <h2 class="text-center mb-4">Edit Tag</h2>

      <!-- Tag Suggestions -->
      <div class="mb-4">
        <strong>Suggested Tags:</strong> HTML, CSS, Database, Docker
      </div>

      <!-- Tag Edit Form -->
      <form method="POST">
        <div class="mb-3">
        <?php if ($tag): ?>
          <input type="text" class="form-control" id="tagName" name="tag" required placeholder="Enter tag name" value="<?= $tag['name']; ?>" autocomplete="off">
             <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-info w-100" name="update_tag">Update Tag</button>
     
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
