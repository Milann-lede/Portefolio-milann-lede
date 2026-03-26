// ─── Données par défaut (remplacées par la BDD dans projets.php) ───
const defaultProjects = [];

// ─── Affichage des projets dans la grille ───
function displayProjects(projects, filter = 'all') {
    const grid = document.querySelector('.projects-grid-page');
    if (!grid) return;

    // Filtre par catégorie (ou "all" pour tout afficher)
    const filtered = filter === 'all'
        ? projects
        : projects.filter(p => p.category && p.category.toLowerCase() === filter.toLowerCase());

    // Génère le HTML de chaque carte projet
    grid.innerHTML = filtered.length
        ? filtered.map(p => `
            <div class="project-card" data-category="${p.category || ''}" onclick="openModal(${p.id})">
                <div class="card-image-wrapper">
                    <img src="${p.image}" alt="${p.title}" class="project-img">
                </div>
                <div class="card-content">
                    <h3>${p.title}</h3>
                    <p>${p.shortDesc || p.description || ''}</p>
                    <span class="btn small primary">Voir le projet</span>
                </div>
            </div>
        `).join('')
        : '<p style="color:var(--muted);text-align:center;grid-column:1/-1">Aucun projet dans cette catégorie.</p>';
}

// ─── Modal (popup) pour voir le détail d'un projet ───
function openModal(id) {
    const project = defaultProjects.find(p => p.id === id);
    if (!project) return;

    const modal = document.getElementById('project-modal');
    const body  = modal.querySelector('.modal-body');

    body.innerHTML = `
        <img src="${project.image}" alt="${project.title}" class="modal-header-img">
        <div class="modal-info">
            <h2>${project.title}</h2>
            <div class="project-details-grid">
                ${project.role     ? `<div class="detail-item"><h4>Mon rôle</h4><p>${project.role}</p></div>` : ''}
                ${project.context  ? `<div class="detail-item"><h4>Contexte</h4><p>${project.context}</p></div>` : ''}
                ${project.tools    ? `<div class="detail-item"><h4>Outils</h4><p>${project.tools}</p></div>` : ''}
                ${project.stack    ? `<div class="detail-item"><h4>Stack technique</h4><p>${project.stack}</p></div>` : ''}
                ${project.duration ? `<div class="detail-item"><h4>Durée</h4><p>${project.duration}</p></div>` : ''}
                ${project.link     ? `<div class="detail-item"><h4>Lien</h4><p><a href="${project.link}" target="_blank" style="color:var(--accent-start)">${project.link}</a></p></div>` : ''}
            </div>
            ${project.description ? `<p class="modal-desc">${project.description}</p>` : ''}
        </div>
    `;

    modal.classList.add('show');
}

// ─── Fermeture du modal ───
document.addEventListener('DOMContentLoaded', () => {
    const modal    = document.getElementById('project-modal');
    const closeBtn = document.querySelector('.close-modal');

    if (closeBtn) {
        closeBtn.addEventListener('click', () => modal.classList.remove('show'));
    }
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.remove('show');
        });
    }

    // ─── Filtres par catégorie ───
    const filterBtns  = document.querySelectorAll('.filter-btn');
    const gridPage    = document.querySelector('.projects-grid-page');
    const githubRepos = document.getElementById('github-repos');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (btn.dataset.filter === 'github') {
                gridPage.style.display    = 'none';
                githubRepos.style.display = 'grid';
            } else {
                gridPage.style.display    = '';
                githubRepos.style.display = 'none';
                displayProjects(defaultProjects, btn.dataset.filter);
            }
        });
    });

    // Affiche les projets au chargement
    displayProjects(defaultProjects);
});
