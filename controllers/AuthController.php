<?php

require './models/User.php';

class AuthController
{

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
                    header("Location: /movies");
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

        // Optionnel : protection CSRF si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf($_POST['csrf_token'] ?? '')) {
                http_response_code(403);
                exit('Invalid CSRF token');
            }
        }

        // Supprimer toutes les variables de session
        $_SESSION = [];

        // Détruire la session
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        // Redémarrer une session propre
        session_start();
        session_regenerate_id(true);

        header('Location: /login');
        exit;
    }
}
