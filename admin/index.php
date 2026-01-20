<?php
require '../config/database.php';
require '../core/csrf.php';
require '../core/helpers.php';

if (!isAdmin()) {
    http_response_code(403);
    exit('Access denied');
}

$movies = $pdo->query("SELECT * FROM movies ORDER BY id DESC")->fetchAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php include '../partials/admin_header.php'; ?>

<div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Admin · Movies</h3>
        <a href="create.php" class="btn btn-success">+ Add movie</a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped table-hover mb-0 text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Rating</th>
                        <th style="width: 160px">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($movies as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['title']) ?></td>
                            <td><?= htmlspecialchars($m['genre']) ?></td>
                            <td><?= $m['release_year'] ?></td>
                            <td><?= $m['rating'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="delete.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this movie?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>