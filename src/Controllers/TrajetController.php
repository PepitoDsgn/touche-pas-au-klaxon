<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\TrajetModel;
use App\Models\AgenceModel;

/**
 * Contrôleur de gestion des trajets.
 */
class TrajetController extends Controller
{
    private TrajetModel  $trajetModel;
    private AgenceModel  $agenceModel;

    public function __construct()
    {
        $this->trajetModel = new TrajetModel();
        $this->agenceModel = new AgenceModel();
    }

    /** Affiche le formulaire de création d'un trajet. */
    public function create(): void
    {
        $this->requireAuth();

        $this->render('trajet/create', [
            'agences' => $this->agenceModel->findAll('nom'),
            'user'    => Session::getUser(),
            'errors'  => [],
        ]);
    }

    /** Traite la soumission du formulaire de création. */
    public function store(): void
    {
        $this->requireAuth();

        $user   = Session::getUser();
        $errors = $this->validateTrajet($_POST);

        if (!empty($errors)) {
            $this->render('trajet/create', [
                'agences' => $this->agenceModel->findAll('nom'),
                'user'    => $user,
                'errors'  => $errors,
                'old'     => $_POST,
            ]);
            return;
        }

        $places = (int) $_POST['places_totales'];

        $this->trajetModel->create([
            'agence_depart_id'   => (int) $_POST['agence_depart_id'],
            'agence_arrivee_id'  => (int) $_POST['agence_arrivee_id'],
            'gdh_depart'         => $_POST['gdh_depart'],
            'gdh_arrivee'        => $_POST['gdh_arrivee'],
            'places_totales'     => $places,
            'places_disponibles' => $places,
            'user_id'            => (int) $user['id'],
        ]);

        Session::setFlash('success', 'Le trajet a été créé avec succès.');
        $this->redirect('/');
    }

    /** Affiche le formulaire de modification d'un trajet. */
    public function edit(string $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->findById((int) $id);

        if ($trajet === null || (int) $trajet['user_id'] !== (int) Session::getUser()['id']) {
            $this->redirect('/');
        }

        $this->render('trajet/edit', [
            'trajet'  => $trajet,
            'agences' => $this->agenceModel->findAll('nom'),
            'errors'  => [],
        ]);
    }

    /** Traite la soumission du formulaire de modification. */
    public function update(string $id): void
    {
        $this->requireAuth();

        $user   = Session::getUser();
        $trajet = $this->trajetModel->findById((int) $id);

        if ($trajet === null || (int) $trajet['user_id'] !== (int) $user['id']) {
            $this->redirect('/');
        }

        $errors = $this->validateTrajet($_POST);

        if (!empty($errors)) {
            $this->render('trajet/edit', [
                'trajet'  => $trajet,
                'agences' => $this->agenceModel->findAll('nom'),
                'errors'  => $errors,
                'old'     => $_POST,
            ]);
            return;
        }

        $places = (int) $_POST['places_totales'];

        $this->trajetModel->update((int) $id, [
            'agence_depart_id'   => (int) $_POST['agence_depart_id'],
            'agence_arrivee_id'  => (int) $_POST['agence_arrivee_id'],
            'gdh_depart'         => $_POST['gdh_depart'],
            'gdh_arrivee'        => $_POST['gdh_arrivee'],
            'places_totales'     => $places,
            'places_disponibles' => $places,
            'user_id'            => (int) $user['id'],
        ]);

        Session::setFlash('success', 'Le trajet a été modifié.');
        $this->redirect('/');
    }

    /** Supprime un trajet (auteur uniquement). */
    public function delete(string $id): void
    {
        $this->requireAuth();

        $user = Session::getUser();
        $this->trajetModel->deleteByIdAndUser((int) $id, (int) $user['id']);

        Session::setFlash('success', 'Le trajet a été supprimé.');
        $this->redirect('/');
    }

    /**
     * Valide les données du formulaire de trajet.
     *
     * @param array<string, mixed> $data
     * @return array<string, string>
     */
    private function validateTrajet(array $data): array
    {
        $errors = [];

        $departId  = (int) ($data['agence_depart_id'] ?? 0);
        $arriveeId = (int) ($data['agence_arrivee_id'] ?? 0);
        $gdhDepart  = $data['gdh_depart']  ?? '';
        $gdhArrivee = $data['gdh_arrivee'] ?? '';
        $places     = (int) ($data['places_totales'] ?? 0);

        if ($departId === 0) {
            $errors['agence_depart_id'] = 'Veuillez sélectionner une agence de départ.';
        }

        if ($arriveeId === 0) {
            $errors['agence_arrivee_id'] = 'Veuillez sélectionner une agence d\'arrivée.';
        }

        if ($departId !== 0 && $departId === $arriveeId) {
            $errors['agences'] = 'Les agences de départ et d\'arrivée doivent être différentes.';
        }

        if (empty($gdhDepart)) {
            $errors['gdh_depart'] = 'La date et heure de départ sont obligatoires.';
        }

        if (empty($gdhArrivee)) {
            $errors['gdh_arrivee'] = 'La date et heure d\'arrivée sont obligatoires.';
        }

        if (!empty($gdhDepart) && !empty($gdhArrivee) && $gdhArrivee <= $gdhDepart) {
            $errors['dates'] = 'La date d\'arrivée doit être postérieure à la date de départ.';
        }

        if (!empty($gdhDepart) && $gdhDepart <= date('Y-m-d\TH:i')) {
            $errors['gdh_depart_future'] = 'La date de départ doit être dans le futur.';
        }

        if ($places < 1 || $places > 9) {
            $errors['places_totales'] = 'Le nombre de places doit être compris entre 1 et 9.';
        }

        return $errors;
    }
}
