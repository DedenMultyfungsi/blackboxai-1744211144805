<?php
require_once 'auth.php';
require_once 'exam_functions.php';
session_start();

// Only allow teachers/admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);
$exams = getExamsByTeacher($_SESSION['user_id']);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_exam'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $duration = (int)$_POST['duration'];
        
        $examId = createExam($title, $description, $duration, $_SESSION['user_id']);
        if ($examId) {
            $_SESSION['success_message'] = 'Exam created successfully!';
            header("Location: exam_edit.php?id=$examId");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-chalkboard-teacher mr-2 text-blue-500"></i>Exam Management
                </h2>
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-plus-circle mr-2 text-blue-500"></i>Create New Exam
                    </h3>
                    <form method="POST" class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Exam Title</label>
                            <input type="text" id="title" name="title" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <input type="number" id="duration" name="duration" min="1" value="30" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <button type="submit" name="create_exam" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium transition duration-200">
                                <i class="fas fa-save mr-2"></i>Create Exam
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-list mr-2 text-blue-500"></i>Your Exams
                    </h3>
                    <?php if (count($exams) > 0): ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php foreach ($exams as $exam): ?>
                                    <li>
                                        <a href="exam_edit.php?id=<?php echo $exam['id']; ?>" class="block hover:bg-gray-50">
                                            <div class="px-4 py-4 sm:px-6">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-medium text-blue-600 truncate">
                                                        <?php echo htmlspecialchars($exam['title']); ?>
                                                    </p>
                                                    <div class="ml-2 flex-shrink-0 flex">
                                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            <?php echo $exam['duration']; ?> mins
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="mt-2 sm:flex sm:justify-between">
                                                    <div class="sm:flex">
                                                        <p class="flex items-center text-sm text-gray-500">
                                                            <?php echo htmlspecialchars($exam['description']); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">You haven't created any exams yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
