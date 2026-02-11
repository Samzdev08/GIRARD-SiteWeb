<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Controllers\AnnonceurController;
use App\Controllers\AuthController;
use App\Controllers\ChercheurController;

// Routes principales
$app->get('/', AnnonceurController::class);
$app->get('/details/{id}', AnnonceurController::class . ':detailsAnnonce');
$app->get('/offres', AnnonceurController::class . ':offres');

$app->group('/auth', function ($group) {
    $group->get('/login', AuthController::class . ':showLoginForm');
    $group->post('/login', AuthController::class . ':login');
    $group->get('/register', AuthController::class . ':showRegisterForm');
    $group->post('/register', AuthController::class . ':register');
    $group->get('/logout', AuthController::class . ':logoutt');
});


$app->group('/annonceur', function ($group) {
    $group->get('/dashboard', AnnonceurController::class . ':dashboard');
    $group->get('/details/{id}', AnnonceurController::class . ':detailsAnnonce');
    $group->post('/create', AnnonceurController::class . ':createAnnonce');
    $group->post('/edit/{id}', AnnonceurController::class . ':updateAnnonce');
    $group->post('/delete/{id}', AnnonceurController::class . ':deleteAnnonce');
});

$app->group('chercheur', function ($group) {
    $group->get('/dashboard', ChercheurController::class . ':dashboard');
    $group->get('/profile', ChercheurController::class . ':showProfile');
    $group->post('/profile', ChercheurController::class . ':updateProfile');
    $group->get('/offres', ChercheurController::class . ':listOffres');
    $group->post('/offres/{id}/apply', ChercheurController::class . ':applyOffre');
});

