<?php
// START: REUSABLE QUERY FUNCTION
function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    if ($query === false) {
        // Throw an exception if SQL preparation fails
        throw new Exception("SQL Prepare Failed: " . $sql);
    }
    // Execute the prepared statement
    $query->execute($parameters);
    return $query;
}

// --------------------------------------------------------------------------------
// POST FUNCTIONS
// --------------------------------------------------------------------------------

// Count total posts
function totalPosts($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM post');
    $row = $query->fetch();
    return $row[0];
}

// Fetch all posts (Includes JOIN for User Name and Module Name)
function allPosts($pdo) {
    $sql = 'SELECT 
                post.id, post.posttext, post.postdate, post.image_path,
                user.id AS userid, user.name AS userName, 
                module.id AS moduleid, module.moduleName
            FROM 
                post
            INNER JOIN 
                user ON post.userid = user.id
            INNER JOIN 
                module ON post.moduleid = module.id
            ORDER BY 
                post.postdate DESC'; // Newest posts first
    $query = query($pdo, $sql);
    return $query->fetchAll();
}

// Fetch a single post by ID
function getPost($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = 'SELECT * FROM post WHERE id = :id';
    $query = query($pdo, $sql, $parameters);
    return $query->fetch();
}

// Insert a new post (Updated to include image_path)
function insertPost($pdo, $posttext, $userid, $moduleid, $image_path = NULL) {
    $parameters = [
        ':posttext' => $posttext,
        ':postdate' => date('Y-m-d H:i:s'), // Current date/time
        ':userid' => $userid,
        ':moduleid' => $moduleid,
        ':image_path' => $image_path // New parameter for image path
    ];
    $sql = 'INSERT INTO post (posttext, postdate, userid, moduleid, image_path) 
            VALUES (:posttext, :postdate, :userid, :moduleid, :image_path)';
    query($pdo, $sql, $parameters);
}

// Update an existing post (Updated to handle image_path)
function updatePost($pdo, $id, $posttext, $userid, $moduleid, $image_path = NULL) {
    $parameters = [
        ':id' => $id,
        ':posttext' => $posttext,
        ':userid' => $userid,
        ':moduleid' => $moduleid,
        ':image_path' => $image_path 
    ];
    $sql = 'UPDATE post SET 
                posttext = :posttext, 
                userid = :userid, 
                moduleid = :moduleid, 
                image_path = :image_path 
            WHERE id = :id';
    query($pdo, $sql, $parameters);
}

// Delete a post by ID
function deletePost($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM post WHERE id = :id', $parameters);
}


// --------------------------------------------------------------------------------
// USER FUNCTIONS
// --------------------------------------------------------------------------------

// Count total users
function totalUsers($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM user');
    $row = $query->fetch();
    return $row[0];
}

// Fetch all users
function allUsers($pdo) {
    $query = query($pdo, 'SELECT * FROM user');
    return $query->fetchAll();
}

// Insert a new user
function insertUser($pdo, $name, $email) {
    $parameters = [':name' => $name, ':email' => $email];
    $sql = 'INSERT INTO user (name, email) VALUES (:name, :email)';
    query($pdo, $sql, $parameters);
}

// Fetch a single user by ID
function getUser($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = 'SELECT * FROM user WHERE id = :id';
    $query = query($pdo, $sql, $parameters);
    return $query->fetch();
}

// Update an existing user
function updateUser($pdo, $id, $name, $email) {
    $parameters = [':id' => $id, ':name' => $name, ':email' => $email];
    $sql = 'UPDATE user SET name = :name, email = :email WHERE id = :id';
    query($pdo, $sql, $parameters);
}

// Delete a user by ID
function deleteUser($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM user WHERE id = :id', $parameters);
}


// --------------------------------------------------------------------------------
// MODULE FUNCTIONS
// --------------------------------------------------------------------------------

// Count total modules
function totalModules($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM module');
    $row = $query->fetch();
    return $row[0];
}

// Fetch all modules
function allModules($pdo) {
    $query = query($pdo, 'SELECT * FROM module');
    return $query->fetchAll();
}

// Insert a new module
function insertModule($pdo, $moduleName) {
    $parameters = [':moduleName' => $moduleName];
    $sql = 'INSERT INTO module (moduleName) VALUES (:moduleName)';
    query($pdo, $sql, $parameters);
}

// Fetch a single module by ID
function getModule($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = 'SELECT * FROM module WHERE id = :id';
    $query = query($pdo, $sql, $parameters);
    return $query->fetch();
}

// Update an existing module
function updateModule($pdo, $id, $moduleName) {
    $parameters = [':id' => $id, ':moduleName' => $moduleName];
    $sql = 'UPDATE module SET moduleName = :moduleName WHERE id = :id';
    query($pdo, $sql, $parameters);
}

// Delete a module by ID
function deleteModule($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM module WHERE id = :id', $parameters);
}

// --------------------------------------------------------------------------------
// FEEDBACK FUNCTIONS
// --------------------------------------------------------------------------------

// Insert new feedback
function insertFeedback($pdo, $userName, $userEmail, $feedbackText) {
    $parameters = [
        ':user_name' => $userName, 
        ':user_email' => $userEmail, 
        ':feedback_text' => $feedbackText,
        ':submit_date' => date('Y-m-d H:i:s')
    ];
    $sql = 'INSERT INTO feedback (user_name, user_email, feedback_text, submit_date) 
            VALUES (:user_name, :user_email, :feedback_text, :submit_date)';
    query($pdo, $sql, $parameters);
}

// Fetch all feedback
function allFeedback($pdo) {
    $sql = 'SELECT * FROM feedback ORDER BY submit_date DESC';
    $query = query($pdo, $sql);
    return $query->fetchAll();
}

// Delete feedback by ID
function deleteFeedback($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM feedback WHERE id = :id', $parameters);
}

// Count total feedbacks
function totalFeedbacks($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM feedback');
    $row = $query->fetch();
    return $row[0];
}

// --------------------------------------------------------------------------------
// COMMENT FUNCTIONS
// --------------------------------------------------------------------------------

// Fetch all comments for a specific post
function getCommentsByPostId($pdo, $postId) {
    $parameters = [':postid' => $postId];
    // Order by date DESC so the newest comment is at the top
    $sql = 'SELECT id, authorName, commentText, commentDate FROM comment WHERE postid = :postid ORDER BY commentDate DESC';
    $query = query($pdo, $sql, $parameters);
    return $query->fetchAll();
}

// Insert a new comment
function insertComment($pdo, $postId, $authorName, $commentText) {
    $sql = 'INSERT INTO comment (postid, authorName, commentText, commentDate) 
            VALUES (:postid, :authorName, :commentText, NOW())'; // Use NOW() for current time
    $parameters = [
        ':postid' => $postId, 
        ':authorName' => $authorName, 
        ':commentText' => $commentText
    ];
    query($pdo, $sql, $parameters);
}
?>