<?php require './config/database.php';
require './core/csrf.php';
if ($_POST) {
  /* CSRF */
if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}
  $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)");
  $stmt->execute([$_POST['name'], $_POST['email'], $hash]);
  header("Location: login.php");
  exit;
}
include './partials/header.php'; ?>
<form method="post" class="container mt-5">
  <input name="name" class="form-control mb-2" placeholder="Name">
  <input name="email" class="form-control mb-2" placeholder="Email">
  <input name="password" type="password" class="form-control mb-2" placeholder="Password">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
  <button class="btn btn-success">Register</button>
</form>
<?php include './partials/footer.php'; ?>