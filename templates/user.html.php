<h2 class="mb-3">Manage Users</h2>


<h3 class="mt-4">Add New User</h3>
<form action="user.php" method="POST" class="row g-3 align-items-center mb-5">
    <div class="col-md-4">
        <label for="name" class="form-label">User: <input type="text" id="name" name="name" class="form-control" required></label>
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">
            Email: <input type="email" id="email" name="email" class="form-control" required>
        </label>
    </div>
    <div class="col-md-4">
        <button type="submit" name="submit" value="Add User" class="btn btn-primary mt-1">Add User</button>
    </div>
</form>

<h3 class="mt-5">List of Users (<?= $totalUsers ?>)</h3>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="edituser.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info me-2">Edit</a>

                        <form action="deleteuser.php" method="POST" class="d-inline" onsubmit="return confirm('Do you want to delete user [<?= htmlspecialchars($user['name']) ?>]?');">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>