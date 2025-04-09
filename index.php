<?php
require_once 'auth.php';
session_start();

// Redirect logged in users
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-3xl font-bold text-center mb-6 text-blue-600">
                <i class="fas fa-graduation-cap mr-2"></i>School Exam System
            </h1>
            <div class="flex flex-col space-y-4">
                <a href="login.php" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg text-center font-medium transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="register.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-lg text-center font-medium transition duration-200">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>
