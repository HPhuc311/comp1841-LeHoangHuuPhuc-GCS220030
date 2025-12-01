<?php
try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    include __DIR__ . '/includes/DatabaseFunctions.php'; 
    
    $posts = allPosts($pdo); 
    
    // ADDED: Get comments for each post
    foreach ($posts as &$post) {
        // Get comments for the current post
        $post['comments'] = getCommentsByPostId($pdo, $post['id']);
    }
    unset($post); // Very important to break the reference

    $title = 'Post list';
    $totalPosts = totalPosts($pdo); 
    
    ob_start();
    // CHANGED: Use the public template, without the Admin button
    include __DIR__ . '/templates/public_posts.html.php'; 
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

// USE layout.html.php (public layout)
include __DIR__ . '/templates/layout.html.php';
?>