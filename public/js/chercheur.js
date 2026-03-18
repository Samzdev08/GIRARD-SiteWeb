// ══════════════════════════════════════════════════
//  Modal – clic sur "Voir l'offre" (délégation)
// ══════════════════════════════════════════════════
let bsModal = null;

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
        if (result) showAnnonceDetails(result);
    } catch (error) {
        console.error('Erreur :', error.message);
        alert('Erreur lors du chargement des détails');
    }
});

function showAnnonceDetails(annonce) {
    const competences = annonce.required_skills
        .split(',')
        .map(s => `<span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1">${s.trim()}</span>`)
        .join('');

    const mediaHtml = annonce.media_path
        ? `<p class="mb-0"><strong>Média :</strong>
            <a href="/uploads/${annonce.media_path}" target="_blank" class="ms-1">
                <i class="bi bi-file-earmark-pdf me-1"></i>Voir le fichier
            </a></p>`
        : '';

    document.getElementById('modalBody').innerHTML = `
        <h5 class="fw-bold mb-3">${annonce.title}</h5>
        <p class="text-muted mb-1">
            <i class="bi bi-calendar3 me-2"></i>
            <strong>Du</strong> ${annonce.start_date} <strong>au</strong> ${annonce.end_date}
        </p>
        <hr>
        <p class="mb-3"><strong>Description :</strong><br>${annonce.description}</p>
        <p class="mb-2"><strong>Compétences requises :</strong></p>
        <div class="mb-3">${competences}</div>
        ${mediaHtml}
        <div class="modal-footer border-0 px-0 pb-0">
            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
        </div>
    `;

    if (!bsModal) bsModal = new bootstrap.Modal(document.getElementById('modal'));
    bsModal.show();
}

// ══════════════════════════════════════════════════
//  Auto-dismiss flash message
// ══════════════════════════════════════════════════
const msg = document.querySelector('.message');
if (msg) {
    setTimeout(() => {
        bootstrap.Alert.getOrCreateInstance(msg)?.close();
    }, 3000);
}