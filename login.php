
<?php require './config/database.php';
include './partials/header.php';
if ($_POST) {
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
  $stmt->execute([$_POST['email']]);
  $u=$stmt->fetch();
  if($u && password_verify($_POST['password'],$u['password_hash'])){
    $_SESSION['user_id']=$u['id'];
    header("Location: movies.php"); exit;
  }
}
?>
<form method="post" class="container mt-5">
<input name="email" class="form-control mb-2" placeholder="Email">
<input name="password" type="password" class="form-control mb-2" placeholder="Password">
<button class="btn btn-primary">Login</button>
</form>
<?php include './partials/footer.php'; ?>
