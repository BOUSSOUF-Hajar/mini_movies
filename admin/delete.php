<?php
require '../config/database.php';
require '../core/helpers.php';
require '../core/csrf.php';

if (!isAdmin()) {
    http_response_code(403);
    exit('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    exit('Invalid CSRF token');
}

$id = (int)($_POST['id'] ?? 0);

$stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;
