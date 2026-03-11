<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Keyword;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class AdminController
{
    private function checkAdmin(Response $response): bool|Response
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'administrateur') {
            return $response->withHeader('Location', '/auth/login')->withStatus(302);
        }
        return true;
    }

    private function renderDashboard(Response $response, $message = null, $type = null): Response
    {
        $users = User::findAll();
        $keywords = Keyword::findAll();

        $view = new PhpRenderer(__DIR__ . '/../../templates');
        $view->setLayout('layout.php');
        return $view->render($response, 'admin/detail.php', [
            'title'    => 'Dashboard Admin',
            'users'    => $users,
            'keywords' => $keywords,
            'message'  => $message,
            'type'     => $type
        ]);
    }

    public function dashboard(Request $request, Response $response): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;
        return $this->renderDashboard($response);
    }



    public function updateUser(Request $request, Response $response, array $args): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;

        $data = filter_input_array(INPUT_POST, [
            'id'        => FILTER_SANITIZE_NUMBER_INT,
            'user_type' => FILTER_SANITIZE_SPECIAL_CHARS,
        ]);

        if (empty($data['id']) || empty($data['user_type'])) {
            return $this->renderDashboard($response, 'Les champs ne peuvent pas être vides.', 'error');
        }

        $result = User::updateUser($data);
        return $this->renderDashboard($response, $result ? 'Utilisateur modifié avec succès.' : 'Erreur lors de la modification.', $result ? 'success' : 'error');
    }

    public function deleteUser(Request $request, Response $response, array $args): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;

        $result = User::deleteUser($args['id']);
        return $this->renderDashboard($response, $result ? 'Utilisateur supprimé avec succès.' : 'Erreur lors de la suppression.', $result ? 'success' : 'error');
    }



    public function createKeyword(Request $request, Response $response): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;

        $data = filter_input_array(INPUT_POST, [
            'keyword' => FILTER_SANITIZE_SPECIAL_CHARS
        ]);

        if (empty($data['keyword'])) {
            return $this->renderDashboard($response, 'Le mot clef ne peut pas être vide.', 'error');
        }

        $result = Keyword::create($data['keyword']);
        return $this->renderDashboard($response, $result ? 'Mot clef ajouté avec succès.' : 'Erreur lors de l\'ajout.', $result ? 'success' : 'error');
    }

    public function updateKeyword(Request $request, Response $response, array $args): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;

        $data = filter_input_array(INPUT_POST, [
            'id'      => FILTER_SANITIZE_NUMBER_INT,
            'keyword' => FILTER_SANITIZE_SPECIAL_CHARS
        ]);

        if (empty($data['keyword'])) {
            return $this->renderDashboard($response, 'Le mot clef ne peut pas être vide.', 'error');
        }

        $result = Keyword::update($data);
        return $this->renderDashboard($response, $result ? 'Mot clef modifié avec succès.' : 'Erreur lors de la modification.', $result ? 'success' : 'error');
    }

    public function deleteKeyword(Request $request, Response $response, array $args): Response
    {
        $check = $this->checkAdmin($response);
        if ($check !== true) return $check;

        $result = Keyword::delete($args['id']);
        return $this->renderDashboard($response, $result ? 'Mot clef supprimé avec succès.' : 'Erreur lors de la suppression.', $result ? 'success' : 'error');
    }
}
