<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\Annonce;

class AnnonceurController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $annonces = Annonce::findAllStage();
       
        
        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Accueil',
            'annonces' => $annonces
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'home.php');
    }
    public function detailsAnnonce(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::findById($id);

        if (!$annonce) {
            $response->getBody()->write(json_encode(['error' => 'Annonce non trouvée']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json; charset=utf-8');
        }

        $response->getBody()->write(json_encode($annonce));
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');

    }

    public function offres(Request $request, Response $response): Response
    {
        $annonces = Annonce::findAllStage();
       
        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Offres d\'emploi',
            'annonces' => $annonces
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'list.php');
    }
}