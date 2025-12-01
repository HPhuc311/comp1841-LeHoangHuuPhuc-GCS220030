<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

// Only process when ID is sent via POST
if (isset($_POST['id'])) {
    try {
        // deleteUser function is available in DatabaseFunctions.php
        deleteUser($pdo, $_POST['id']);
        
        // Redirect to list page
        header('location: user.php');
        exit();
    } catch (PDOException $e) {
        $title = 'User Deletion Error';
        // Foreign Key Error 1451: User is referenced in the post table.
        if ($e->getCode() == 23000 && strpos($e->getMessage(), '1451') !== false) {
             $output = 'This user cannot be deleted because they have related posts. Please delete (or reassign) previous posts.';
        } else {
             $output = 'Cannot delete user: ' . $e->getMessage();
        }
        
        include __DIR__ . '/../templates/admin_layout.html.php';
        exit();
    }
} else {
    // If no ID, redirect to user page
    header('location: user.php');
    exit();
}
?>