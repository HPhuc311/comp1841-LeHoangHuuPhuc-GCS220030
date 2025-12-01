<?php

include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php';

// ----------------------------------------------------------------------
// Handle POST (UPDATE: Update data)
// ----------------------------------------------------------------------
if (isset($_POST['posttext']) && isset($_POST['userid']) && isset($_POST['moduleid'])) {
    
    $postId = $_POST['id'];
    $posttext = $_POST['posttext'];
    $userid = $_POST['userid'];
    $moduleid = $_POST['moduleid'];
    $errors = [];

    // 1. Get the current post
    $current_post = getPost($pdo, $postId); 
    $image_path = $current_post['image_path']; // Default to keeping the old image
    
    // 2. Handle NEW Image Upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0) {
        $file = $_FILES['image_upload'];
        $upload_dir = 'img/'; // Physical path from root directory to /img/
        $allowed_types = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // Check size and file type
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
                if (!empty($current_post['image_path']) && file_exists($current_post['image_path'])) {
                    // Since public_editpost.php is in the root, the path $current_post['image_path'] is correct
                    unlink($current_post['image_path']);
                }

                // 4. Update $image_path with the new path
                $image_path = $destination; 

            } else {
                $errors[] = 'An error occurred while moving the uploaded file.';
            }
        }
    } 
    // ----------------------------------------------------------------------

    if (empty($errors)) {
        try {
            // Call the updatePost function with the new $image_path parameter
            updatePost($pdo, $postId, $posttext, $userid, $moduleid, $image_path);

            // Redirect to the public post list
            header('location: public_posts.php');
            exit();
        } catch (PDOException $e) {
            $title = 'Error editing post';
            $output = 'Database error: ' . $e->getMessage();
            include __DIR__ . '/templates/layout.html.php';
            exit();
        }
    } else {
         // If there are errors, we need to reload the data to display the form
         $post = getPost($pdo, $postId);
         $users = allUsers($pdo);
         $modules = allModules($pdo);
         $title = 'Edit Post Error';
         
         ob_start();
         // Pass $errors to the template
         include __DIR__ . '/templates/admin_editpost.html.php'; // Use shared template
         $output = ob_get_clean();
         
         include __DIR__ . '/templates/layout.html.php';
         exit();
    }
} else {
    // ----------------------------------------------------------------------
    // Handle GET: Retrieve post to display the form
    // ----------------------------------------------------------------------
    if (!isset($_GET['id'])) {
        header('location: public_posts.php');
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
        $errors = []; // Initialize empty errors array for first load
        
        ob_start();
        // Template view: Update template name (using shared admin_editpost)
        include __DIR__ . '/templates/admin_editpost.html.php';
        $output = ob_get_clean();
        
        include __DIR__ . '/templates/layout.html.php';
    } catch (Exception $e) {
        $title = 'Error loading post';
        $output = 'Error: ' . $e->getMessage();
        include __DIR__ . '/templates/layout.html.php';
    }
}
?>