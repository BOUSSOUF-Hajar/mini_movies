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

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email)) {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    if (empty($password)) {
        $errors['password'] = "Le mot de passe est requis.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: movies.php");
            exit;
        } else {
            $errors['login'] = "Email ou mot de passe incorrect.";
        }
    }
}

include './partials/header.php';
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <form method="post" class="w-100" style="max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <input name="email" class="form-control mb-2" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <input name="password" type="password" class="form-control mb-2" placeholder="Password">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
        <button class="btn btn-primary w-100">Login</button>
    </form>
</div>

<?php include './partials/footer.php'; ?>
