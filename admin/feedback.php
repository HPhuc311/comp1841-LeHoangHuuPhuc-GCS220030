<?php
// File: admin/feedback.php
session_start();

// Check Admin login
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('location: login.php');
    exit();
}

include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php';

$title = 'Manage User Feedback';
$output = '';
$message = ''; // Used for success messages

// ----------------------------------------------------
// Process DELETING FEEDBACK
// ----------------------------------------------------
if (isset($_POST['feedback_id'])) {
    try {
        deleteFeedback($pdo, $_POST['feedback_id']);
        $message = 'Feedback has been successfully deleted!';
        // Redirect to clear POST data and display message
        header('location: feedback.php?deleted=true');
        exit();
    } catch (PDOException $e) {
        $title = 'Feedback Deletion Error';
        $output = 'Cannot delete feedback: ' . $e->getMessage();
        include __DIR__ . '/../templates/admin_layout.html.php';
        exit();
    }
}

// ----------------------------------------------------
// Process GET (READ: Fetch feedback list)
// ----------------------------------------------------
try {
    // Get all feedback
    $feedbacks = allFeedback($pdo); 
    $totalFeedbacks = totalFeedbacks($pdo);

    // Process notification after deletion
    if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
        $message = 'Feedback has been successfully deleted!';
    }
    
    ob_start();
    include __DIR__ . '/../templates/admin_feedback.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Data Query Error';
    $output = 'Cannot retrieve Feedback data: ' . $e->getMessage();
}

// Use Admin layout
include __DIR__ . '/../templates/admin_layout.html.php';
?>