<?php
require './config/database.php';
require './core/csrf.php';

/* Destroy session */
session_unset();
session_destroy();

/* Optional: regenerate session id for security */
session_start();
session_regenerate_id(true);

/* Redirect to login or home */
header('Location: login.php');
exit;
