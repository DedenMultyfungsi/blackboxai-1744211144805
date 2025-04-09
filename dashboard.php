<?php
require_once 'auth.php';
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>School Exam System
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($user['username']); ?></span>
                    <a href="logout.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>Dashboard
                </h2>
                
                <?php if ($user['role'] === 'teacher'): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="admin.php" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-chalkboard-teacher text-blue-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Exam Management</h3>
                                    <p class="text-gray-500 text-sm">Create and manage exams</p>
                                </div>
                            </div>
                        </a>
                        <a href="results.php" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-chart-bar text-green-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">View Results</h3>
                                    <p class="text-gray-500 text-sm">View student results</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="exam.php" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-book-open text-blue-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Take Exam</h3>
                                    <p class="text-gray-500 text-sm">Start a new exam</p>
                                </div>
                            </div>
                        </a>
                        <a href="results.php" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-award text-green-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">My Results</h3>
                                    <p class="text-gray-500 text-sm">View your exam results</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
