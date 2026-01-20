<?php
require '../config/database.php';
require '../core/helpers.php';
require '../core/csrf.php';

if (!isAdmin()) exit('Access denied');

if ($_POST) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) exit('Invalid CSRF');

    $stmt = $pdo->prepare(
        "INSERT INTO movies (title, genre, description, release_year, rating)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        trim($_POST['title']),
        trim($_POST['genre']),
        trim($_POST['description']),
        (int)$_POST['release_year'],
        (float)$_POST['rating']
    ]);

    header('Location: index.php');
    exit;
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php include '../partials/admin_header.php'; ?>

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-md-6 col-lg-5 col-xl-4">

            <div class="card movie-card shadow-sm">
                <div class="card-body">
                    <h4 class="movie-title text-center mb-4">Add Movie</h4>

                    <form method="post">
                        <div class="mb-3">
                            <input class="form-control" name="title" placeholder="Title" required>
                        </div>

                        <div class="mb-3">
                            <input class="form-control" name="genre" placeholder="Genre" required>
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" name="description" rows="4"
                                      placeholder="Description" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <input class="form-control" name="release_year" type="number" placeholder="Year" required>
                            </div>
                            <div class="col-6 mb-3">
                                <input class="form-control" name="rating" type="number" step="0.1" placeholder="Rating">
                            </div>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                        <div class="d-flex justify-content-between mt-3">
                            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                            <button class="btn btn-success px-4">Save</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
