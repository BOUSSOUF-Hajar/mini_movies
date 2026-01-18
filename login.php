
<?php require './config/database.php';
require './core/csrf.php';
if ($_POST) {
  /* CSRF */
  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Invalid CSRF token');
}
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
  $stmt->execute([$_POST['email']]);
  $u=$stmt->fetch();
  if($u && password_verify($_POST['password'],$u['password_hash'])){
    $_SESSION['user_id']=$u['id'];
    header("Location: movies.php"); exit;
  }
}
include './partials/header.php';
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <form method="post" class="w-100" style="max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <input name="email" class="form-control mb-2" placeholder="Email">
        <input name="password" type="password" class="form-control mb-2" placeholder="Password">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
        <button class="btn btn-primary w-100">Login</button>
    </form>
</div>

<?php include './partials/footer.php'; ?>
