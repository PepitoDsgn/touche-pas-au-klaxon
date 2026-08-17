<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\TrajetModel;

/**
 * Contrôleur de la page d'accueil.
 */
class HomeController extends Controller
{
    private TrajetModel $trajetModel;

    public function __construct()
    {
        $this->trajetModel = new TrajetModel();
    }

    /** Affiche la page d'accueil avec la liste des trajets. */
    public function index(): void
    {
        if (Session::isLoggedIn()) {
            $trajets = $this->trajetModel->findAllForUser();
        } else {
            $trajets = $this->trajetModel->findAvailable();
        }

        $this->render('home/index', [
            'trajets' => $trajets,
            'flash'   => Session::getFlash('success'),
        ]);
    }
}
