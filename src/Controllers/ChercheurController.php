<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\Annonce;

class ChercheurController
{
    public function dashboard(Request $request, Response $response): Response
    {
        $view = new PhpRenderer(__DIR__ . '/../../templates', [
            'title' => 'Dashboard Chercheur'
        ]);
        $view->setLayout('layout.php');
        return $view->render($response, 'chercheur/detail.php');
    }
    
}