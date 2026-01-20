<?php
if (!isAdmin()) {
    http_response_code(403);
    exit('Access denied');
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/admin/index.php">Admin Panel</a>

        <div class="d-flex ms-auto">
            <a href="/movies/movies" class="btn btn-outline-light me-2">Home</a>
            <a href="/movies/logout" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>
