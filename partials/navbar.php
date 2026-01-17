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
                    <a class="nav-link" href="/movies/movies.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/movies/movies.php">Movies</a>
                </li>
            </ul>

            <!-- Auth links -->
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/movies/profile.php">Profile</a>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="/movies/logout.php" class="d-inline">
                            <button class="btn btn-outline-light btn-sm ms-2">
                                Logout
                            </button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/movies/login.php">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/movies/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>