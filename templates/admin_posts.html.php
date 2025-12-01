<h2><?= $title ?></h2>
<p><?= $totalPosts ?> posts have been submitted to the Internet Post Database.</p>


<?php foreach ($posts as $post): ?>
    <blockquote>
        <div class="post-content">
            <table class="table">
                <tbody>
                    <tr>
                        <?php if (!empty($post['image_path'])): ?>
                            <td><img src="../<?= htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Post Image"
                                    style="height: 100px; margin-bottom: 15px; border: 1px solid #ccc;">
                            </td>
                        <?php endif; ?>
                        <td> <?= htmlspecialchars($post['posttext'], ENT_QUOTES, 'UTF-8') ?>
                            (by
                            <span class="user-name-wrapper">
                                <span class="user-name"><?= htmlspecialchars($post['userName'], ENT_QUOTES, 'UTF-8') ?></span>
                            </span>)
                            on <?= $post['postdate'] ?>
                            in module <?= htmlspecialchars($post['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td> 
                            <a class="btn btn-info mb-2 px-4" href="editpost.php?id=<?= $post['id'] ?>">Edit </a>

                            <form action="deletepost.php" method="post">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <input class="btn btn-danger px-3" type="submit" value="Delete">
                                
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </blockquote>
<?php endforeach; ?>