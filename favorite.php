<?php
require './config/database.php';
require './core/helpers.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}


if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

$movieId = (int) ($_POST['movie_id'] ?? 0);

/* Validate movie exists */
$stmt = $pdo->prepare("SELECT id FROM movies WHERE id = ?");
$stmt->execute([$movieId]);
if (!$stmt->fetch()) {
    http_response_code(404);
    exit('Movie not found');
}

/* Add favorite (duplicates prevented by PK) */
$stmt = $pdo->prepare(
    "INSERT IGNORE INTO favorites (user_id, movie_id) VALUES (?, ?)"
);
$stmt->execute([$_SESSION['user_id'], $movieId]);

/* 🔁 Redirect back */
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
