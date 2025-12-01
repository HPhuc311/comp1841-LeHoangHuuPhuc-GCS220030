<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

if (isset($_POST['id'])) {
    try {
        // Use existing deleteModule() function
        deleteModule($pdo, $_POST['id']);
        
        header('location: module.php');
        exit();
    } catch (PDOException $e) {
        $title = 'Module Deletion Error';
        
        // Handle Foreign Key Error (module is referenced in the post table)
        if ($e->getCode() == 23000 && strpos($e->getMessage(), '1451') !== false) {
             $output = 'This module cannot be deleted because it **has related posts**. Please delete (or reassign) those posts first.';
        } else {
             $output = 'Cannot delete module: ' . $e->getMessage();
        }
        
        include __DIR__ . '/../templates/admin_layout.html.php';
        exit();
    }
} else {
    header('location: module.php');
    exit();
}
?>