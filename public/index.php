<?php
require_once '../vendor/autoload.php';

use Config\Database;
use Models\Tag;
use Models\Category;
use Models\Course;
use Models\Teacher;
$pdo = new database();
$conn = $pdo ->makeconnection();

$categoryModel = new Category($pdo);
$tagModel = new Tag($pdo);
// $userModel = new user($pdo);
$courseModel = new Course($pdo);
$teacherModel = new Teacher($pdo);


// Get the counts of categories and tags
$categoryCount = $categoryModel->countCategories();   
$tagCount = $tagModel->countTags();  
$teacherCount = $teacherModel->countTeachers();  
$courseCount = $courseModel->countCourses();

try {
    $CategoryModel = new Category($pdo);
    $tagModel = new Tag($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all categories
$getAllCategories = $CategoryModel->getAllCategories();
$getAllTags = $tagModel->getAllTags();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yudemy</title>
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
            <a href="#" class="text-white hover:underline text-lg">Login</a>
            <a href="#" class="text-white hover:underline text-lg">Sign Up</a>
        </div>
    </header>

    <!-- Search & Filters Section -->
    <section class="bg-white p-6 shadow-lg mt-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
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
                    <select id="categoryFilter" class="bg-gray-100 p-2 rounded-lg shadow-sm">
                    <?php  foreach ($getAllCategories as $category):?>
                        <option value="">All</option>
                        <option value=""><?php echo $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="tagFilter" class="text-lg text-gray-700">Tags:</label>
                    <select id="tagFilter" class="bg-gray-100 p-2 rounded-lg shadow-sm">
                    <?php  foreach ($getAllTags as $tag):?>
                        <option value="">All</option>
                        <option value="frontend"><?php echo $tag['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
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
            <!-- Featured Course 1 -->
            <div class="course bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transform transition duration-300" data-category="web" data-tag="frontend">
                <img src="https://via.placeholder.com/300x200" alt="Course 1" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-indigo-800">Web Development</h3>
                    <p class="text-gray-600 mt-2">Learn how to build modern web applications using HTML, CSS, JavaScript, and frameworks.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <button class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">Learn More</button>
                    </div>
                </div>
            </div>

            <!-- Featured Course 2 -->
            <div class="course bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transform transition duration-300" data-category="python" data-tag="backend">
                <img src="https://via.placeholder.com/300x200" alt="Course 2" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-indigo-800">Python Programming</h3>
                    <p class="text-gray-600 mt-2">Start your programming journey with Python and build powerful applications.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <button class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">Learn More</button>
                    </div>
                </div>
            </div>

            <!-- Featured Course 3 -->
            <div class="course bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transform transition duration-300" data-category="data" data-tag="machine-learning">
                <img src="https://via.placeholder.com/300x200" alt="Course 3" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-indigo-800">Data Science</h3>
                    <p class="text-gray-600 mt-2">Learn data analysis, visualization, and machine learning techniques with Python and R.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <button class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-indigo-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Yudemy. All rights reserved.</p>
    </footer>

    <script>
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
    </script>

</body>
</html>
