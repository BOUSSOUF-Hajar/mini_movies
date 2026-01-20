<?php
require './models/Movie.php';

class AdminMovieController {

    private $movieModel;

    public function __construct() {
        if (!isAdmin()) {
            http_response_code(403);
            exit('Access denied');
        }
        $this->movieModel = new Movie();
    }

    public function index() {
        $movies = $this->movieModel->all();
        require './views/admin/index.php';
    }

    public function create() {
        require './views/admin/create.php';
    }

    public function store() {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $title = trim($_POST['title'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $year  = (int) ($_POST['release_year'] ?? 0);
        $rating = (float) ($_POST['rating'] ?? 0);

        $errors = [];
        if (!$title) $errors['title'] = 'Title is required';
        if (!$genre) $errors['genre'] = 'Genre is required';
        if ($year <= 0) $errors['year'] = 'Year is required';
        if ($rating < 0 || $rating > 10) $errors['rating'] = 'Rating must be 0-10';

        if ($errors) {
            require './views/admin/create.php';
            return;
        }

        $this->movieModel->create($title, $genre, $year, $rating);
        header('Location: /movies/admin/movies');
        exit;
    }

    public function edit($id) {
        $movie = $this->movieModel->find($id);
        if (!$movie) {
            http_response_code(404);
            exit('Movie not found');
        }
        require './views/admin/edit.php';
    }

    public function update($id) {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $title = trim($_POST['title'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $year  = (int) ($_POST['release_year'] ?? 0);
        $rating = (float) ($_POST['rating'] ?? 0);

        $errors = [];
        if (!$title) $errors['title'] = 'Title is required';
        if (!$genre) $errors['genre'] = 'Genre is required';
        if ($year <= 0) $errors['year'] = 'Year is required';
        if ($rating < 0 || $rating > 10) $errors['rating'] = 'Rating must be 0-10';

        if ($errors) {
            $movie = ['id'=>$id, 'title'=>$title, 'genre'=>$genre, 'release_year'=>$year, 'rating'=>$rating];
            require './views/admin/edit.php';
            return;
        }

        $this->movieModel->update($id, $title, $genre, $year, $rating);
        header('Location: /movies/admin/movies');
        exit;
    }

    public function delete($id) {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $this->movieModel->delete($id);
        header('Location: /movies/admin/movies');
        exit;
    }
}
