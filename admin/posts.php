<?php
session_start();

// CHECK: If session 'loggedIn' does not exist or is not TRUE, redirect
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('location: login.php');
    exit();
}

try {
    // Use relative path to include files from the root directory
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php'; 
    
    // Call allPosts function and update variable name
    $posts = allPosts($pdo); 
    $posts = array_reverse($posts);
    
    $title = 'Admin Post list'; 
    
    // Call totalPosts function and update variable name
    $totalPosts = totalPosts($pdo); 
    
    ob_start();
    // Template view: Update template name (for Admin)
    include __DIR__ . '/../templates/admin_posts.html.php'; 
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

// Update layout: Use admin_layout
include __DIR__ . '/../templates/admin_layout.html.php';
?>