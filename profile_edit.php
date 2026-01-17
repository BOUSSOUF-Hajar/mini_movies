<?php
require './config/database.php';
require './core/helpers.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if ($name !== '') {
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

<div class="container mt-4">
    <h3>Edit profile</h3>

    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= e($user['name']) ?>"
                required
            >
        </div>

        <button class="btn btn-success">Save</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include './partials/footer.php'; ?>
