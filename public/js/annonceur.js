// ══════════════════════════════════════════════════
//  Helpers modal Bootstrap
// ══════════════════════════════════════════════════
let bsModal = null;

function openModal() {
    if (!bsModal) bsModal = new bootstrap.Modal(document.getElementById('modal'));
    bsModal.show();
}

function closeModal() {
    bsModal?.hide();
}

// ══════════════════════════════════════════════════
//  Voir les détails  (.detail)
// ══════════════════════════════════════════════════
document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.detail');
    if (!btn) return;
    e.preventDefault();

    const id = btn.href.split('/').pop();
    try {
        const response = await fetch('/details/' + id, {
            headers: { 'Content-Type': 'application/json' }
        });
        if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);
        const result = await response.json();
        if (result) showStageDetails(result);
    } catch (error) {
        console.error('Erreur :', error.message);
        alert('Erreur lors du chargement des détails');
    }
});

function showStageDetails(stage) {
    const competences = stage.required_skills
        .split(',')
        .map(s => `<span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1">${s.trim()}</span>`)
        .join('');

    const mediaHtml = stage.media_path
        ? `<p class="mb-0"><strong>Média :</strong>
            <a href="/uploads/${stage.media_path}" target="_blank" class="ms-1">
                <i class="bi bi-file-earmark-pdf me-1"></i>Voir le fichier
            </a></p>`
        : '';

    document.getElementById('modalLabel').textContent = 'Détail de l\'offre';
    document.getElementById('modalBody').innerHTML = `
        <h5 class="fw-bold mb-3">${stage.title}</h5>
        <p class="text-muted mb-1">
            <i class="bi bi-calendar3 me-2"></i><strong>Publié le :</strong> ${stage.created_at}
        </p>
        <hr>
        <p class="mb-3"><strong>Description :</strong><br>${stage.description}</p>
        <p class="mb-2"><strong>Compétences requises :</strong></p>
        <div class="mb-3">${competences}</div>
        ${mediaHtml}
        <div class="modal-footer border-0 px-0 pb-0">
            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
        </div>
    `;
    openModal();
}

// ══════════════════════════════════════════════════
//  Modifier  (.edit)
// ══════════════════════════════════════════════════
document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.edit');
    if (!btn) return;
    e.preventDefault();

    const id = btn.href.split('/').pop();
    try {
        const response = await fetch('/details/' + id, {
            headers: { 'Content-Type': 'application/json' }
        });
        if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);
        const result = await response.json();
        if (result) showEditModal(result);
    } catch (error) {
        console.error('Erreur :', error.message);
        alert('Erreur lors du chargement des détails');
    }
});

function showEditModal(stage) {
    const mediaHtml = (stage.media_path && stage.media_path !== '')
        ? `<a href="/uploads/${stage.media_path}" target="_blank" class="small">
               <i class="bi bi-file-earmark-pdf me-1"></i>Voir le média actuel
           </a>`
        : `<span class="text-muted small">Aucun média pour cette annonce</span>`;

    document.getElementById('modalLabel').textContent = 'Modifier l\'annonce';
    document.getElementById('modalBody').innerHTML = `
        <form id="editStageForm" action="/annonceur/edit/${stage.id}"
              method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="${stage.id}">

            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" id="title" name="title"
                       class="form-control rounded-3" value="${stage.title}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"
                          class="form-control rounded-3" rows="4" required>${stage.description}</textarea>
            </div>

            <div class="mb-3">
                <label for="required_skills" class="form-label">
                    Compétences requises
                    <small class="text-muted">(séparées par des virgules)</small>
                </label>
                <input type="text" id="required_skills" name="required_skills"
                       class="form-control rounded-3" value="${stage.required_skills}">
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut"
                           class="form-control rounded-3" value="${stage.start_date}" required>
                </div>
                <div class="col-6">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin"
                           class="form-control rounded-3" value="${stage.end_date}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="media" class="form-label">Média (PDF)</label>
                <input type="file" id="media" name="media"
                       class="form-control rounded-3" accept="application/pdf">
                <div class="mt-1">${mediaHtml}</div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-secondary rounded-pill"
                        onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-floppy me-1"></i>Enregistrer
                </button>
            </div>
        </form>
    `;
    openModal();
}

// ══════════════════════════════════════════════════
//  Nouvelle annonce  (.add-annonce)
// ══════════════════════════════════════════════════
document.querySelector('.add-annonce')?.addEventListener('click', function (e) {
    e.preventDefault();

    document.getElementById('modalLabel').textContent = 'Nouvelle annonce';
    document.getElementById('modalBody').innerHTML = `
        <form id="createStageForm" action="/annonceur/create"
              method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" id="title" name="title"
                       class="form-control rounded-3" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"
                          class="form-control rounded-3" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="required_skills" class="form-label">
                    Compétences requises
                    <small class="text-muted">(séparées par des virgules)</small>
                </label>
                <input type="text" id="required_skills" name="required_skills"
                       class="form-control rounded-3">
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut"
                           class="form-control rounded-3" required>
                </div>
                <div class="col-6">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin"
                           class="form-control rounded-3" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="media" class="form-label">Média <span class="text-danger">*</span></label>
                <input type="file" id="media" name="media"
                       class="form-control rounded-3"
                       accept="application/pdf,image/jpeg,image/png" required>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-secondary rounded-pill"
                        onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i>Créer
                </button>
            </div>
        </form>
    `;
    openModal();
});

// ══════════════════════════════════════════════════
//  Auto-dismiss flash message
// ══════════════════════════════════════════════════
const msg = document.querySelector('.message');
if (msg) {
    setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(msg);
        bsAlert?.close();
    }, 3000);
}