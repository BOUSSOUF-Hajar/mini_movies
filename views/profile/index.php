<?php include './partials/header.php'; ?>

<div class="container mt-4">

    <h2 class="mb-3">👤 My Profile</h2>

    <!-- User info -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> <?= e($user['name']) ?></p>
            <p><strong>Email:</strong> <?= e($user['email']) ?></p>
            <p><strong>Member since:</strong> <?= date('F Y', strtotime($user['created_at'])) ?></p>
            <p><strong>Favorites:</strong> <?= $favoritesCount ?></p>

            <a href="/movies/profile/edit" class="btn btn-sm btn-outline-primary">Edit name</a>
        </div>
    </div>

    <!-- Favorites list -->
    <h4 class="mb-3">My Favorite Movies</h4>

    <?php if ($favoritesCount === 0): ?>
        <p class="text-muted">You have no favorite movies yet.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($favorites as $movie): ?>
                <?php include './partials/movie_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include './partials/footer.php'; ?>
