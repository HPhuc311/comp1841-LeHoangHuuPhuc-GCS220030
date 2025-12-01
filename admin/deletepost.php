<?php
// Use relative path to include files from the root directory
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

try {
    // Call deletePost function
    deletePost($pdo, $_POST['id']);
    
    // Redirect to admin post list
    header('location: posts.php');
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Unable to delete post: ' . $e->getMessage();
    // Update layout: Use admin_layout
    include __DIR__ . '/../templates/admin_layout.html.php'; 
}
?>