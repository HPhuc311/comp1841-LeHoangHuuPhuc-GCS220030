<?php
include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php'; 

$title = 'User List';

try {
    // READ: Get the list of users using the available function
    $users = allUsers($pdo); 
    $totalUsers = count($users);

    ob_start();
    // Use read-only template
    include __DIR__ . '/templates/public_user.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Data Query Error';
    $output = 'Could not retrieve User data: ' . $e->getMessage();
}

// USE layout.html.php (public layout)
include __DIR__ . '/templates/layout.html.php';
?>