<?php
require_once 'auth.php';
require_once 'exam_functions.php';
session_start();

// Only allow students
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: login.php');
    exit();
}

// Check exam ID
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$examId = (int)$_GET['id'];
$user = getUserById($_SESSION['user_id']);
$questions = getExamQuestions($examId);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $totalQuestions = count($questions);
    
    foreach ($questions as $question) {
        $answerKey = 'question_' . $question['id'];
        if (isset($_POST[$answerKey]) && $_POST[$answerKey] === $question['correct_answer']) {
            $score++;
        }
    }
    
    $percentage = ($score / $totalQuestions) * 100;
    submitExamResults($_SESSION['user_id'], $examId, $percentage);
    
    $_SESSION['exam_result'] = [
        'score' => $score,
        'total' => $totalQuestions,
        'percentage' => $percentage
    ];
    
    header("Location: results.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-book-open mr-2 text-blue-500"></i>Exam
                </h2>
                
                <?php if (count($questions) > 0): ?>
                    <form method="POST" class="space-y-8">
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="bg-white p-6 rounded-lg shadow">
                                <div class="flex items-start">
                                    <span class="flex-shrink-0 bg-blue-500 text-white rounded-full h-6 w-6 flex items-center justify-center mr-3 mt-1">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium text-gray-900 mb-4">
                                            <?php echo htmlspecialchars($question['question_text']); ?>
                                        </p>
                                        <div class="space-y-3">
                                            <?php foreach (['a', 'b', 'c', 'd'] as $option): ?>
                                                <div class="flex items-center">
                                                    <input id="question_<?php echo $question['id']; ?>_<?php echo $option; ?>" 
                                                           name="question_<?php echo $question['id']; ?>" 
                                                           type="radio" 
                                                           value="<?php echo $option; ?>"
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                    <label for="question_<?php echo $question['id']; ?>_<?php echo $option; ?>" 
                                                           class="ml-3 block text-sm font-medium text-gray-700">
                                                        <?php echo strtoupper($option); ?>. <?php echo htmlspecialchars($question['option_' . $option]); ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-md font-medium transition duration-200">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Exam
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <p class="text-gray-500">No questions available for this exam.</p>
                        <a href="dashboard.php" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
