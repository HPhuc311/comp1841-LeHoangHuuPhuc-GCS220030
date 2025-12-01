<?php


include __DIR__ . '/includes/DatabaseConnection.php'; 
include __DIR__ . '/includes/DatabaseFunctions.php'; 

$title = 'Post Publicly';
$errors = [];
$image_path = NULL; 

// Handle POST when the user clicks the "Post" button
if (isset($_POST['posttext']) && isset($_POST['moduleid']) && isset($_POST['userid'])) {
    
    $posttext = trim($_POST['posttext']);
    $userid = $_POST['userid'];
    $moduleid = $_POST['moduleid'];

    if (empty($posttext)) {
        $errors[] = 'The post content cannot be empty.';
    }

    // Handle Image Upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0) {
        $file = $_FILES['image_upload'];
        $upload_dir = 'img/'; // Image storage directory in the root
        $allowed_types = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // 1. Check size
        if ($file['size'] > $max_size) {
            $errors[] = 'Image size is too large (max 2MB).';
        }

        // 2. Check file type
        $file_info = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $file_info->file($file['tmp_name']);
        if (!array_key_exists($mime_type, $allowed_types)) {
            $errors[] = 'Invalid image format. Only JPG, PNG, GIF are accepted.';
        }

        // 3. If no errors, proceed to save the file
        if (empty($errors)) {
            // Create a unique filename to prevent duplicates
            $filename = uniqid('post_') . $allowed_types[$mime_type];
            $destination = $upload_dir . $filename;

            // Move the file
            if (move_uploaded_file($file['tmp_name'], $destination)) {
               $image_path = $upload_dir . $filename;
            } else {
                $errors[] = 'An error occurred while moving the uploaded file.';
            }
        }
    }

    // If there are no errors, insert the post into the DB
    if (empty($errors)) {
        try {
            // Call the updated insertPost function
            insertPost($pdo, $posttext, $userid, $moduleid, $image_path);
            
            // Redirect to the public posts list page
            header('location: public_posts.php');
            exit();
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
} 

// Handle GET (or if POST has errors)
try {
    // Get the list of Users and Modules to populate the Select Box
    $users = allUsers($pdo); 
    $modules = allModules($pdo); 
    
    ob_start();
    // New form template
    include __DIR__ . '/templates/public_addposts.html.php'; 
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Data Query Error';
    $output = 'Could not retrieve necessary data (user/module): ' . $e->getMessage();
}

// USE layout.html.php (public layout)
include __DIR__ . '/templates/layout.html.php';
?>