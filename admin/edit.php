<?php
require '../config/database.php';
require '../core/helpers.php';
require '../core/csrf.php';

if (!isAdmin()) {
    http_response_code(403);
    exit('Access denied');
}

$id = (int)($_GET['id'] ?? 0);

/* Fetch movie */
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) {
    exit('Movie not found');
}

/* Update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        exit('Invalid CSRF token');
    }

    $stmt = $pdo->prepare(
        "UPDATE movies 
         SET title = ?, genre = ?, release_year = ?, rating = ?, description = ?
         WHERE id = ?"
    );

    $stmt->execute([
        trim($_POST['title']),
        trim($_POST['genre']),
        (int)$_POST['release_year'],
        (float)$_POST['rating'],
        trim($_POST['description']),
        $id
    ]);

    header('Location: index.php');
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php include '../partials/admin_header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4 text-center">Edit Movie</h4>

            <form method="post">
                <input class="form-control mb-2" name="title" value="<?= e($movie['title']) ?>" required>
                <input class="form-control mb-2" name="genre" value="<?= e($movie['genre']) ?>" required>
                <input class="form-control mb-2" name="release_year" type="number" value="<?= $movie['release_year'] ?>" required>
                <textarea class="form-control mb-2" name="description" required><?= e($movie['description']) ?></textarea>
                <input class="form-control mb-3" name="rating" type="number" step="0.1" value="<?= $movie['rating'] ?>">

                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>