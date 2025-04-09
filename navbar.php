<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="dashboard.php" class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>School Exam System
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
                    <?php if ($_SESSION['user_role'] === 'teacher'): ?>
                        <a href="admin.php" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>Admin
                        </a>
                    <?php endif; ?>
                    <a href="logout.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                    <a href="register.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-user-plus mr-1"></i>Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
