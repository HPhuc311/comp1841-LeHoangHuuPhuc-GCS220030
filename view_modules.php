<?php
include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php'; 

$title = 'List of Modules';

try {
    // READ: Get the list of modules using the available function
    $modules = allModules($pdo); 
    $totalModules = count($modules);

    ob_start();
    // Use read-only template
    include __DIR__ . '/templates/public_module.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Data Query Error';
    $output = 'Could not retrieve Modules data: ' . $e->getMessage();
}

// USE layout.html.php (public layout)
include __DIR__ . '/templates/layout.html.php';
?>