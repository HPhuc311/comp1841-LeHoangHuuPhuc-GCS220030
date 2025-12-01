<?php

session_start();

// CHECK: If session 'loggedIn' does not exist or is not TRUE, redirect
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('location: login.php');
    exit();
}



try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $title = 'Manage Modules';
    $error_output = '';
    // ----------------------------------------------------
    // Process POST (CREATE: Add new module)
    // ----------------------------------------------------
    if (isset($_POST['moduleName']) && !empty(trim($_POST['moduleName']))) {
        // Use existing insertModule() function
        insertModule($pdo, $_POST['moduleName']);

        // Redirect
        header('location: module.php');
        exit();
    }

    // ----------------------------------------------------
    // Process GET (READ: Get list of modules)
    // ----------------------------------------------------
    // Use existing allModules() function
    $modules = allModules($pdo);
    $totalModules = count($modules);

    ob_start();
    include __DIR__ . '/../templates/admin_module.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database Error';
    $output = 'Not connected with Database: ' . $e->getMessage();
    $error_output = $output;
}

// Use main layout
include __DIR__ . '/../templates/admin_layout.html.php';
