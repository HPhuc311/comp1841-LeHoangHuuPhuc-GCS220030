<h2 class="mb-3">List of Users</h2>

<p><?= $totalUsers ?> registered users.</p>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($user['name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($user['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>