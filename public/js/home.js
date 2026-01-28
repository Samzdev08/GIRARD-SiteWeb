
document.querySelectorAll('.detail').forEach(btn => {
    btn.addEventListener('click', async function (e) {
        e.preventDefault();
        const href = this.href;
        const id = href.split('/').pop();
        console.log('ID de l\'offre:', id);
        try {
            const response = await fetch('/details/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.error}`);
            }
            const result = await response.json();
            if (result) {
                showStageDetails(result);
            }
        } catch (error) {
            console.error('Erreur:', error.message);
            alert('Erreur lors du chargement des détails');
        }
    });
});

function showStageDetails(stage) {
    const modal = document.getElementById('modal');
    const body = document.getElementById('modalBody');

    body.innerHTML = `
        <h2>${stage.title}</h2>
        <p><strong>Description :</strong> ${stage.description}</p>
        <p><strong>Compétences requises :</strong> ${stage.required_skills}</p>
        <p><strong>Date de publication :</strong> ${stage.created_at}</p>
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