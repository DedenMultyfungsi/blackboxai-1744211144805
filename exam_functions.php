<?php
require_once 'config.php';

function createExam($title, $description, $duration, $createdBy) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO exams (title, description, duration, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $description, $duration, $createdBy);
    
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    return false;
}

function addQuestion($examId, $questionText, $options, $correctAnswer) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $examId, $questionText, $options['a'], $options['b'], $options['c'], $options['d'], $correctAnswer);
    
    return $stmt->execute();
}

function getExamsByTeacher($teacherId) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, title, description, duration FROM exams WHERE created_by = ?");
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getExamQuestions($examId) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, question_text, option_a, option_b, option_c, option_d FROM questions WHERE exam_id = ?");
    $stmt->bind_param("i", $examId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function submitExamResults($userId, $examId, $score) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO results (user_id, exam_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $examId, $score);
    
    return $stmt->execute();
}

function getStudentResults($userId) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT r.id, e.title, r.score, r.completed_at 
                           FROM results r 
                           JOIN exams e ON r.exam_id = e.id 
                           WHERE r.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllResults() {
    $conn = getDBConnection();
    
    $result = $conn->query("SELECT r.id, u.username, e.title, r.score, r.completed_at 
                           FROM results r 
                           JOIN users u ON r.user_id = u.id 
                           JOIN exams e ON r.exam_id = e.id 
                           ORDER BY r.completed_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAvailableExams() {
    $conn = getDBConnection();
    
    $result = $conn->query("SELECT id, title, description, duration FROM exams");
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
