<?php
require './config/database.php';
require './core/helpers.php';

/* Must be logged in */
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

/* CSRF */
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

/* Remove favorite */
$stmt = $pdo->prepare(
    "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?"
);
$stmt->execute([$_SESSION['user_id'], $movieId]);

/* Redirect back */
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
