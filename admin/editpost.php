<?php
// editpost.php
session_start();

// CHECK: If session 'loggedIn' does not exist or is not TRUE, redirect
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('location: login.php');
    exit();
}

// Use relative path to include files from the root directory
include __DIR__ . '/../includes/DatabaseConnection.php'; 
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

// ----------------------------------------------------------------------
// Process POST (UPDATE: Update data)
// ----------------------------------------------------------------------
if (isset($_POST['posttext']) && isset($_POST['userid']) && isset($_POST['moduleid'])) { 
    
    $postId = $_POST['id'];
    $posttext = $_POST['posttext'];
    $userid = $_POST['userid'];
    $moduleid = $_POST['moduleid'];
    $errors = [];

    // 1. Get current post to keep old image path or delete it
    $current_post = getPost($pdo, $postId); 
    $image_path = $current_post['image_path']; // Default to keeping old image
    
    // 2. Process NEW Image Upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0) {
        $file = $_FILES['image_upload'];
        $upload_dir = '../img/'; // Physical path from /admin/ to /img/
        $allowed_types = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // Check file size and type
        if ($file['size'] > $max_size) {
            $errors[] = 'Image size is too large (max 2MB).';
        }
        $mime_type = mime_content_type($file['tmp_name']);
        if (!isset($allowed_types[$mime_type])) {
            $errors[] = 'Invalid file type. Only JPG, PNG, GIF are accepted.';
        }

        if (empty($errors)) {
            $filename = uniqid('post_') . $allowed_types[$mime_type];
            $destination = $upload_dir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                
                // 3. DELETE OLD FILE (If a valid path exists)
                if (!empty($current_post['image_path'])) {
                    $old_file_path = __DIR__ . '/../' . $current_post['image_path'];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // 4. Update $image_path with the new path (RELATIVE from web root)
                $image_path = 'img/' . $filename; 

            } else {
                $errors[] = 'An error occurred while moving the uploaded file.';
            }
        }
    } 
    // ----------------------------------------------------------------------

    if (empty($errors)) {
        try {
            // Call updatePost function with the new $image_path parameter
            updatePost($pdo, $postId, $posttext, $userid, $moduleid, $image_path);
            
            // Redirect to admin post list
            header('location: posts.php'); 
            exit();
        } catch (PDOException $e) {
            $title = 'Error editing post';
            $output = 'Database error: ' . $e->getMessage();
            include __DIR__ . '/../templates/admin_layout.html.php'; 
            exit();
        }
    } else {
         // If there are errors, we need to reload data to display the form
         $post = getPost($pdo, $postId);
         $users = allUsers($pdo);
         $modules = allModules($pdo);
         $title = 'Edit Post Error';
         
         ob_start();
         // Pass $errors to the template
         include __DIR__ . '/../templates/admin_editpost.html.php'; 
         $output = ob_get_clean();
         
         include __DIR__ . '/../templates/admin_layout.html.php';
         exit();
    }
} else {
    // ----------------------------------------------------------------------
    // Process GET: Fetch post to display form
    // ----------------------------------------------------------------------
    if (!isset($_GET['id'])) {
        header('location: posts.php'); 
        exit();
    }
    
    try {
        $post = getPost($pdo, $_GET['id']);
        $users = allUsers($pdo);
        $modules = allModules($pdo);

        if (!$post) {
            throw new Exception("Post not found.");
        }

        $title = 'Edit Post';
        $errors = []; // Initialize empty errors array for initial load
        
        ob_start();
        include __DIR__ . '/../templates/admin_editpost.html.php'; 
        $output = ob_get_clean();
        
        include __DIR__ . '/../templates/admin_layout.html.php'; 
    } catch (Exception $e) {
        $title = 'Error loading post';
        $output = 'Error: ' . $e->getMessage();
        include __DIR__ . '/../templates/admin_layout.html.php'; 
    }
}
?>