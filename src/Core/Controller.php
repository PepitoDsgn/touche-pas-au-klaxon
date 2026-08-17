<?php

declare(strict_types=1);

namespace Core;

/**
 * Contrôleur de base dont héritent tous les contrôleurs de l'application.
 */
abstract class Controller
{
    /**
     * Charge et affiche un template en lui transmettant des variables.
     *
     * @param string               $view      Chemin relatif depuis src/Views/ (ex: 'home/index')
     * @param array<string, mixed> $data      Variables à extraire dans la vue
     * @param string               $layout    Layout à utiliser
     */
    protected function render(string $view, array $data = [], string $layout = 'layout/main'): void
    {
        // Injecte le préfixe de base dans toutes les vues
        $data['base'] = $this->basePath();
        extract($data);

        $viewPath   = __DIR__ . '/../Views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/' . $layout . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            exit("Vue introuvable : {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    /** Retourne le préfixe de base de l'application (ex: /klaxon ou vide). */
    protected function basePath(): string
    {
        return rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
    }

    /** Redirige vers une URL (préfixée automatiquement si sous-dossier). */
    protected function redirect(string $url): never
    {
        header('Location: ' . $this->basePath() . $url);
        exit();
    }

    /** Vérifie que l'utilisateur est connecté, sinon redirige vers /login. */
    protected function requireAuth(): void
    {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    /** Vérifie que l'utilisateur est admin, sinon redirige vers /. */
    protected function requireAdmin(): void
    {
        if (!Session::isAdmin()) {
            $this->redirect('/');
        }
    }

    /** Nettoie et sécurise une valeur en entrée. */
    protected function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
