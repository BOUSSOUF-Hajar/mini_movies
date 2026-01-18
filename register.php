<?php 
require './config/database.php';
require './core/csrf.php';

$errors = [];
if ($_POST) {
  /* CSRF */
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($name)) {
        $errors['name'] = "Le nom est requis.";
    }

    if (empty($email)) {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    if (empty($password)) {
        $errors['password'] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)");
        $stmt->execute([$name, $email, $hash]);
        header("Location: login.php");
        exit;
    }
}

include './partials/header.php'; 
?>

<div class="container mt-5" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Register</h3>

    <!-- Affichage des erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input name="name" class="form-control mb-2" placeholder="Name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <input name="email" class="form-control mb-2" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <input name="password" type="password" class="form-control mb-2" placeholder="Password">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
        <button class="btn btn-success w-100">Register</button>
    </form>
</div>

<?php include './partials/footer.php'; ?>
