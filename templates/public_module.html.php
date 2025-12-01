<h2 class="mb-3">List of Modules </h2>

<p><?= $totalModules ?> modules are available.</p>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Module</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module): ?>
        <tr>
            <td><?= htmlspecialchars($module['id'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($module['moduleName'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>