<h2><?= $title ?></h2>
<p><?= $totalPosts ?> posts have been submitted to the Internet Post Database.</p>

<?php foreach ($posts as $post): ?>
    <div class="post-card p-4 mb-4 bg-white rounded shadow-sm">

        <?php if (!empty($post['image_path'])): ?>
            <div class="post-image-container mb-3">
                <img src="./<?= htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                    alt="Post Image"
                    class="img-fluid rounded"
                    style="max-height: 250px; object-fit: cover;">
            </div>
        <?php endif; ?>

        <div class="post-body">
            <p class="mb-3 post-text-content">
                <?= nl2br(htmlspecialchars($post['posttext'], ENT_QUOTES, 'UTF-8')) ?>
            </p>

            <div class="post-meta-line small text-muted border-top pt-2">
                Posted by
                <span class="user-name-wrapper">
                    <span class="user-name"><?= htmlspecialchars($post['userName'], ENT_QUOTES, 'UTF-8') ?></span>
                </span>
                on <span><?= $post['postdate'] ?></span>
                in module <span class="badge bg-success"><?= htmlspecialchars($post['moduleName'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="">
                    <a class="btn btn-info btn-sm mt-2 me-2" href="public_editpost.php?id=<?= $post['id'] ?>">Edit</a>
                    <form action="public_deletepost.php" method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?= $post['id'] ?>">
                        <input class="btn btn-danger btn-sm mt-2" type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this post?');">
                    </form>
                </div>
            </div>
            
            <div class="comments-section border-top mt-3 pt-3">
                <h5 class="small mb-2">Comments:</h5>

                <?php if (!empty($post['comments'])): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($post['comments'] as $comment): ?>
                            <li class="mb-2 p-2 border rounded bg-light">
                                <p class="mb-0 small text-primary fw-bold">
                                    <?= htmlspecialchars($comment['authorName'], ENT_QUOTES, 'UTF-8') ?> 
                                    <span class="text-muted fw-normal fst-italic ms-2" style="font-size: 0.75rem;">
                                        on <span><?= $comment['commentDate'] ?></span>
                                    </span>
                                </p>
                                <p class="mb-0 small comment-text"><?= nl2br(htmlspecialchars($comment['commentText'], ENT_QUOTES, 'UTF-8')) ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted small">No comments yet.</p>
                <?php endif; ?>

                <form action="comment_handler.php" method="POST" class="mt-3 bg-light p-3 rounded">
                    <input type="hidden" name="postid" value="<?= $post['id'] ?>">
                    <div class="mb-2">
                        <label for="commenter_name_<?= $post['id'] ?>" class="form-label small mb-0">Your name:</label>
                        <input type="text" id="commenter_name_<?= $post['id'] ?>" name="authorName" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label for="comment_text_<?= $post['id'] ?>" class="form-label small mb-0">Comment content:</label>
                        <textarea id="comment_text_<?= $post['id'] ?>" name="commentText" class="form-control form-control-sm" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>