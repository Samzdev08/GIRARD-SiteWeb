<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Controllers\AnnonceurController;

// Routes principales
$app->get('/', AnnonceurController::class);
$app->get('/details/{id}', AnnonceurController::class . ':detailsAnnonce');
$app->get('/offres', AnnonceurController::class . ':offres');


