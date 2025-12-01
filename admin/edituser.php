<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

// ----------------------------------------------------
// Process POST (UPDATE: Update user information)
// UPDATED CHECK: Requires id, name AND email
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
    try {
        // UPDATED FUNCTION CALL: Pass email as well
        updateUser($pdo, $_POST['id'], $_POST['name'], $_POST['email']);
        
        header('location: user.php');
        exit();
    } catch (PDOException $e) {
        $title = 'User Update Error';
        $output = 'Cannot update user: ' . $e->getMessage();
        include __DIR__ . '/templates/layout.html.php';
        exit();
    }
} 
// ----------------------------------------------------
// Process GET (Display Edit Form)
// ----------------------------------------------------
else {
    if (!isset($_GET['id'])) {
        header('location: user.php');
        exit();
    }

    try {
        $user = getUser($pdo, $_GET['id']);
        
        if (!$user) {
            throw new Exception("User not found with ID: " . $_GET['id']);
        }

        $title = 'Edit of user: ' . htmlspecialchars($user['name']);
        
        // Template for edit form (embedded inline)
        ob_start();
        ?>
        <h2 class="mb-4">Edit of User: <?= htmlspecialchars($user['name']) ?></h2>
        
        <form action="edituser.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">User Name:</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($user['email']) ?>" required> </div>
            
            <button type="submit" name="submit" value="Save Changes" class="btn btn-success">Save Changes</button>
            <a href="user.php" class="btn btn-secondary">Cancel</a>
        </form>
        <?php
        $output = ob_get_clean();
        include __DIR__ . '/../templates/admin_layout.html.php';
    } catch (Exception $e) {
        $title = 'User Query Error';
        $output = 'Error: ' . $e->getMessage();
        include __DIR__ . '/../templates/admin_layout.html.php';
    }
}
?>