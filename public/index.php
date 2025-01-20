<?php
require_once '../vendor/autoload.php';

use Config\Database;
use Models\Tag;
use Models\Category;
use Models\Course;
use Models\DocumentCourse;
use Models\Teacher;
$pdo = new database();

$categoryModel = new Category($pdo);
$tagModel = new Tag($pdo);
// $userModel = new user($pdo);
$courseModel = new DocumentCourse($pdo);
$teacherModel = new Teacher($pdo);

// Get the counts of categories and tags
$categoryCount = $categoryModel->countCategories();   
$tagCount = $tagModel->countTags();  
$teacherCount = $teacherModel->countTeachers();  
$courseCount = $courseModel->countCourses();

try {
    $CategoryModel = new Category($pdo);
    $tagModel = new Tag($pdo);
    $courseModel = new DocumentCourse($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all categories
$getAllCategories = $CategoryModel->getAllCategories();
$getAllTags = $tagModel->getAllTags();
$getAllCourses = $courseModel->getAllCourses();
$totalCourses = $courseModel->getAllCourses();

$limit = 6;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$courseCount = $courseModel->countCourses();

$totalPages = ceil($courseCount / $limit);

$courses = $courseModel->getCoursesByPage($page, $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/heroicons.min.js"></script>
</head>
<body class="font-roboto bg-gray-50">


    <!-- Header Section -->
    <header class="bg-indigo-800 text-white p-6 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-4">
            <!-- Logo -->
            <h1 class="text-4xl font-bold">Youdemy</h1>
        </div>
        <!-- Navigation: Login and Sign-up -->
        <div class="space-x-6">
            <a href="/Plateforme-de-Cours-en-Ligne-Youdemy/public/sign-in.php" class="text-white hover:underline text-lg">Login</a>
            <a href="/Plateforme-de-Cours-en-Ligne-Youdemy/public/sign-up.php" class="text-white hover:underline text-lg">Sign Up</a>
        </div>
    </header>

    <!-- Search & Filters Section -->
    <section class="bg-white p-6 shadow-lg mt-6">
        <div-- class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="relative w-full max-w-md">
                <input type="text" placeholder="Search courses..." class="w-full p-3 pl-12 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" id="searchInput">
                <div class="absolute top-0 left-0 mt-3 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>

            <div class="flex space-x-6">
                <div>
                    <label for="categoryFilter" class="text-lg text-gray-700">Category:</label>
                    <?php
                    // Retrieve selected values for category and tag filters
                    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
                    ?>
                    <select id="categoryFilter" class="bg-gray-100 p-2 rounded-lg shadow-sm">
                        <option value="">All</option>
                        <?php foreach ($getAllCategories as $category): ?>
                            <!-- Mark selected category -->
                            <option value="<?= htmlspecialchars($category['id']) ?>" 
                                    <?= $category['id'] == $selectedCategory ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

                <div>
                    <label for="tagFilter" class="text-lg text-gray-700">Tags:</label>
                    <select id="tagFilter" class="bg-gray-100 p-2 rounded-lg shadow-sm">
                    
                        <option value="">All</option>
                        <?php  foreach ($getAllTags as $tag):?>
                        <option value="frontend"><?php echo $tag['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </!--div>
        </div>
    </section>

    <!-- Hero Section with Image -->
    <section class="relative mt-8 h-50">
        <img src="https://i.pinimg.com/736x/33/60/5c/33605cdd29f8fa43b6be2be5718102c8.jpg" alt="Course Image" class="w-full h-64 object-cover rounded-lg shadow-md">
        <div class="absolute inset-0 bg-black opacity-50 flex justify-center items-center">
            <h2 class="text-white text-4xl font-semibold">Discover Your Next Course</h2>
        </div>
    </section>

    <!-- Featured Courses Section -->
<section class="p-8 bg-gray-100">
    <h2 class="text-3xl font-semibold text-center mb-6 text-indigo-800">Featured Courses</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="courseList">
    <?php foreach ($courses as $course): ?>
        <div class="course bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transform transition duration-300">
            
            <!-- Display video or document content -->
            <?php if (!empty($course['video_content'])): ?>
                <iframe src="<?= htmlspecialchars($course['video_content']); ?>" frameborder="0" class="w-full h-48 object-cover"></iframe>
                <div class="absolute inset-0 bg-black opacity-0" style="height:50%;"></div>
            <?php elseif (!empty($course['document_content'])): ?>
                <img src="https://i.pinimg.com/736x/1b/7b/e2/1b7be209fee3fd17943a981b5508384e.jpg" 
                     alt="Course Image" 
                     class="w-full h-48 object-cover">
                <p class="mt-2"><?= htmlspecialchars($course['document_content']); ?></p>
            <?php else: ?>
                <img src="default-placeholder-image.jpg" alt="Placeholder" class="w-full h-48 object-cover">
            <?php endif; ?>

            <!-- Course details -->
            <div class="p-6">
                <h3 class="text-2xl font-semibold text-indigo-800">
                    <?= htmlspecialchars($course['title'] ?? 'Untitled Course'); ?>
                </h3>
                <p class="text-gray-600 mt-2">
                    <?= htmlspecialchars($course['meta_description'] ?? 'No description available.'); ?>
                </p>
                <p>Instructor: <?= htmlspecialchars($course['teacher_name'] ?? 'Unknown'); ?></p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="sign-up.php" 
                       class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition duration-300 ease-in-out">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</section>

<div id="paginationControls" class="flex justify-center mt-6 space-x-4">
    <?php if ($totalPages > 1): ?>
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'bg-indigo-600 text-white' : 'bg-white text-indigo-600' ?> px-4 py-2 rounded-md hover:bg-indigo-700 hover:text-white"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Next</a>
        <?php endif; ?>
    <?php endif; ?>
</div>





    <!-- Footer Section -->
    <footer class="bg-indigo-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Yudemy. All rights reserved.</p>
    </footer>

    <!-- <script>
        // Function to filter courses based on search input and selected filters
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const tagFilter = document.getElementById('tagFilter');
            const courses = document.querySelectorAll('.course');

            // Function to filter courses based on input
            function filterCourses() {
                const searchQuery = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value.toLowerCase();
                const selectedTag = tagFilter.value.toLowerCase();

                courses.forEach(course => {
                    const title = course.querySelector('h3').textContent.toLowerCase();
                    const category = course.dataset.category.toLowerCase();
                    const tag = course.dataset.tag.toLowerCase();

                    const matchesSearch = title.includes(searchQuery);
                    const matchesCategory = selectedCategory ? category === selectedCategory : true;
                    const matchesTag = selectedTag ? tag === selectedTag : true;

                    if (matchesSearch && matchesCategory && matchesTag) {
                        course.style.display = '';
                    } else {
                        course.style.display = 'none';
                    }
                });
            }

            // Add event listeners
            searchInput.addEventListener('input', filterCourses);
            categoryFilter.addEventListener('change', filterCourses);
            tagFilter.addEventListener('change', filterCourses);
        });
    </script> -->
    <script>
    // Search filter logic
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const courses = document.querySelectorAll('.course');

        // Function to filter courses
        function filterCourses() {
            const searchQuery = searchInput.value.toLowerCase(); // Get search input
            
            courses.forEach(course => {
                const title = course.querySelector('h3').textContent.toLowerCase(); // Course title
                
                // Check if course matches the search query
                const matchesSearch = title.includes(searchQuery);

                // Show or hide the course based on the match
                course.style.display = matchesSearch ? '' : 'none';
            });
        }

        // Attach input event listener to search bar
        searchInput.addEventListener('input', filterCourses);
    });
</script>
</body>
</html>
