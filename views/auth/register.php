<?php include './partials/header.php'; ?>

<div class="container mt-5" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Register</h3>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= e($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input name="name" class="form-control mb-2" placeholder="Name" value="<?= e($_POST['name'] ?? '') ?>">
        <input name="email" class="form-control mb-2" placeholder="Email" value="<?= e($_POST['email'] ?? '') ?>">
        <input name="password" type="password" class="form-control mb-2" placeholder="Password">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <button class="btn btn-success w-100">Register</button>
    </form>
</div>

<?php include './partials/footer.php'; ?>
