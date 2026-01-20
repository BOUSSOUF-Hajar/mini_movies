<?php include './partials/header.php'; ?>

<div class="container mt-4" style="max-width: 500px;">
    <h3>Edit profile</h3>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= e($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
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
        <a href="/movies/profile" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include './partials/footer.php'; ?>
