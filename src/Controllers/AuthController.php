<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\UserModel;

/**
 * Contrôleur d'authentification.
 */
class AuthController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /** Affiche le formulaire de connexion. */
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/');
        }

        $this->render('auth/login', [
            'error' => Session::getFlash('login_error'),
        ]);
    }

    /** Traite la soumission du formulaire de connexion. */
    public function login(): void
    {
        $email    = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Session::setFlash('login_error', 'Veuillez remplir tous les champs.');
            $this->redirect('/login');
        }

        $user = $this->userModel->authenticate($email, $password);

        if ($user === null) {
            Session::setFlash('login_error', 'Identifiants incorrects.');
            $this->redirect('/login');
        }

        Session::set('user', [
            'id'        => $user['id'],
            'nom'       => $user['nom'],
            'prenom'    => $user['prenom'],
            'email'     => $user['email'],
            'telephone' => $user['telephone'],
            'role'      => $user['role'],
        ]);

        if ($user['role'] === 'admin') {
            $this->redirect('/admin');
        }

        $this->redirect('/');
    }

    /** Déconnecte l'utilisateur. */
    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/');
    }
}
