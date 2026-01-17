
<?php require './config/database.php';
if ($_POST) {
  $hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
  $stmt=$pdo->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)");
  $stmt->execute([$_POST['name'],$_POST['email'],$hash]);
  header("Location: login.php"); exit;
}
include './partials/header.php'; ?>
<form method="post" class="container mt-5">
<input name="name" class="form-control mb-2" placeholder="Name">
<input name="email" class="form-control mb-2" placeholder="Email">
<input name="password" type="password" class="form-control mb-2" placeholder="Password">
<button class="btn btn-success">Register</button>
</form>
<?php include './partials/footer.php'; ?>
