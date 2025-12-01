<?php
session_start();

// CHECK: If session 'loggedIn' does not exist or is not TRUE, redirect
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('location: login.php');
    exit();
}

try {
    // ... (includes and variables $title, $error_output)
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

$title = 'Manage User';
$error_output = ''; 
    // ----------------------------------------------------
    // Process POST (CREATE: Add new user)
    // UPDATED CHECK: Requires name AND email
    if (isset($_POST['name']) && !empty(trim($_POST['name'])) && isset($_POST['email']) && !empty(trim($_POST['email']))) {
        // UPDATED FUNCTION CALL: Pass email as well
        insertUser($pdo, $_POST['name'], $_POST['email']);
        
        header('location: user.php');
        exit();
    }
    // ... (READ section: fetching $users list and $totalUsers remains the same)
    
    $users = allUsers($pdo); 
    $totalUsers = count($users);

    ob_start();
    include __DIR__ . '/../templates/user.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    // Database error handling
    $title = 'Database Error';
    $output = 'Can not contact with Database: ' . $e->getMessage();
    $error_output = $output; 
}

include __DIR__ . '/../templates/admin_layout.html.php';
?>