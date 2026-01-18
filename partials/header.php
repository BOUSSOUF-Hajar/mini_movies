<!DOCTYPE html>
<html>
<?php 
    require './core/csrf.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title>Mini Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/movies/assets/js/favorite.js"></script>

</head>

<body>
    <?php
    include './partials/navbar.php';
    ?>