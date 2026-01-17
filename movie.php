<?php
require './config/database.php';
require './core/helpers.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    exit('Movie not found');
}

$movieId = (int) $_GET['id'];

/* Movie */
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$movieId]);
$movie = $stmt->fetch();

if (!$movie) {
    http_response_code(404);
    exit('Movie not found');
}

/* Favorite status */
$isFavorited = false;

if (isLoggedIn()) {
    $stmt = $pdo->prepare(
        "SELECT 1 FROM favorites WHERE user_id = ? AND movie_id = ?"
    );
    $stmt->execute([$_SESSION['user_id'], $movieId]);
    $isFavorited = (bool) $stmt->fetch();
}

include './partials/header.php';
?>

<div class="container mt-4">

    <div class="row">
        <!-- Poster -->
        <div class="col-md-4">
            <img
                src="<?= e($movie['poster_url']) ?: 'https://via.placeholder.com/300x450' ?>"
                class="img-fluid rounded"
                alt="<?= e($movie['title']) ?>">
        </div>

        <!-- Details -->
        <div class="col-md-8">
            <h2><?= e($movie['title']) ?></h2>

            <span class="badge bg-primary"><?= e($movie['genre']) ?></span>

            <p class="mt-2">
                <strong>Year:</strong> <?= e($movie['release_year']) ?><br>
                <strong>Rating:</strong> ⭐ <?= e($movie['rating']) ?>
            </p>

            <p><?= nl2br(e($movie['description'])) ?></p>

            <?php if (isLoggedIn()): ?>
                <form method="post" action="favorite.php" class="d-inline">
                    <input type="hidden" name="movie_id" value="<?= $movieId ?>">
                    <input type="hidden" name="action" value="<?= $isFavorited ? 'remove' : 'add' ?>">

                    <button class="btn <?= $isFavorited ? 'btn-danger' : 'btn-outline-danger' ?>">
                        <?= $isFavorited ? '❤️ Unfavorite' : '🤍 Favorite' ?>
                    </button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-secondary">
                    Login to favorite
                </a>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include './partials/footer.php'; ?>
