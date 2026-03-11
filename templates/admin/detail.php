<link rel="stylesheet" href="/css/style.css">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Dashboard Admin</h1>
            <p class="text-muted mb-0">Gérez les utilisateurs et les mots clefs</p>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ─── UTILISATEURS ─────────────────────────────────── -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 mb-0 fw-semibold">👥 Utilisateurs</h2>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-weight:bold;font-size:1.1rem;">
                                <?= strtoupper(substr($user['login'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-semibold"><?= $user['login'] ?></div>
                                <span class="badge rounded-pill
                                    <?= $user['user_type'] === 'administrateur' ? 'bg-danger' : ($user['user_type'] === 'annonceur' ? 'bg-warning text-dark' : 'bg-success') ?>">
                                    <?= $user['user_type'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <form action="/admin/user/update" method="POST" class="d-flex gap-2 align-items-center">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <select name="user_type" class="form-select form-select-sm" style="width:150px;">
                                    <option value="chercheur" <?= $user['user_type'] === 'chercheur' ? 'selected' : '' ?>>Chercheur</option>
                                    <option value="annonceur" <?= $user['user_type'] === 'annonceur' ? 'selected' : '' ?>>Annonceur</option>
                                    <option value="administrateur" <?= $user['user_type'] === 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Modifier</button>
                            </form>
                            <form action="/admin/user/delete/<?= $user['id'] ?>" method="POST">
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="p-4 mb-0 text-muted text-center">Aucun utilisateur trouvé.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- ─── MOTS CLEFS ───────────────────────────────────── -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0 fw-semibold">🏷️ Mots clefs</h2>
            <form action="/admin/keywords/create" method="POST" class="d-flex gap-2">
                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Nouveau mot clef..." required style="width:200px;">
                <button type="submit" class="btn btn-sm btn-success">+ Ajouter</button>
            </form>
        </div>
        <div class="card-body">
            <?php if (!empty($keywords)): ?>
                <div class="row g-3">
                    <?php foreach ($keywords as $keyword): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="border rounded p-3 h-100 d-flex flex-column gap-2 bg-light">
                                <div class="fw-semibold text-truncate">🏷️ <?= $keyword['keyword'] ?></div>
                                <form action="/admin/keywords/update" method="POST" class="d-flex gap-1 mt-auto">
                                    <input type="hidden" name="id" value="<?= $keyword['id'] ?>">
                                    <input type="text" name="keyword" value="<?= $keyword['keyword'] ?>" class="form-control form-control-sm" required>
                                    <button type="submit" class="btn btn-sm btn-outline-primary text-nowrap">✏️</button>
                                </form>
                                <form action="/admin/keywords/delete/<?= $keyword['id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">🗑 Supprimer</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mb-0 text-muted text-center">Aucun mot clef créé.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="/js/admin.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>