<h1 class="klaxon-page-title mb-4">Créer un trajet</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <!-- Informations de l'auteur (pré-renseignées) -->
                <div class="alert alert-light mb-4">
                    <strong>Vos informations :</strong>
                    <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?> —
                    <?= htmlspecialchars($user['email']) ?> —
                    <?= htmlspecialchars($user['telephone']) ?>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= $base ?>/trajet/create" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="agence_depart_id" class="form-label">Agence de départ</label>
                            <select name="agence_depart_id" id="agence_depart_id" class="form-select" required>
                                <option value="">— Choisir —</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option value="<?= (int) $agence['id'] ?>"
                                        <?= isset($old['agence_depart_id']) && (int) $old['agence_depart_id'] === (int) $agence['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($agence['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
                            <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select" required>
                                <option value="">— Choisir —</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option value="<?= (int) $agence['id'] ?>"
                                        <?= isset($old['agence_arrivee_id']) && (int) $old['agence_arrivee_id'] === (int) $agence['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($agence['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="gdh_depart" class="form-label">Date et heure de départ</label>
                            <input type="datetime-local"
                                   name="gdh_depart"
                                   id="gdh_depart"
                                   class="form-control"
                                   value="<?= htmlspecialchars($old['gdh_depart'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="gdh_arrivee" class="form-label">Date et heure d'arrivée</label>
                            <input type="datetime-local"
                                   name="gdh_arrivee"
                                   id="gdh_arrivee"
                                   class="form-control"
                                   value="<?= htmlspecialchars($old['gdh_arrivee'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label for="places_totales" class="form-label">Nombre de places</label>
                            <input type="number"
                                   name="places_totales"
                                   id="places_totales"
                                   class="form-control"
                                   min="1"
                                   max="9"
                                   value="<?= htmlspecialchars((string) ($old['places_totales'] ?? '')) ?>"
                                   required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-dark">Créer le trajet</button>
                        <a href="<?= $base ?>/" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
