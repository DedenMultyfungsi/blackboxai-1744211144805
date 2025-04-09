<?php
require_once 'auth.php';
session_start();

// Redirect logged in users
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'] === 'teacher' ? 'teacher' : 'student';
    
    if (registerUser($username, $password, $role)) {
        $_SESSION['success_message'] = 'Registration successful! Please login.';
        header('Location: login.php');
        exit();
    } else {
        $error = 'Registration failed. Username may already exist.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">
                <i class="fas fa-user-plus mr-2"></i>Register
            </h1>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <div class="mt-1 flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="student" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Student</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="teacher" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Teacher</span>
                        </label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium transition duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Register
                    </button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <a href="login.php" class="text-blue-500 hover:text-blue-600 text-sm">
                    <i class="fas fa-sign-in-alt mr-1"></i>Already have an account? Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
