<?php
require_once 'auth.php';
require_once 'exam_functions.php';
session_start();

// Only allow teachers/admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

// Check exam ID
if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
}

$examId = (int)$_GET['id'];
$user = getUserById($_SESSION['user_id']);
$questions = getExamQuestions($examId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_question'])) {
        $questionText = trim($_POST['question_text']);
        $options = [
            'a' => trim($_POST['option_a']),
            'b' => trim($_POST['option_b']),
            'c' => trim($_POST['option_c']),
            'd' => trim($_POST['option_d'])
        ];
        $correctAnswer = trim($_POST['correct_answer']);
        
        if (addQuestion($examId, $questionText, $options, $correctAnswer)) {
            $_SESSION['success_message'] = 'Question added successfully!';
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
    <title>Edit Exam - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <i class="fas fa-edit mr-2 text-blue-500"></i>Edit Exam
                    </h2>
                    <a href="admin.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Exams
                    </a>
                </div>
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-plus-circle mr-2 text-blue-500"></i>Add Question
                    </h3>
                    <form method="POST" class="space-y-4">
                        <div>
                            <label for="question_text" class="block text-sm font-medium text-gray-700">Question Text</label>
                            <textarea id="question_text" name="question_text" rows="3" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="option_a" class="block text-sm font-medium text-gray-700">Option A</label>
                                <input type="text" id="option_a" name="option_a" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="option_b" class="block text-sm font-medium text-gray-700">Option B</label>
                                <input type="text" id="option_b" name="option_b" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="option_c" class="block text-sm font-medium text-gray-700">Option C</label>
                                <input type="text" id="option_c" name="option_c" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="option_d" class="block text-sm font-medium text-gray-700">Option D</label>
                                <input type="text" id="option_d" name="option_d" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700">Correct Answer</label>
                            <select id="correct_answer" name="correct_answer" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" name="add_question" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Add Question
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-list-ol mr-2 text-blue-500"></i>Exam Questions
                    </h3>
                    <?php if (count($questions) > 0): ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php foreach ($questions as $question): ?>
                                    <li>
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($question['question_text']); ?>
                                                </p>
                                            </div>
                                            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
                                                <div class="flex items-center">
                                                    <span class="inline-block w-4 h-4 rounded-full mr-2 <?php echo $question['correct_answer'] === 'a' ? 'bg-green-500' : 'bg-gray-300'; ?>"></span>
                                                    <p class="text-sm text-gray-600">A. <?php echo htmlspecialchars($question['option_a']); ?></p>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="inline-block w-4 h-4 rounded-full mr-2 <?php echo $question['correct_answer'] === 'b' ? 'bg-green-500' : 'bg-gray-300'; ?>"></span>
                                                    <p class="text-sm text-gray-600">B. <?php echo htmlspecialchars($question['option_b']); ?></p>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="inline-block w-4 h-4 rounded-full mr-2 <?php echo $question['correct_answer'] === 'c' ? 'bg-green-500' : 'bg-gray-300'; ?>"></span>
                                                    <p class="text-sm text-gray-600">C. <?php echo htmlspecialchars($question['option_c']); ?></p>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="inline-block w-4 h-4 rounded-full mr-2 <?php echo $question['correct_answer'] === 'd' ? 'bg-green-500' : 'bg-gray-300'; ?>"></span>
                                                    <p class="text-sm text-gray-600">D. <?php echo htmlspecialchars($question['option_d']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">No questions added yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
