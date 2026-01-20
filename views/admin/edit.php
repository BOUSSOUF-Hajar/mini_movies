<?php include './partials/admin_header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4 text-center">Edit Movie</h4>

            <?php if (!empty($errors ?? [])): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <div><?= htmlspecialchars($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <input class="form-control mb-2" name="title" value="<?= htmlspecialchars($movie['title'] ?? '') ?>" required>
                <input class="form-control mb-2" name="genre" value="<?= htmlspecialchars($movie['genre'] ?? '') ?>" required>
                <input class="form-control mb-2" name="release_year" type="number" value="<?= htmlspecialchars($movie['release_year'] ?? '') ?>" required>
                <textarea class="form-control mb-2" name="description" required><?= htmlspecialchars($movie['description'] ?? '') ?></textarea>
                <input class="form-control mb-3" name="rating" type="number" step="0.1" value="<?= htmlspecialchars($movie['rating'] ?? '') ?>">

                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

                <div class="d-flex justify-content-between">
                    <a href="/movies/admin/movies" class="btn btn-secondary">Cancel</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
