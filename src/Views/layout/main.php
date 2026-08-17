<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/main.css">
</head>
<body>

<!-- Header -->
<header class="klaxon-header">
    <nav class="navbar">
        <div class="container-fluid px-4">

            <?php if (\Core\Session::isAdmin()): ?>
                <!-- Header admin -->
                <a class="navbar-brand klaxon-brand" href="<?= $base ?>/admin">Touche pas au klaxon</a>
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= $base ?>/admin/users"   class="btn btn-admin-nav">Utilisateurs</a>
                    <a href="<?= $base ?>/admin/agences" class="btn btn-admin-nav">Agences</a>
                    <a href="<?= $base ?>/admin/trajets" class="btn btn-admin-nav">Trajets</a>
                    <span class="text-muted">
                        Bonjour <?= htmlspecialchars(\Core\Session::getUser()['prenom'] . ' ' . \Core\Session::getUser()['nom']) ?>
                    </span>
                    <a href="<?= $base ?>/logout" class="btn btn-dark">Déconnexion</a>
                </div>

            <?php elseif (\Core\Session::isLoggedIn()): ?>
                <!-- Header utilisateur connecté -->
                <span class="navbar-brand klaxon-brand">Touche pas au klaxon</span>
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= $base ?>/trajet/create" class="btn btn-dark">Créer un trajet</a>
                    <span class="text-muted">
                        Bonjour <?= htmlspecialchars(\Core\Session::getUser()['prenom'] . ' ' . \Core\Session::getUser()['nom']) ?>
                    </span>
                    <a href="<?= $base ?>/logout" class="btn btn-dark">Déconnexion</a>
                </div>

            <?php else: ?>
                <!-- Header visiteur -->
                <span class="navbar-brand klaxon-brand">Touche pas au klaxon</span>
                <a href="<?= $base ?>/login" class="btn btn-dark">Connexion</a>
            <?php endif; ?>

        </div>
    </nav>
</header>

<!-- Contenu principal -->
<main class="container py-4">
    <?= $content ?>
</main>

<!-- Footer -->
<footer class="klaxon-footer text-center py-3">
    <small>© 2024 - CENEF - MVC PHP</small>
</footer>

<!-- Modal détails trajet -->
<div class="modal fade" id="trajetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="trajetModalBody">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>/assets/js/main.js"></script>
</body>
</html>
