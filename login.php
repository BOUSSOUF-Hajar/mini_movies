<form method="post" action="/login">
    <input name="email" placeholder="Email">
    <input type="password" name="password">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <button>Login</button>
</form>
