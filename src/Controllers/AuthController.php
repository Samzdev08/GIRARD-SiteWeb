<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\User;

class AuthController
{
    private $view;

    public function __construct()
    {

        $this->view = new PhpRenderer(__DIR__ . '/../../templates/');
    }

    public function showLoginForm(Request $request, Response $response): Response
    {
        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Connexion'
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'auth/login.php');
    }
    public function showRegisterForm(Request $request, Response $response): Response
    {
        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Inscription'
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'auth/register.php');
    }
    public function logout(Request $request, Response $response): Response
    {

        session_start();
        session_destroy();


        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $username = trim($data['nomUtilisateur'] ?? '');
        $password = $data['motdepasse'] ?? '';

        $errors = [];


        if ($username === "") {
            $errors[] = "Le nom d'utilisateur ne doit pas être vide";
        }

        if ($password === "") {
            $errors[] = "Le mot de passe ne doit pas être vide";
        }

        if (!empty($errors)) {
            return $this->view->render($response, '/auth/login.php', [
                'errors' => $errors
            ]);
        }

        $user = User::findByUsername($username);
        

        if ($user && password_verify($password, $user['password'])) {

            session_start();
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['login'];
            $_SESSION['type_compte'] = $user['user_type'];

            return $response
                ->withHeader('Location', '/')
                ->withStatus(302);

        } else {

            $errors[] = "Nom d'utilisateur ou mot de passe incorrect";
            return $this->view->render($response, '/auth/login.php', [
                'errors' => $errors,
            ]);
        }
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();


        $username = trim($data['nomUtilisateur'] ?? '');
        $password = $data['motdepasse'] ?? '';
        $type = $data['type-compte'] ?? '';

        $errors = [];

        if ($type === "") {
            $errors[] = "Le type de compte doit être choisi";
        }


        if ($username === "") {
            $errors[] = "Le nom d'utilisateur ne doit pas être vide";
        } elseif (strlen($username) < 3) {
            $errors[] = "Le nom d'utilisateur doit faire au minimum 3 caractères";
        }


        if ($password === "") {
            $errors[] = "Le mot de passe ne doit pas être vide";
        } elseif (strlen($password) < 6) {
            $errors[] = "Le mot de passe doit faire au minimum 6 caractères";
        }


        if (!empty($errors)) {
            return $this->view->render($response, '/auth/register.php', [
                'errors' => $errors
            ]);
        }


        if (User::create($username, password_hash($password, PASSWORD_BCRYPT), $type)) {
            return $response
                ->withHeader('Location', '/auth/login')
                ->withStatus(302);
        } else {
            $errors[] = "Erreur lors de l'inscription. Le nom d'utilisateur existe peut-être déjà.";
            return $this->view->render($response, '/auth/register.php', [
                'errors' => $errors
            ]);
        }
    }


    public function logoutt(Request $request, Response $response): Response
    {
        session_start();
        session_destroy();

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }
}
