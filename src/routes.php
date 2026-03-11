<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Controllers\AnnonceurController;
use App\Controllers\AuthController;
use App\Controllers\ChercheurController;
use App\Controllers\AdminController;

// Routes principales
$app->get('/', AnnonceurController::class);
$app->get('/details/{id}', AnnonceurController::class . ':detailsAnnonce');
$app->get('/offres', AnnonceurController::class . ':offres');
$app->get('/search/{params}', AnnonceurController::class . ':search');


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

$app->group('/chercheur', function ($group) {
    $group->get('/dashboard', ChercheurController::class . ':dashboard');
    $group->get('/profile', ChercheurController::class . ':showProfile');
    $group->post('/profile', ChercheurController::class . ':updateProfile');
    $group->get('/offres', ChercheurController::class . ':listOffres');
    $group->post('/wishlist/add/{id}', ChercheurController::class . ':addWishlist');
    $group->post('/wishlist/remove/{id}', ChercheurController::class . ':removeWishlist');
});

$app->group('/admin', function ($group) {
    $group->get('/dashboard', AdminController::class . ':dashboard');
    $group->post('/user/update', AdminController::class . ':updateUser');
    $group->post('/user/delete/{id}', AdminController::class . ':deleteUser');
    $group->post('/keywords/create', AdminController::class . ':createKeyword');
    $group->post('/keywords/update', AdminController::class . ':updateKeyword');
    $group->post('/keywords/delete/{id}', AdminController::class . ':deleteKeyword');
});