
<?php
function e($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
function isLoggedIn() {
  return isset($_SESSION['user_id']);
}
function isAdmin() {
    return isset($_SESSION['user_id']) &&
           $_SESSION['user_id'] == 1;
}