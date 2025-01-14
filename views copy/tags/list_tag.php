<?php
require_once __DIR__ . '/../../includes/crud_functions.php';  // Import necessary files
require_once '../../vendor/autoload.php';  // Autoload necessary classes
use App\Config\Database;  // Use the correct namespace for Database
use App\Models\Tag;  // Import the Category model

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
        header('Location: list_tag.php');
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
    <title>add_tags_form</title>
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
<div class="container p-2 mx-auto sm:p-4 text-black bg-white">
    <h2 class="mb-4 text-2xl font-semibold leading-tight"><tt>MANAGE ALL TAGS<tt></h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-1xl">
            <colgroup>
                <col style="width: 33%;">
                <col style="width: 33%;">
                <col style="width: 10%;">
            </colgroup>
            <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="p-3">ID#</th>
                    <th class="p-3">TAG NAME</th>
                    <th class="p-3 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php  foreach ($getAllTags as $tag):?>
                <tr class="border-b border-opacity-20 border-gray-300 bg-white">
                    <td class="p-3">
                        <p><?= $tag['id'] ?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $tag['name'] ?></p>
                    </td>
                    <td class="p-3">
                        <span class=" font-semibold  flex justify-around gap-10">
                            <span class="rounded-md bg-blue-500 text-white px-10 py-1">
                            <a href="update_tag.php?update_tag=<?= $tag['id']; ?>">Edit</a>
                            </span>
                            <span class="rounded-md bg-red-500 text-white px-10 py-1"><a href="http://localhost/devblog_dashboard/views/tags/list_tag.php?delete_id=<?php echo $tag['id']; ?>" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</a>

                              
                            </span>
                        </span>
                    </td>
                </tr>
                <?php  endforeach;?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

