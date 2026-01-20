<?php

require './models/Movie.php';
require './models/Favorite.php';

class MovieController
{

    public function index()
    {

        $userId = $_SESSION['user_id'] ?? null;

        $q     = $_GET['q'] ?? '';
        $genre = $_GET['genre'] ?? '';
        $sort  = $_GET['sort'] ?? '';
        $page  = max(1, (int) ($_GET['page'] ?? 1));

        $limit  = 6;
        $offset = ($page - 1) * $limit;

        $movieModel = new Movie();

        $movies = $movieModel->getAll([
            'userId' => $userId,
            'q'      => $q,
            'genre'  => $genre,
            'sort'   => $sort,
            'limit'  => $limit,
            'offset' => $offset
        ]);

        $total       = $movieModel->countAll($q, $genre);
        $totalPages  = ceil($total / $limit);
        $genres      = $movieModel->getGenres();

        require './views/movies/index.php';
    }
    public function show($id)
    {

        if (!is_numeric($id)) {
            http_response_code(404);
            exit('Movie not found');
        }

        $userId = $_SESSION['user_id'] ?? null;

        $movieModel = new Movie();
        $movie = $movieModel->findWithFavoriteStatus($id, $userId);

        if (!$movie) {
            http_response_code(404);
            exit('Movie not found');
        }

        require './views/movies/show.php';
    }
    public function favorite($movieId) {
        $this->toggleFavorite($movieId, true);
    }

    public function unfavorite($movieId) {
        $this->toggleFavorite($movieId, false);
    }

    private function toggleFavorite(int $movieId, bool $add) {

        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Not logged in']);
            exit;
        }

        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }

        $userId = $_SESSION['user_id'];
        $fav = new Favorite();

        // Vérifie que le film existe
        if (!$fav->movieExists($movieId)) {
            http_response_code(404);
            echo json_encode(['error' => 'Movie not found']);
            exit;
        }

        if ($add) {
            $fav->add($userId, $movieId);
            $status = 'added';
        } else {
            $fav->remove($userId, $movieId);
            $status = 'removed';
        }

        echo json_encode([
            'status' => $status,
            'movie_id' => $movieId
        ]);
        exit;
    }
}
