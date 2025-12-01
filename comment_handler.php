<?php
// comment_handler.php

include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php'; 

// Handle POST when the user submits a comment
if (
    isset($_POST['postid']) && 
    isset($_POST['authorName']) && 
    isset($_POST['commentText'])
) {
    
    $postid = (int)$_POST['postid']; // Cast to int for better security
    $authorName = trim($_POST['authorName']);
    $commentText = trim($_POST['commentText']);

    // Simple validation
    if (empty($authorName) || empty($commentText)) {
        // Redirect back to the post list page with an error message (if desired)
        header('location: public_posts.php?error=empty_fields');
        exit();
    }

    try {
        // Insert comment into the DB
        insertComment($pdo, $postid, $authorName, $commentText);
        
        // Redirect back to the post list page
        header('location: public_posts.php');
        exit();
    } catch (PDOException $e) {
        // Handle database error
        $title = 'Comment Error';
        $output = 'Database error when adding comment: ' . $e->getMessage();
        include __DIR__ . '/templates/layout.html.php';
        exit();
    }
} else {
    // If accessed directly or data is missing, redirect to the post list
    header('location: public_posts.php');
    exit();
}
?>