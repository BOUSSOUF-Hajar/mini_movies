<?php

require '../app/models/User.php';

class AuthController {

    public function login() {
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

        require '../app/views/auth/login.php';
    }
}
