<?php include './partials/admin_header.php'; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Admin · Movies</h3>
        <a href="/movies/admin/movies/create" class="btn btn-success">+ Add movie</a>
    </div>

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
                                <a href="/movies/admin/movies/<?= $m['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="/movies/admin/movies/<?= $m['id'] ?>/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
