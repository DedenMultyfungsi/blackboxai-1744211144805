<?php
require_once 'auth.php';
require_once 'exam_functions.php';
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);
$results = ($_SESSION['user_role'] === 'teacher') 
    ? getAllResults() 
    : getStudentResults($_SESSION['user_id']);

// Check for exam result from just completed exam
$examResult = $_SESSION['exam_result'] ?? null;
if ($examResult) {
    unset($_SESSION['exam_result']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - School Exam System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-chart-bar mr-2 text-blue-500"></i>Exam Results
                </h2>
                
                <?php if ($examResult): ?>
                    <div class="bg-white p-6 rounded-lg shadow mb-8">
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Your Exam Result</h3>
                            <div class="flex justify-center items-center mb-4">
                                <div class="relative w-32 h-32">
                                    <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <path
                                            d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none"
                                            stroke="#e6e6e6"
                                            stroke-width="3"
                                            stroke-dasharray="100, 100"
                                        />
                                        <path
                                            d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none"
                                            stroke="<?php echo $examResult['percentage'] >= 70 ? '#10B981' : ($examResult['percentage'] >= 50 ? '#F59E0B' : '#EF4444'); ?>"
                                            stroke-width="3"
                                            stroke-dasharray="<?php echo $examResult['percentage']; ?>, 100"
                                        />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-2xl font-bold">
                                            <?php echo round($examResult['percentage']); ?>%
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600">
                                You scored <?php echo $examResult['score']; ?> out of <?php echo $examResult['total']; ?> questions.
                            </p>
                            <p class="mt-2 text-sm <?php echo $examResult['percentage'] >= 70 ? 'text-green-600' : ($examResult['percentage'] >= 50 ? 'text-yellow-600' : 'text-red-600'); ?>">
                                <?php echo $examResult['percentage'] >= 70 ? 'Excellent!' : ($examResult['percentage'] >= 50 ? 'Good attempt!' : 'Keep practicing!'); ?>
                            </p>
                            <a href="dashboard.php" class="mt-4 inline-block text-blue-500 hover:text-blue-700">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (count($results) > 0): ?>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Exam
                                    </th>
                                    <?php if ($_SESSION['user_role'] === 'teacher'): ?>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student
                                        </th>
                                    <?php endif; ?>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Score
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($results as $result): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($result['title']); ?>
                                        </td>
                                        <?php if ($_SESSION['user_role'] === 'teacher'): ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo htmlspecialchars($result['username']); ?>
                                            </td>
                                        <?php endif; ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php echo $result['score'] >= 70 ? 'bg-green-100 text-green-800' : 
                                                    ($result['score'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                                <?php echo round($result['score']); ?>%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('M j, Y', strtotime($result['completed_at'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <p class="text-gray-500">No results available yet.</p>
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
