<?php

require './models/Movie.php';

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
}
