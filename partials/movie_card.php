<div class="col-12 col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
        <img
            src="<?= e($movie['poster_url']) ?: 'https://placehold.co/300x450?text=Movie+Poster' ?>"
            class="card-img-top object-fit-cover"
            style="max-height:420px;"
            alt="<?= e($movie['title']) ?>">

        <div class="card-body">
            <h5><?= e($movie['title']) ?></h5>

            <span class="badge bg-secondary"><?= e($movie['genre']) ?></span>

            <p class="mt-2 mb-1">
                ⭐ <?= e($movie['rating']) ?> · <?= e($movie['release_year']) ?>
            </p>

            <div class="d-flex justify-content-between align-items-center">
                <a href="movie.php?id=<?= $movie['id'] ?>" class="btn btn-sm btn-outline-dark">
                    Details
                </a>

                <?php if (isLoggedIn()): ?>
                    <button
                        type="button"
                        class="btn btn-sm btn-favorite"
                        data-movie-id="<?= $movie['id'] ?>"
                        data-is-favorite="<?= $movie['is_favorited'] ? '1' : '0' ?>"
                        aria-label="Toggle favorite"
                    >
                        <span class="favorite-icon">
                            <?= $movie['is_favorited'] ? '❤️' : '🤍' ?>
                        </span>
                    </button>
                <?php else: ?>
                    <a
                        href="login.php?return_to=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                        class="btn btn-sm btn-outline-danger"
                        aria-label="Login to favorite"
                    >
                        🤍
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
