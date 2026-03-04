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
        if (!response.ok) throw new Error(`Erreur HTTP: ${response.error}`);
        const result = await response.json();
        if (result) showStageDetails(result);
    } catch (error) {
        console.error('Erreur:', error.message);
        alert('Erreur lors du chargement des détails');
    }
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

const searchBar = document.querySelector('.search-bar');
const offreContainer = document.querySelector('.offres-list');
const titreOffres = document.querySelector('.offres-container h1');

searchBar.addEventListener('input', async () => {
    const valueSearchBar = searchBar.value;
    if (valueSearchBar === '') {
        location.reload();
        return;
    }
    const response = await fetch(`/search/${valueSearchBar}`);
    const result = await response.json();
    if (!response.ok) throw new Error(result.error);
    
    if (result.data.length < 1) {
        const message = document.querySelector('.message-search');
        if (message) message.classList.add('active-message');
        titreOffres.textContent = `0 offre(s) trouvée(s)`;
        offreContainer.innerHTML = '';
        return;
    }
    
    const message = document.querySelector('.message-search');
    if (message) message.classList.remove('active-message');
    const offres = result.data;
    titreOffres.textContent = `${offres.length} offre(s) trouvée(s)`;
    offreContainer.innerHTML = '';
    offres.forEach((item) => {
        const div = document.createElement('div');
        const competences = item.required_skills.split(',').map(s => `<span class="competence">${s}</span>`).join('');
        div.innerHTML = `
            <div class="offre">
                <div class="container-like">
                    <div class="like-button">❤️<span>0</span></div>
                    <div class="title">${item.title}</div>
                    <div class="infos">
                        <div class="date-posted">Posté le ${item.created_at}</div>
                    </div>
                    <div class="description">${item.description}</div>
                    <div class="comptences">${competences}</div>
                    <a class="detail" href="/details/${item.id}">Voir l'offre</a>
                </div>
            </div>
        `;
        offreContainer.appendChild(div);
    });
});


const createElement = (nameElement) => {

    return document.createElement(nameElement);
}