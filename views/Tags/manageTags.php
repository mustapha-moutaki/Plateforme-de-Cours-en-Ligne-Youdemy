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
          <button class="btn btn-primary" id="addTagButton">Add Tag</button>
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
                  <!-- Example row -->
                  <tr>
                    <td class="text-center">1</td>
                    <td>Technology</td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-warning me-2">Edit</button>
                      <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td>Health</td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-warning me-2">Edit</button>
                      <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                  </tr>
                  <!-- More rows can go here -->
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
