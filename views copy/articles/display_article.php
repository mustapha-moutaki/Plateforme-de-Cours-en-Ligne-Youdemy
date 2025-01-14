<?php
require_once '../../vendor/autoload.php';

use App\Config\Database;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

// Establish Database Connection
$pdo = Database::makeconnection();
if (!$pdo) {
    die("Database connection failed.");
}
$articleModel = new Article($pdo);
$allArticles = $articleModel->getAllArticles();



if (isset($_SESSION['user_id'])) {
    $db = Database::makeConnection(); 
    $userModel = new User($db);

    $userId = $_SESSION['user_id'];  

    $user = $userModel->getUserById($userId);
}

if($_SERVER['REQUEST_METHOD'] =='GET' && isset($_GET['delete_id'])){
	$articleId = $_GET['delete_id'];
	$result = $articleModel->deleteArticle($articleId);
	header('Location:http://localhost/devblog_dashboard/views/articles/display_article.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="../../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="../../admin/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class='flex'>
<?php include '../../admin/components/sidebar.php'; ?>
<section class="text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="-my-8 divide-y-2 divide-gray-100">
			
            <?php if (empty($allArticles)): ?>
                <p class="text-center text-gray-500">No articles found</p>
            <?php else: ?>
                <?php foreach ($allArticles as $article): ?>
					
                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                        <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                            <span class="font-semibold title-font text-gray-700"><?= htmlspecialchars($article['category_name']) ?></span>
                            <span class="mt-1 text-gray-500 text-sm"><?= htmlspecialchars($article['created_at']) ?></span>
                        </div>
						
                        <div class="md:flex-grow">
                            <h2 class="text-2xl font-medium text-gray-900 title-font mb-2"><?= htmlspecialchars($article['title']) ?></h2>
                            <p class="leading-relaxed"><?= htmlspecialchars($article['content']) ?></p>
                            <a href="/article.php?id=<?= htmlspecialchars($article['id']) ?>" class="text-indigo-500 inline-flex items-center mt-4">
                                Learn More
                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
							<span class="rounded-md bg-red-500 text-white px-1 py-1 mr-1"><a href="?delete_id=<?= $article['id']; ?>" onclick="return confirm('Are you sure you want to delete this article?')"  style="text-decoration:none;color:white;">Delete</a>

							</span>

							<span class="rounded-md bg-green-500 text-white px-1 py-1 mr-1 "style="text-decoration:none; "><a href="?edit_id=<?= $article['id']; ?>" style="text-decoration:none; color:white;">Edit</a>

</span>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

</body>
</html>
