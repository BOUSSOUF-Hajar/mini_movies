<?php include './partials/admin_header.php'; ?>

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-md-6 col-lg-5 col-xl-4">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center mb-4">Add Movie</h4>

                    <?php if (!empty($errors ?? [])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $err): ?>
                                <div><?= htmlspecialchars($err) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <input class="form-control" name="title" placeholder="Title" required
                                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <input class="form-control" name="genre" placeholder="Genre" required
                                   value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" name="description" rows="4" placeholder="Description" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <input class="form-control" name="release_year" type="number" placeholder="Year" required
                                       value="<?= htmlspecialchars($_POST['release_year'] ?? '') ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <input class="form-control" name="rating" type="number" step="0.1" placeholder="Rating"
                                       value="<?= htmlspecialchars($_POST['rating'] ?? '') ?>">
                            </div>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

                        <div class="d-flex justify-content-between mt-3">
                            <a href="/movies/admin/movies" class="btn btn-outline-secondary">Cancel</a>
                            <button class="btn btn-success px-4">Save</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
