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
 <?php
    include_once '../../public/components/sidebar.php';
  ?>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
      <h2 class="text-center mb-4">Add a New Tag</h2>

      <!-- Tag Suggestions -->
      <div class="mb-4">
        <strong>Suggested Tags:</strong> HTML, CSS, Database, Docker
      </div>

      <!-- Tag Addition Form -->
      <form action="add_tag.php" method="POST">
        <div class="mb-3">
          <input type="text" class="form-control" id="tagName" name="tagName" required placeholder="Enter tag name" autocomplete="off">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-info w-100">Add Tag</button>
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
