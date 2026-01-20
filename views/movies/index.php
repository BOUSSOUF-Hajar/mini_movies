<?php include './partials/header.php'; ?>

<div class="container mt-4">

    <!-- Filters -->
    <form class="row g-2 mb-4" method="get" action="/movies/movies">

        <div class="col-md-4">
            <input type="text"
                name="q"
                class="form-control"
                placeholder="Search by title"
                value="<?= e($q) ?>">
        </div>

        <div class="col-md-3">
            <select name="genre" class="form-select">
                <option value="">All genres</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= e($g['genre']) ?>"
                        <?= $genre === $g['genre'] ? 'selected' : '' ?>>
                        <?= e($g['genre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Sort by</option>
                <option value="rating_desc" <?= $sort === 'rating_desc' ? 'selected' : '' ?>>Rating ↓</option>
                <option value="year_desc" <?= $sort === 'year_desc' ? 'selected' : '' ?>>Year ↓</option>
                <option value="title_asc" <?= $sort === 'title_asc' ? 'selected' : '' ?>>Title A–Z</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-dark w-100">Filter</button>
        </div>
    </form>

    <!-- Movies -->
    <div class="row">
        <?php foreach ($movies as $movie): ?>
            <?php include './partials/movie_card.php'; ?>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link"
                            href="/movies?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php include './partials/footer.php'; ?>