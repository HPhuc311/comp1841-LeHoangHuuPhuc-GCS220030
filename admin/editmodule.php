<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php'; 

// ----------------------------------------------------
// Process POST (UPDATE: Update module information)
// ----------------------------------------------------
if (isset($_POST['id']) && isset($_POST['moduleName'])) {
    try {
        // Use existing updateModule() function
        updateModule($pdo, $_POST['id'], $_POST['moduleName']);
        
        header('location: module.php');
        exit();
    } catch (PDOException $e) {
        $title = 'Module Update Error';
        $output = 'Cannot update module: ' . $e->getMessage();
        include __DIR__ . '/templates/layout.html.php';
        exit();
    }
} 
// ----------------------------------------------------
// Process GET (Display Edit Form)
// ----------------------------------------------------
else {
    if (!isset($_GET['id'])) {
        header('location: module.php');
        exit();
    }

    try {
        // Use existing getModule() function
        $module = getModule($pdo, $_GET['id']);
        
        if (!$module) {
            throw new Exception("Not found module have ID: " . $_GET['id']);
        }

        $title = 'Edit Module: ' . htmlspecialchars($module['moduleName']);
        
        ob_start();
        ?>
        <h2 class="mb-4">Edit Module: <?= htmlspecialchars($module['moduleName']) ?></h2>
        
        <form action="editmodule.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($module['id']) ?>">
            
            <div class="mb-3">
                <label for="moduleName" class="form-label">Name of Module:</label>
                <input type="text" id="moduleName" name="moduleName" class="form-control" 
                       value="<?= htmlspecialchars($module['moduleName']) ?>" required>
            </div>
            
            <button type="submit" name="submit" value="Save Changes" class="btn btn-success">Save Changes</button>
            <a href="module.php" class="btn btn-secondary">Cancel</a>
        </form>
        <?php
        $output = ob_get_clean();
        include __DIR__ . '/../templates/admin_layout.html.php';
    } catch (Exception $e) {
        $title = 'Module Query Error';
        $output = 'Error: ' . $e->getMessage();
        include __DIR__ . '/../templates/admin_layout.html.php';
    }
}
?>