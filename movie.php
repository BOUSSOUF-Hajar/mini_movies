<?php
require './config/database.php';
require './core/helpers.php';
require './core/csrf.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    exit('Movie not found');
}

$movieId = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT 
        m.*,
        EXISTS (
            SELECT 1
            FROM favorites f
            WHERE f.movie_id = m.id
              AND f.user_id = ?
        ) AS is_favorited
    FROM movies m
    WHERE m.id = ?
");
$stmt->execute([
    $_SESSION['user_id'] ?? 0,
    $movieId
]);
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
                src="<?= e($movie['poster_url']) ?: 'https://placehold.co/300x450?text=Movie+Poster' ?>"
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
                <a href="login.php?return_to=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-outline-secondary">
                    Login to favorite
                </a>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include './partials/footer.php'; ?>
