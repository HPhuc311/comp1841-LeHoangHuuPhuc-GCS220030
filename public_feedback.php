<?php
include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php'; 

$title = 'Submit Feedback';
$errors = [];
$success = false;

if (isset($_POST['submit_feedback'])) {
    $userName = trim($_POST['user_name'] ?? '');
    $userEmail = trim($_POST['user_email'] ?? '');
    $feedbackText = trim($_POST['feedback_text'] ?? '');

    if (empty($userName)) {
        $errors[] = 'Name cannot be empty.';
    }
    if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    if (empty($feedbackText)) {
        $errors[] = 'Feedback content cannot be empty.';
    }

    if (empty($errors)) {
        try {
            // Call the new insertFeedback function
            insertFeedback($pdo, $userName, $userEmail, $feedbackText);
            $success = true;
            // Clear form content after successful submission to clean the form
            $_POST = []; 
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
} 

ob_start();
include __DIR__ . '/templates/public_feedback.html.php';
$output = ob_get_clean();

include __DIR__ . '/templates/layout.html.php';
?>