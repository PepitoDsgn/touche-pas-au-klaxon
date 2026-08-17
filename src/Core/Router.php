<?php

declare(strict_types=1);

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TrajetController;
use App\Controllers\AdminController;

/**
 * Routeur frontal de l'application.
 * Analyse l'URL et dispatche vers le bon contrôleur/méthode.
 */
class Router
{
    /** @var array<array{method: string, pattern: string, controller: string, action: string}> */
    private array $routes = [];

    public function __construct()
    {
        Session::start();
        $this->registerRoutes();
    }

    /** Enregistre toutes les routes de l'application. */
    private function registerRoutes(): void
    {
        // Pages publiques
        $this->addRoute('GET',  '/',              HomeController::class,  'index');

        // Authentification
        $this->addRoute('GET',  '/login',         AuthController::class,  'showLogin');
        $this->addRoute('POST', '/login',         AuthController::class,  'login');
        $this->addRoute('GET',  '/logout',        AuthController::class,  'logout');

        // Trajets
        $this->addRoute('GET',  '/trajet/create', TrajetController::class, 'create');
        $this->addRoute('POST', '/trajet/create', TrajetController::class, 'store');
        $this->addRoute('GET',  '/trajet/(\d+)/edit',   TrajetController::class, 'edit');
        $this->addRoute('POST', '/trajet/(\d+)/edit',   TrajetController::class, 'update');
        $this->addRoute('POST', '/trajet/(\d+)/delete', TrajetController::class, 'delete');

        // Admin
        $this->addRoute('GET',  '/admin',                  AdminController::class, 'dashboard');
        $this->addRoute('GET',  '/admin/users',            AdminController::class, 'users');
        $this->addRoute('GET',  '/admin/agences',          AdminController::class, 'agences');
        $this->addRoute('POST', '/admin/agences/create',   AdminController::class, 'createAgence');
        $this->addRoute('POST', '/admin/agences/(\d+)/edit',   AdminController::class, 'editAgence');
        $this->addRoute('POST', '/admin/agences/(\d+)/delete', AdminController::class, 'deleteAgence');
        $this->addRoute('GET',  '/admin/trajets',          AdminController::class, 'trajets');
        $this->addRoute('POST', '/admin/trajets/(\d+)/delete', AdminController::class, 'deleteTrajet');
    }

    /**
     * @param string $method     Méthode HTTP
     * @param string $pattern    Chemin URL (supporte les groupes de capture regex)
     * @param string $controller Classe du contrôleur
     * @param string $action     Méthode du contrôleur
     */
    private function addRoute(string $method, string $pattern, string $controller, string $action): void
    {
        $this->routes[] = compact('method', 'pattern', 'controller', 'action');
    }

    /** Analyse l'URL courante et appelle le bon contrôleur. */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        // Supprime le préfixe de sous-dossier (ex: /klaxon) pour que les routes
        // fonctionnent aussi bien en sous-dossier qu'à la racine du serveur.
        $basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
        if ($basePath !== '' && str_starts_with($requestUri, $basePath)) {
            $requestUri = substr($requestUri, strlen($basePath)) ?: '/';
        }

        foreach ($this->routes as $route) {
            $pattern = '#^' . $route['pattern'] . '$#';

            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                $controller = new $route['controller']();
                $controller->{$route['action']}(...$matches);
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../Views/errors/404.php';
    }
}
