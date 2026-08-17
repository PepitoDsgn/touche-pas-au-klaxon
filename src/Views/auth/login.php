<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title mb-4 text-center">Connexion</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= $base ?>/login" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               required
                               autocomplete="email">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               required
                               autocomplete="current-password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
