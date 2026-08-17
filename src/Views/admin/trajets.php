<h1 class="klaxon-page-title mb-4">Trajets</h1>

<?php if (!empty($flash)): ?>
    <div class="alert alert-flash"><?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table klaxon-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Départ</th>
                <th>Date départ</th>
                <th>Destination</th>
                <th>Date arrivée</th>
                <th>Places</th>
                <th>Auteur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $trajet): ?>
                <tr>
                    <td><?= (int) $trajet['id'] ?></td>
                    <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                    <td><?= (new DateTime($trajet['gdh_depart']))->format('d/m/y H:i') ?></td>
                    <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                    <td><?= (new DateTime($trajet['gdh_arrivee']))->format('d/m/y H:i') ?></td>
                    <td><?= (int) $trajet['places_disponibles'] ?>/<?= (int) $trajet['places_totales'] ?></td>
                    <td><?= htmlspecialchars($trajet['user_prenom'] . ' ' . $trajet['user_nom']) ?></td>
                    <td>
                        <form method="POST"
                              action="<?= $base ?>/admin/trajets/<?= (int) $trajet['id'] ?>/delete"
                              onsubmit="return confirm('Supprimer ce trajet ?')">
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
