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
        $nombreOffre = Annonce::nombreStage();


        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Accueil',
            'nombreOffre' => $nombreOffre,
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

    public function dashboard(Request $request, Response $response): Response
    {

        if (!isset($_SESSION['user_id'])) {
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        $userId = $_SESSION['user_id'];
        $annonces = Annonce::findAnnonceByUserId($userId);

        $view = new PhpRenderer(__DIR__ . '/../../templates');
        $view->setLayout('layout.php');

        return $view->render($response, 'annonceur/detail.php', [
            'title' => 'Dashboard Annonceur',
            'annonces' => $annonces
        ]);
    }

    public function updateAnnonce(Request $request, Response $response): Response
    {


        $data = filter_input_array(INPUT_POST, [
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'required_skills' => FILTER_SANITIZE_SPECIAL_CHARS,
            'date_debut' => FILTER_SANITIZE_SPECIAL_CHARS,
            'date_fin' => FILTER_SANITIZE_SPECIAL_CHARS,
        ]);

        $media = Annonce::verifMedia($_FILES['media']);


        if (!$media['success']) {

            $view = new PhpRenderer(__DIR__ . '/../../templates');
            $view->setLayout('layout.php');

            return $view->render($response, 'annonceur/detail.php', [
                'title' => 'Dashboard Annonceur',
                'message' => $media['message']
            ]);
        }

        if ($media['filename'] !== null) {

            $data['media_path'] = $media['filename'];
            $data['media_type'] = $media['type'];
        }


        $result = Annonce::updateAnnonce($data);
        if ($result == true) {

            $view = new PhpRenderer(__DIR__ . '/../../templates');
            $view->setLayout('layout.php');

            return $view->render($response, 'annonceur/detail.php', [
                'title' => 'Dashboard Annonceur',
                'message' => 'Annonce modifiée avec succès.'
            ]);

        } else {
            
            $view = new PhpRenderer(__DIR__ . '/../../templates');
            $view->setLayout('layout.php');

            return $view->render($response, 'annonceur/detail.php', [
                'title' => 'Dashboard Annonceur',
                'message' => 'Erreur lors de la mise à jour de l\'annonce.'
            ]);

        }
    }
}
        