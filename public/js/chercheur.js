document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.detail');
    if (!btn) return;
    e.preventDefault();
    const id = btn.href.split('/').pop();
    try {
        const response = await fetch('/details/' + id, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });
        if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
        const result = await response.json();
        if (result) showAnnonceDetails(result);
    } catch (error) {
        console.error('Erreur:', error.message);
        alert('Erreur lors du chargement des détails');
    }
});

function showAnnonceDetails(annonce) {
    const modal = document.getElementById('modal');
    const body = document.getElementById('modalBody');
    body.innerHTML = `
        <h2>${annonce.title}</h2>
        <p><strong>Description :</strong> ${annonce.description}</p>
        <p><strong>Compétences requises :</strong> ${annonce.required_skills}</p>
        <p><strong>Du</strong> ${annonce.start_date} <strong>au</strong> ${annonce.end_date}</p>
        ${annonce.media_path ? `<a href="/uploads/${annonce.media_path}" target="_blank">Voir le média</a>` : ''}
    `;
    modal.style.display = 'block';
}

document.querySelector('.modal-close').addEventListener('click', function () {
    document.getElementById('modal').style.display = 'none';
});

window.onclick = function (event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};