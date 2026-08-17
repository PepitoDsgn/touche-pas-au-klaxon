<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\UserModel;
use App\Models\AgenceModel;
use App\Models\TrajetModel;

/**
 * Contrôleur du tableau de bord administrateur.
 */
class AdminController extends Controller
{
    private UserModel   $userModel;
    private AgenceModel $agenceModel;
    private TrajetModel $trajetModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->agenceModel = new AgenceModel();
        $this->trajetModel = new TrajetModel();
    }

    /** Page d'accueil du tableau de bord admin. */
    public function dashboard(): void
    {
        $this->requireAdmin();
        $this->render('admin/dashboard', [
            'nbUsers'   => count($this->userModel->findAll()),
            'nbAgences' => count($this->agenceModel->findAll()),
            'nbTrajets' => count($this->trajetModel->findAll()),
        ]);
    }

    /** Liste des utilisateurs. */
    public function users(): void
    {
        $this->requireAdmin();
        $this->render('admin/users', [
            'users' => $this->userModel->findAll('nom'),
        ]);
    }

    /** Liste des agences. */
    public function agences(): void
    {
        $this->requireAdmin();
        $this->render('admin/agences', [
            'agences' => $this->agenceModel->findAll('nom'),
            'flash'   => Session::getFlash('success'),
            'error'   => Session::getFlash('error'),
        ]);
    }

    /** Crée une agence. */
    public function createAgence(): void
    {
        $this->requireAdmin();

        $nom = trim($this->sanitize($_POST['nom'] ?? ''));

        if (empty($nom)) {
            Session::setFlash('error', 'Le nom de l\'agence est obligatoire.');
            $this->redirect('/admin/agences');
        }

        if ($this->agenceModel->nameExists($nom)) {
            Session::setFlash('error', 'Cette agence existe déjà.');
            $this->redirect('/admin/agences');
        }

        $this->agenceModel->create($nom);
        Session::setFlash('success', 'L\'agence a été créée.');
        $this->redirect('/admin/agences');
    }

    /** Modifie une agence. */
    public function editAgence(string $id): void
    {
        $this->requireAdmin();

        $nom = trim($this->sanitize($_POST['nom'] ?? ''));

        if (empty($nom)) {
            Session::setFlash('error', 'Le nom de l\'agence est obligatoire.');
            $this->redirect('/admin/agences');
        }

        if ($this->agenceModel->nameExists($nom, (int) $id)) {
            Session::setFlash('error', 'Ce nom d\'agence est déjà utilisé.');
            $this->redirect('/admin/agences');
        }

        $this->agenceModel->update((int) $id, $nom);
        Session::setFlash('success', 'L\'agence a été modifiée.');
        $this->redirect('/admin/agences');
    }

    /** Supprime une agence. */
    public function deleteAgence(string $id): void
    {
        $this->requireAdmin();
        $this->agenceModel->deleteById((int) $id);
        Session::setFlash('success', 'L\'agence a été supprimée.');
        $this->redirect('/admin/agences');
    }

    /** Liste des trajets (admin). */
    public function trajets(): void
    {
        $this->requireAdmin();
        $this->render('admin/trajets', [
            'trajets' => $this->trajetModel->findAllAdmin(),
            'flash'   => Session::getFlash('success'),
        ]);
    }

    /** Supprime un trajet (admin). */
    public function deleteTrajet(string $id): void
    {
        $this->requireAdmin();
        $this->trajetModel->deleteById((int) $id);
        Session::setFlash('success', 'Le trajet a été supprimé.');
        $this->redirect('/admin/trajets');
    }
}
