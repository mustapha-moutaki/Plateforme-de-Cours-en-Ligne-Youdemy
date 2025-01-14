<?php
require_once __DIR__ . '/../../includes/crud_functions.php';  
require_once '../../vendor/autoload.php';  
use App\Config\Database;  
use App\Models\User;  
use App\Models\Model;  

$pdo = Database::makeConnection();
try {
    $UserModel = new User($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$getAllUsers = $UserModel->getAllUsers();  

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $userId = $_GET['delete_id'];  

    $result = $UserModel->deleteUser($userId);
    header('Location: http://localhost/devblog_dashboard/views/users/users.php');
    exit;
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $updateId = $_POST['user_id'];
    $roleName = $_POST['role'];
    if ($UserModel->updateRole($updateId, $roleName)) {
      
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage users role</title>
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
    <h2 class="mb-4 text-2xl font-semibold leading-tight"><tt>MANAGE ALL users<tt></h2>
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
                    <th class="p-3">USERNAME</th>
                    <th class="p-3 text-center">EMAIL</th>
                    <th class="p-3 text-center">BIO</th>
                    <th class="p-3 text-center">ROLE</th>
                  
                    <th class="p-3 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php  foreach ($getAllUsers as $user):?>
                <tr class="border-b border-opacity-20 border-gray-300 bg-white">
                    <td class="p-3">
                        <p><?= $user['id'] ?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $user['username'] ?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $user['email'] ?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $user['bio'] ?></p>
                    </td>
                    <td class="p-3">
            <!-- Form for Updating Role -->
            <form method="POST" action="users.php">
                <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                <select name="role" class="border p-2">
                    <option value="author" <?= $user['role'] == 'author' ? 'selected' : '' ?>>Author</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
                <button type="submit" name="update_role" class="rounded-md bg-blue-500 text-white px-4 py-1 mt-2">
                    Save
                </button>
            </form>
        </td>

                    <td class="p-3">
                    <span class="rounded-md bg-red-500 text-white px-10 py-1"><a href="?delete_id=<?= $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this User?')">Delete</a>

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

