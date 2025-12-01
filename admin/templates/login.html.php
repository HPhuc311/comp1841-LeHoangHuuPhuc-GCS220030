<div class="row justify-content-center">
    <div class="col-md-6 bg-success shadow p-3 mb-5 bg-body-tertiary rounded">
        <h2 class="mb-4">Admin Login</h2>
        <p> Email: admin@example.com <br>
            Pass :  admin
        </p>
        <?php if ($error_output): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_output) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>