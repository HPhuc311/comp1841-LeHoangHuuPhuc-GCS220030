<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <header class="bg-info text-white py-3 shadow-sm">
        <div class="container ">
            <h1 class="h3 my-5">Internet Post Database</h1>
            <nav class="bg-dark text-white text-center py-3 mt-4 d-flex justify-content-center">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="public_posts.php">Post List</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="public_addpost.php">Post New Article</a></li> 
                    <li class="nav-item"><a class="nav-link text-white" href="view_users.php">View Users</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="view_modules.php">View Modules</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="public_feedback.php">Send Feedback</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="admin/login.php">Admin Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container my-4 p-4 bg-white rounded shadow-sm overlow-hidden">
        <?= $output ?>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">&copy; <?= date('Y') ?> Internet Post Database</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>