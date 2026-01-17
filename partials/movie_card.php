<div class="col-12 col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
        <img
            src="<?= e($movie['poster_url']) ?: 'https://via.placeholder.com/300x450' ?>"
            class="card-img-top"
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
                    <form method="post" action="favorite.php">
                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                        <input type="hidden" name="action" value="<?= $movie['is_favorited'] ? 'remove' : 'add' ?>">
                        <button class="btn btn-sm btn-link text-danger">
                            <?= $movie['is_favorited'] ? '❤️' : '🤍' ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>