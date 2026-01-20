<?php include '../partials/header.php'; ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <form method="post" class="w-100" style="max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <input name="email"
               class="form-control mb-2"
               placeholder="Email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <input name="password"
               type="password"
               class="form-control mb-2"
               placeholder="Password">

        <input type="hidden"
               name="csrf_token"
               value="<?= htmlspecialchars(csrf_token()) ?>">

        <button class="btn btn-primary w-100">Login</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
