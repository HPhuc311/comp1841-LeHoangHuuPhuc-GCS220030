<h2 class="mb-3">Add New Post</h2>

<?php if (isset($errors) && count($errors) > 0): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Please check the following errors:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="posttext" class="form-label">Content of Post:</label>
        <textarea id="posttext" name="posttext" class="form-control" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="image_upload" class="form-label">Upload Images (JPG/PNG/GIF, max 2MB):</label>
        <input type="file" id="image_upload" name="image_upload" class="form-control" accept="image/jpeg,image/png,image/gif">
    </div>

    <div class="mb-3">
        <label for="userid" class="form-label">Select User:</label>
        <select name="userid" id="userid" class="form-select" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="moduleid" class="form-label">Select Module:</label>
        <select name="moduleid" id="moduleid" class="form-select" required>
            <?php foreach ($modules as $module): ?>
                <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" name="submit" value="Post" class="btn btn-success">Post</button>
</form>