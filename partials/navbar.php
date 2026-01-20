<?php
require_once __DIR__ . '/../core/helpers.php';
?>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/movies/movies.php">
            🎬 MiniMovies
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/movies/movies">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/movies/movies">Movies</a>
                </li>
            </ul>

            <!-- Auth links -->
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/movies/profile">Profile</a>
                    </li>

                    <li class="nav-item">
                        <a href="/movies/logout" class="btn btn-outline-light btn-sm ms-2 mt-1"> Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/movies/login">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/movies/register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>