<?php
require './config/database.php';
require './core/helpers.php';
require './core/csrf.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* CSRF */
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $errors['name'] = "Le nom ne peut pas être vide.";
    } elseif (strlen($name) > 100) {
        $errors['name'] = "Le nom ne peut pas dépasser 100 caractères.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->execute([$name, $userId]);
    }

    header('Location: profile.php');
    exit;
}

/* Current name */
$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

include './partials/header.php';
?>

<div class="container mt-4" style="max-width: 500px;">
    <h3>Edit profile</h3>

    <!-- Affichage des erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= e($_POST['name'] ?? $user['name']) ?>"
                required
            >
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include './partials/footer.php'; ?>