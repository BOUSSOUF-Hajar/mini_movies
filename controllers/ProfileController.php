<?php
require './models/User.php';

class ProfileController {

    public function index() {

        if (!isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $userModel = new User();

        $user      = $userModel->findById($userId);
        $favorites = $userModel->getFavorites($userId);
        $favoritesCount = count($favorites);

        require './views/profile/index.php';
    }
    public function edit() {

        if (!isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = (new User())->findById($userId);

        require './views/profile/edit.php';
    }

    public function update() {

        if (!isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $userId = $_SESSION['user_id'];
        $name   = trim($_POST['name'] ?? '');
        $errors = [];

        if ($name === '') {
            $errors['name'] = "Le nom ne peut pas être vide.";
        } elseif (strlen($name) > 100) {
            $errors['name'] = "Le nom ne peut pas dépasser 100 caractères.";
        }

        if (!$errors) {
            (new User())->updateName($userId, $name);
            header('Location: /movies/profile');
            exit;
        }

        // Réafficher le formulaire avec erreurs
        $user = ['name' => $name];
        require './views/profile/edit.php';
    }
}
