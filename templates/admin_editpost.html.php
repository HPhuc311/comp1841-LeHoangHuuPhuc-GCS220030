<h2>Edit Post: <?= htmlspecialchars($post['posttext'], ENT_QUOTES, 'UTF-8') ?></h2>

<?php 
// Check for and display errors
if (isset($errors) && count($errors) > 0): ?>
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
    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">

    <label for="posttext" class="form-label">Type your post here:</label>
    <textarea id="posttext" name="posttext" class="form-control" rows="5"><?= htmlspecialchars($post['posttext'], ENT_QUOTES, 'UTF-8') ?></textarea>
    
    <div class="mb-3 mt-3">
        <label for="image_upload" class="form-label">Change Image (JPG/PNG/GIF, max 2MB):</label>
        
        <?php if (!empty($post['image_path'])): 
            // Determine the relative path for the image:
            // Admin: Needs ../ to go back to the root directory, as the template is in /templates/
            $image_display_path = '../' . $post['image_path'];
            ?>
            <div class="current-image-preview mb-2">
                <strong>Current Image:</strong><br>
                <img src="<?= htmlspecialchars($image_display_path, ENT_QUOTES, 'UTF-8') ?>" 
                     alt="Current Post Image" 
                     style="max-width: 200px; height: auto; border: 1px solid #ccc;">
            </div>
        <?php endif; ?>
        
        <input type="file" id="image_upload" name="image_upload" class="form-control" accept="image/jpeg,image/png,image/gif">
        <small class="form-text text-muted">Leave blank to keep current image. Image will be replaced if a new one is uploaded.</small>
    </div>
    <div class="mb-3">
        <label for="userid" class="form-label">Select User:</label>
        <select name="userid" id="userid" class="form-select">
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>"
                    <?php if ($user['id'] == $post['userid']) echo 'selected'; ?>>
                    <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="moduleid" class="form-label">Select Module:</label>
        <select name="moduleid" id="moduleid" class="form-select">
            <?php foreach ($modules as $module): ?>
                <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>"
                    <?php if ($module['id'] == $post['moduleid']) echo 'selected'; ?>>
                    <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" name="submit" value="Edit Post" class="btn btn-warning">Save Changes</button>
</form>