<?php include './partials/header.php'; ?>

<div class="container mt-4">

    <div class="row">

        <div class="col-md-4">
            <img
                src="<?= e($movie['poster_url']) ?: 'https://placehold.co/300x450?text=Movie+Poster' ?>"
                class="img-fluid rounded"
                alt="<?= e($movie['title']) ?>">
        </div>

        <div class="col-md-8">
            <h2><?= e($movie['title']) ?></h2>

            <span class="badge bg-primary"><?= e($movie['genre']) ?></span>

            <p class="mt-2">
                <strong>Year:</strong> <?= e($movie['release_year']) ?><br>
                <strong>Rating:</strong> ⭐ <?= e($movie['rating']) ?>
            </p>

            <p><?= nl2br(e($movie['description'])) ?></p>

            <?php if (isLoggedIn()): ?>
                <button
                    class="btn btn-sm btn-favorite"
                    data-movie-id="<?= $movie['id'] ?>"
                    data-is-favorite="<?= $movie['is_favorited'] ? '1' : '0' ?>"
                >
                    <span class="favorite-icon">
                        <?= $movie['is_favorited'] ? '❤️' : '🤍' ?>
                    </span>
                </button>
            <?php else: ?>
                <a href="/login?return_to=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                   class="btn btn-outline-secondary">
                    Login to favorite
                </a>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php include './partials/footer.php'; ?>
