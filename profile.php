<?php
require './config/database.php';
require './core/helpers.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

/* User info */
$stmt = $pdo->prepare("SELECT name, email, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

/* Favorites */
$stmt = $pdo->prepare("
    SELECT m.*
    FROM movies m
    JOIN favorites f ON f.movie_id = m.id
    WHERE f.user_id = ?
");
$stmt->execute([$userId]);
$favorites = $stmt->fetchAll();

$favoritesCount = count($favorites);

include './partials/header.php';
?>

<div class="container mt-4">

    <h2 class="mb-3">👤 My Profile</h2>

    <!-- User info -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> <?= e($user['name']) ?></p>
            <p><strong>Email:</strong> <?= e($user['email']) ?></p>
            <p><strong>Member since:</strong> <?= date('F Y', strtotime($user['created_at'])) ?></p>
            <p><strong>Favorites:</strong> <?= $favoritesCount ?></p>

            <a href="profile_edit.php" class="btn btn-sm btn-outline-primary">
                Edit name
            </a>
        </div>
    </div>

    <!-- Favorites list -->
    <h4 class="mb-3">❤️ My Favorite Movies</h4>

    <?php if ($favoritesCount === 0): ?>
        <p class="text-muted">You have no favorite movies yet.</p>
    <?php else: ?>
        <div class="row">
            <?php 
            foreach ($favorites as $movie): 
                include './partials/movie_card.php';
            endforeach ?>
        </div>
    <?php endif; ?>

</div>

<?php include './partials/footer.php'; ?>
