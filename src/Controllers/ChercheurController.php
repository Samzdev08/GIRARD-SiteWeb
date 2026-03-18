<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\Annonce;
use App\Models\Wishlist;

class ChercheurController
{
    public function dashboard(Request $request, Response $response): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $response->withHeader('Location', '/auth/login')->withStatus(302);
        }
        else if($_SESSION['type_compte'] !== 'chercheur') {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $annonces = Wishlist::getByUser($userId);

        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Dashboard Chercheur',
            'annonces' => $annonces
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'chercheur/detail.php');
    }

    public function addWishlist(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $response->withHeader('Location', '/auth/login')->withStatus(302);
        }

        $annonceId = $args['id'];
        $annonces = Annonce::findAllStage($userId);
        $nombreOffre = Annonce::nombreStage();

        if (Wishlist::exists($annonceId, $userId)) {
            $view = new PhpRenderer(__DIR__ . '/../../templates');
            $view->setLayout('layout.php');
            return $view->render($response, 'home.php', [
                'title' => 'Accueil',
                'message' => 'Cette annonce est déjà dans votre wishlist.',
                'type' => 'error',
                'annonces' => $annonces,
                'nombreOffre' => $nombreOffre
            ]);
        }

        $result = Wishlist::add($annonceId, $userId);
        $annonces = Annonce::findAllStage($userId);

        $view = new PhpRenderer(__DIR__ . '/../../templates');
        $view->setLayout('layout.php');
        return $view->render($response, 'home.php', [
            'title' => 'Accueil',
            'message' => $result ? 'Annonce ajoutée à votre wishlist.' : 'Erreur lors de l\'ajout.',
            'type' => $result ? 'success' : 'error',
            'annonces' => $annonces,
            'nombreOffre' => $nombreOffre
        ]);
    }

    public function removeWishlist(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $response->withHeader('Location', '/auth/login')->withStatus(302);
        }

        $annonceId = $args['id'];
        $result = Wishlist::remove($annonceId, $userId);
        $annonces = Annonce::findAllStage($userId);
        $nombreOffre = Annonce::nombreStage();

        $view = new PhpRenderer(__DIR__ . '/../../templates');
        $view->setLayout('layout.php');
        return $view->render($response, 'home.php', [
            'title' => 'Accueil',
            'message' => $result ? 'Annonce retirée de votre wishlist.' : 'Erreur lors de la suppression.',
            'type' => $result ? 'success' : 'error',
            'annonces' => $annonces,
            'nombreOffre' => $nombreOffre
        ]);
    }

    public function wishlist(Request $request, Response $response): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $response->withHeader('Location', '/auth/login')->withStatus(302);
        }

        $annonces = Wishlist::getByUser($userId);

        $view = new PhpRenderer(__DIR__ . '/../../templates');
        $view->setLayout('layout.php');
        return $view->render($response, 'chercheur/detail.php', [
            'title' => 'Ma Wishlist',
            'annonces' => $annonces
        ]);
    }
}
