
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

document.querySelectorAll('.edit').forEach(btn => {
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
                showEditModal(result);
            }
        } catch (error) {
            console.error('Erreur:', error.message);
            alert('Erreur lors du chargement des détails');
        }
    });
});

function showEditModal(stage) {
    const modal = document.getElementById('modal');
    const body = document.getElementById('modalBody');

    let mediaHtml = '';

    if (stage.media_path === null || stage.media_path === '') {
        mediaHtml = `<p>Aucun média pour cette annonce</p>`;
    } else {
        mediaHtml = `
            <a href="/media/${stage.media_path}" target="_blank">
                Voir le média actuel
            </a>
        `;
    }

    body.innerHTML = `
        <h2>Modifier le stage</h2>

        <form id="editStageForm" action="/annonceur/edit/${stage.id}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="${stage.id}">

            <div>
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" value="${stage.title}" required>
            </div>

            <div>
                <label for="description">Description :</label>
                <textarea id="description" name="description" required>${stage.description}</textarea>
            </div>

            <div>
                <label for="required_skills">Compétences requises :</label>
                <input type="text" id="required_skills" name="required_skills" value="${stage.required_skills}">
            </div>

            <div>
                <label for="date_debut">Date de début :</label>
                <input type="date" id="date_debut" name="date_debut" value="${stage.start_date}" required>
            </div>

            <div>
                    <label for="date_fin">Date de fin :</label>
                    <input type="date" id="date_fin" name="date_fin" value="${stage.end_date}" required>
            </div>

            <div>
                <label for="media">Média :</label>
                <input type="file" id="media" name="media" accept="application/pdf"
>
                ${mediaHtml}

            </div>

            <div style="margin-top: 15px;">
                <button type="submit">Enregistrer</button>
                <button type="button" onclick="closeModal()">Annuler</button>
            </div>
        </form>
    `;

    modal.style.display = 'block';

    
}


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