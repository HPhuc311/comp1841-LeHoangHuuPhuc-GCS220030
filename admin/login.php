<?php
// File: admin/login.php

// 1. START SESSION & INCLUDES
session_start();
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

// 2. INITIALIZE VARIABLES (BUG FIX: $output)
$title = 'Admin Login';
$error_output = '';
$output = ''; // Initialize to prevent Warning: Undefined variable

// 3. CHECK IF ALREADY LOGGED IN
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header('location: posts.php');
    exit();
}

// ----------------------------------------------------
// 4. Process POST (Login)
// ----------------------------------------------------
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // SIMPLE AUTHENTICATION
    if ($email === 'admin@example.com' && $password === 'admin') {
        
        // Successful login
        $_SESSION['loggedIn'] = true;
        
        // Redirect
        header('location: posts.php');
        exit();
    } else {
        $error_output = 'Email or password incorrect';
    }
}

// ----------------------------------------------------
// 5. Process GET (Display Form)
// ----------------------------------------------------
ob_start();
// Form template
include __DIR__ . '/templates/login.html.php';
$output = ob_get_clean();

// 6. USE SIMPLE LOGIN LAYOUT
include __DIR__ . '/templates/login_layout.html.php';
?>