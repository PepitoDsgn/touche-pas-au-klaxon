<h1 class="klaxon-page-title mb-4">Agences</h1>

<?php if (!empty($flash)): ?>
    <div class="alert alert-flash"><?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <!-- Formulaire d'ajout -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Ajouter une agence</h5>
                <form method="POST" action="<?= $base ?>/admin/agences/create">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" required maxlength="100">
                    </div>
                    <button type="submit" class="btn btn-dark">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des agences -->
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table klaxon-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agences as $agence): ?>
                        <tr>
                            <td><?= (int) $agence['id'] ?></td>
                            <td>
                                <form method="POST" action="<?= $base ?>/admin/agences/<?= (int) $agence['id'] ?>/edit" class="d-flex gap-2 align-items-center">
                                    <input type="text"
                                           name="nom"
                                           class="form-control form-control-sm"
                                           value="<?= htmlspecialchars($agence['nom']) ?>"
                                           required
                                           maxlength="100">
                                    <button type="submit" class="btn btn-sm btn-outline-primary text-nowrap">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST"
                                      action="<?= $base ?>/admin/agences/<?= (int) $agence['id'] ?>/delete"
                                      onsubmit="return confirm('Supprimer cette agence ?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
