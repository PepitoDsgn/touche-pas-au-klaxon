<h1 class="klaxon-page-title mb-4">Tableau de bord</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body py-4">
                <h2 class="display-4 fw-bold text-primary"><?= (int) $nbUsers ?></h2>
                <p class="mb-0">Utilisateurs</p>
                <a href="<?= $base ?>/admin/users" class="btn btn-outline-primary btn-sm mt-3">Voir la liste</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body py-4">
                <h2 class="display-4 fw-bold text-primary"><?= (int) $nbAgences ?></h2>
                <p class="mb-0">Agences</p>
                <a href="<?= $base ?>/admin/agences" class="btn btn-outline-primary btn-sm mt-3">Gérer</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body py-4">
                <h2 class="display-4 fw-bold text-primary"><?= (int) $nbTrajets ?></h2>
                <p class="mb-0">Trajets</p>
                <a href="<?= $base ?>/admin/trajets" class="btn btn-outline-primary btn-sm mt-3">Voir la liste</a>
            </div>
        </div>
    </div>
</div>
