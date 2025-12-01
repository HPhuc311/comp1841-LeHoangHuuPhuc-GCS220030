<h2 class="mb-3">Manage Modules</h2>

<?php if (isset($error_output) && $error_output): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error_output ?>
    </div>
<?php endif; ?>

<h3 class="mt-4">Add New Module</h3>
<form action="module.php" method="POST" class="row g-3 align-items-center mb-5">
    <div class="col-md-4">
        <label for="moduleName" class="form-label">Name of Module:
            <input type="text" id="moduleName" name="moduleName" class="form-control" required>
        </label>
        
    </div>
    <div class="col-md-4">
        <button type="submit" name="submit" value="Add Module" class="btn btn-primary mt-1">Add Module</button>
    </div>
    <div class="col-md-4">
    </div>
</form>

<h3 class="mt-5">List of Modules (<?= $totalModules ?>)</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name of Module</th>
            <th>Operation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module): ?>
        <tr>
            <td><?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($module['moduleName'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <a href="editmodule.php?id=<?= $module['id'] ?>" class="btn btn-sm btn-info me-2">Edit</a>
                
                <form action="deletemodule.php" method="POST" class="d-inline" onsubmit="return confirm('Do you want to delete the module [<?= htmlspecialchars($module['moduleName']) ?>]?');">
                    <input type="hidden" name="id" value="<?= $module['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>