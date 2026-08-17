<?php use Core\Session; ?>

<?php if (!empty($flash)): ?>
    <div class="alert alert-flash mb-4">
        <?= htmlspecialchars($flash) ?>
    </div>
<?php endif; ?>

<?php if (!Session::isLoggedIn()): ?>
    <p class="klaxon-info-msg mb-4">
        Pour obtenir plus d'informations sur un trajet, veuillez vous connecter
    </p>
<?php else: ?>
    <h1 class="klaxon-page-title mb-4">Trajets proposés</h1>
<?php endif; ?>

<?php if (empty($trajets)): ?>
    <div class="alert alert-info">Aucun trajet disponible pour le moment.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table klaxon-table">
            <thead>
                <tr>
                    <th>Départ</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places</th>
                    <?php if (Session::isLoggedIn()): ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                        <td><?= (new DateTime($trajet['gdh_depart']))->format('d/m/y') ?></td>
                        <td><?= (new DateTime($trajet['gdh_depart']))->format('H:i') ?></td>
                        <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                        <td><?= (new DateTime($trajet['gdh_arrivee']))->format('d/m/y') ?></td>
                        <td><?= (new DateTime($trajet['gdh_arrivee']))->format('H:i') ?></td>
                        <td><?= (int) $trajet['places_disponibles'] ?></td>

                        <?php if (Session::isLoggedIn()): ?>
                            <td class="text-nowrap">
                                <!-- Bouton détails -->
                                <button type="button"
                                    class="btn btn-action btn-details"
                                    data-auteur="<?= htmlspecialchars($trajet['user_prenom'] . ' ' . $trajet['user_nom']) ?>"
                                    data-telephone="<?= htmlspecialchars($trajet['user_telephone']) ?>"
                                    data-email="<?= htmlspecialchars($trajet['user_email']) ?>"
                                    data-places="<?= (int) $trajet['places_totales'] ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#trajetModal">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <?php if ((int) $trajet['user_id'] === (int) Session::getUser()['id']): ?>
                                    <!-- Bouton modifier -->
                                    <a href="<?= $base ?>/trajet/<?= (int) $trajet['id'] ?>/edit"
                                       class="btn btn-action btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Bouton supprimer -->
                                    <form method="POST"
                                          action="<?= $base ?>/trajet/<?= (int) $trajet['id'] ?>/delete"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce trajet ?')">
                                        <button type="submit" class="btn btn-action btn-del">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<script>
document.querySelectorAll('.btn-details').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('trajetModalBody').innerHTML = `
            <p><strong>Auteur :</strong> ${btn.dataset.auteur}</p>
            <p><strong>Téléphone :</strong> ${btn.dataset.telephone}</p>
            <p><strong>Email :</strong> ${btn.dataset.email}</p>
            <p><strong>Nombre total de places :</strong> ${btn.dataset.places}</p>
        `;
    });
});
</script>
