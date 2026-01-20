<?php

require './models/User.php';

class AuthController
{
    public function showRegisterForm() {
        require './views/auth/register.php';
    }

    public function register() {

        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $errors   = [];

        // Validation
        if ($name === '') {
            $errors['name'] = "Le nom est requis.";
        }

        if ($email === '') {
            $errors['email'] = "L'email est requis.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email n'est pas valide.";
        }

        if ($password === '') {
            $errors['password'] = "Le mot de passe est requis.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        $userModel = new User();

        if ($userModel->existsByEmail($email)) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }

        if ($errors) {
            require './views/auth/register.php';
            return;
        }

        // Création utilisateur
        $userModel->create($name, $email, $password);

        // Redirection vers login
        header('Location: /Movies/login');
        exit;
    }

    public function login()
    {
        $errors = [];

        if ($_POST) {

            if (!verify_csrf($_POST['csrf_token'] ?? '')) {
                http_response_code(403);
                exit('Invalid CSRF token');
            }

            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email)) {
                $errors['email'] = "L'email est requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "L'email n'est pas valide.";
            }

            if (empty($password)) {
                $errors['password'] = "Le mot de passe est requis.";
            }

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: /movies/movies");
                    exit;
                } else {
                    $errors['login'] = "Email ou mot de passe incorrect.";
                }
            }
        }

        require './views/auth/login.php';
    }
    public function logout()
    {

        // Détruire la session
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        // Redémarrer une session propre
        session_start();
        session_regenerate_id(true);

        header('Location: /movies/login');
        exit;
    }
}
