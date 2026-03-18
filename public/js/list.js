// ══════════════════════════════════════════════════
//  Modal – clic sur "Voir l'offre"  (délégation)
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

    document.getElementById('modalBody').innerHTML = `
        <h5 class="fw-bold mb-3">${stage.title}</h5>
        <p class="text-muted mb-1">
            <i class="bi bi-calendar3 me-2"></i><strong>Publié le :</strong> ${stage.created_at}
        </p>
        <hr>
        <p class="mb-3"><strong>Description :</strong><br>${stage.description}</p>
        <p class="mb-2"><strong>Compétences requises :</strong></p>
        <div class="mb-2">${competences}</div>
    `;

    new bootstrap.Modal(document.getElementById('modal')).show();
}

// ══════════════════════════════════════════════════
//  Recherche live
// ══════════════════════════════════════════════════
const searchInput   = document.getElementById('searchInput');
const offresList    = document.getElementById('offresList');
const msgSearch     = document.querySelector('.message-search');

searchInput.addEventListener('input', async () => {
    const query = searchInput.value.trim();

    if (query === '') {
        location.reload();
        return;
    }

    try {
        const response = await fetch(`/search/${encodeURIComponent(query)}`);
        const result   = await response.json();
        if (!response.ok) throw new Error(result.error);

        const offres = result.data;

        if (offres.length < 1) {
            msgSearch?.classList.remove('d-none');
            offresList.innerHTML = '';
            return;
        }

        msgSearch?.classList.add('d-none');
        offresList.innerHTML = offres.map(item => buildOffreCard(item)).join('');

    } catch (error) {
        console.error('Erreur recherche :', error.message);
    }
});

// Bouton Rechercher (déclenche le même comportement)
document.getElementById('searchButton')?.addEventListener('click', () => {
    searchInput.dispatchEvent(new Event('input'));
});

// ──────────────────────────────────────────────────
//  Génération d'une carte offre Bootstrap
// ──────────────────────────────────────────────────
function buildOffreCard(item) {
    const competences = item.required_skills
        .split(',')
        .map(s => `<span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1 mb-1 competence">${s.trim()}</span>`)
        .join('');

    return `
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card offre-card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body d-flex flex-column p-4">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-semibold mb-0">${item.title}</h5>
                        <a href="/auth/login"
                           class="btn btn-sm btn-outline-danger rounded-pill like-button ms-2 flex-shrink-0">
                            <i class="bi bi-heart"></i>
                            <span class="ms-1">${item.wishlist_count ?? 0}</span>
                        </a>
                    </div>

                    <small class="text-muted mb-3">
                        <i class="bi bi-calendar3 me-1"></i>Posté le ${item.created_at}
                    </small>

                    <p class="card-text text-muted small flex-grow-1 description">
                        ${item.description}
                    </p>

                    <div class="mb-3">${competences}</div>

                    <a class="btn btn-outline-primary rounded-pill detail mt-auto"
                       href="/details/${item.id}">
                        Voir l'offre <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    `;
}