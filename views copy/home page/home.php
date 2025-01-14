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
<body>

  
<header class="fixed inset-x-0 top-0 z-30 mx-auto w-full max-w-screen-md border border-gray-100 bg-white/80 py-3 shadow backdrop-blur-lg md:top-6 md:rounded-3xl lg:max-w-screen-lg">
    <div class="px-4">
        <div class="flex items-center justify-between">
            <div class="hidden md:flex md:items-center md:justify-center md:gap-5">
                <a class="inline-block rounded-lg px-2 py-1 text-sm font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100" href="#">How it works</a>
                <a class="inline-block rounded-lg px-2 py-1 text-sm font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100" href="#">Add Article</a>
            </div>
            <div class="flex items-center justify-end gap-3">
                <a class="hidden sm:inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50" href="/sign-up">Sign Up</a>
                <a class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-blue-500" href="/login">Login</a>
            </div>
        </div>
    </div>
</header>


<section class="text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="-my-8 divide-y-2 divide-gray-100">
            <?php if (empty($allArticles)): ?>
                <p class="text-center text-gray-500">No articles found</p>
            <?php else: ?>
           
                <?php foreach ($allArticles as $article): ?>
                     <?php if ($article['status']=='published'): ?>
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
                        </div>
                    </div>
                     <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
           
        </div>
    </div>
</section>

</body>
</html>
