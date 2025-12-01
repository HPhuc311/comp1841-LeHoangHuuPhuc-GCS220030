<h2 class="mb-3">Manage Feedback (<?= $totalFeedbacks ?>)</h2>

<?php if ($totalFeedbacks > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Submission Date</th>
                    <th>Sender Name</th>
                    <th>Email</th>
                    <th>Feedback Content</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbacks as $feedback): ?>
                <tr>
                    <td><?= htmlspecialchars($feedback['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($feedback['submit_date'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($feedback['user_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($feedback['user_email'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($feedback['user_email'], ENT_QUOTES, 'UTF-8') ?></a></td>
                    <td><?= nl2br(htmlspecialchars($feedback['feedback_text'], ENT_QUOTES, 'UTF-8')) ?></td>
                    <td>
                         <form action="feedback.php" method="POST" class="d-inline" onsubmit="return confirm('Do you want to delete this feedback?');">
                            <input type="hidden" name="feedback_id" value="<?= $feedback['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info" role="alert">
        No feedback has been submitted yet.
    </div>
<?php endif; ?>