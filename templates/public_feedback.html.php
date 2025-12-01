<h2 class="mb-3">Send Feedback to Admin</h2>

<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        Thank you! Your feedback has been sent successfully.
    </div>
<?php endif; ?>

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

<form action="public_feedback.php" method="POST">

    <div class="mb-3">
        <label for="user_name" class="form-label">Name:</label>
        <input type="text" id="user_name" name="user_name" class="form-control" 
               value="<?= htmlspecialchars($_POST['user_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="user_email" class="form-label">Your email:</label>
        <input type="email" id="user_email" name="user_email" class="form-control" 
               value="<?= htmlspecialchars($_POST['user_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
    </div>

    <div class="mb-3">
        <label for="feedback_text" class="form-label">Feedback:</label>
        <textarea id="feedback_text" name="feedback_text" class="form-control" rows="5" required><?= htmlspecialchars($_POST['feedback_text'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
</form>