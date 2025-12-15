document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('#login-form');
    const addProjectForm = document.querySelector('#add-project-form');
    const logoutBtn = document.querySelector('#logout-btn');

    // --- LOGIN PAGE LOGIC ---
    if (loginForm) {
        // Redirect if already logged in
        if (localStorage.getItem('isAdmin') === 'true') {
            window.location.href = 'dashboard.html';
        }

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const username = loginForm.username.value;
            const password = loginForm.password.value;
            const errorMsg = document.querySelector('#login-error');

            if (username === 'Milann' && password === '1234') {
                localStorage.setItem('isAdmin', 'true');
                window.location.href = 'dashboard.html';
            } else {
                errorMsg.textContent = "Identifiants incorrects";
            }
        });
    }

    // --- DASHBOARD LOGIC ---
    if (window.location.pathname.includes('dashboard.html')) {
        // Check Auth
        if (localStorage.getItem('isAdmin') !== 'true') {
            window.location.href = 'login.html';
            return;
        }

        // Logout
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => {
                localStorage.removeItem('isAdmin');
                window.location.href = '../index.html';
            });
        }

        // Render Projects List
        renderAdminProjects();

        // Event Delegation for Active Projects
        const activeList = document.querySelector('#admin-projects-list');
        if (activeList) {
            activeList.addEventListener('click', (e) => {
                const target = e.target;
                const btn = target.closest('button');
                if (!btn) return;

                const id = Number(btn.dataset.id);

                if (btn.classList.contains('btn-edit')) {
                    editProject(id);
                } else if (btn.classList.contains('btn-featured')) {
                    toggleFeatured(id);
                } else if (btn.classList.contains('btn-archive')) {
                    archiveProject(id);
                }
            });
        }

        // Event Delegation for Archived Projects
        const archivedList = document.querySelector('#archived-projects-list');
        if (archivedList) {
            archivedList.addEventListener('click', (e) => {
                const target = e.target;
                const btn = target.closest('button');
                if (!btn) return;

                const id = Number(btn.dataset.id);

                if (btn.classList.contains('btn-restore')) {
                    restoreProject(id);
                } else if (btn.classList.contains('btn-hard-delete')) {
                    hardDeleteProject(id);
                }
            });
        }

        // Add Project
        if (addProjectForm) {
            addProjectForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const newProject = {
                    id: Date.now(), // Unique ID
                    title: document.querySelector('#title').value,
                    description: document.querySelector('#description').value,
                    shortDesc: document.querySelector('#description').value.substring(0, 100) + '...', // Auto-generate short desc
                    image: document.querySelector('#image').value,
                    link: document.querySelector('#link').value,
                    category: document.querySelector('#category').value,
                    role: "Admin Added", // Default
                    context: "Projet ajouté via Admin",
                    tools: "N/A",
                    stack: "N/A",
                    duration: "N/A",
                    archived: false,
                    featured: document.querySelector('#featured').checked // New field
                };

                // Get existing projects
                const projects = getProjectsFromStorage();
                projects.push(newProject);
                saveProjectsToStorage(projects);

                // Reset form and refresh list
                addProjectForm.reset();
                renderAdminProjects();
                alert('Projet ajouté avec succès !');
            });
        }
    }
});

// Helper to get projects
function getProjectsFromStorage() {
    const storedProjects = localStorage.getItem('projects');
    if (storedProjects) {
        return JSON.parse(storedProjects);
    }
    return [];
}

function saveProjectsToStorage(projects) {
    localStorage.setItem('projects', JSON.stringify(projects));
}

function renderAdminProjects() {
    const activeList = document.querySelector('#admin-projects-list');
    const archivedList = document.querySelector('#archived-projects-list');

    if (!activeList || !archivedList) return;

    const projects = getProjectsFromStorage();

    // Active Projects
    const activeProjects = projects.filter(p => !p.archived);
    if (activeProjects.length === 0) {
        activeList.innerHTML = '<p>Aucun projet actif.</p>';
    } else {
        activeList.innerHTML = activeProjects.map(p => `
            <div class="admin-project-item">
                <div class="admin-project-info">
                    <h4>${p.title} ${p.featured ? '⭐' : ''}</h4>
                    <p>${p.category}</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn small btn-featured" data-id="${p.id}" style="background: ${p.featured ? '#fbbf24' : '#4b5563'}; color: ${p.featured ? 'black' : 'white'};">
                        ${p.featured ? 'Retirer Phare' : 'Mettre Phare'}
                    </button>
                    <button class="btn small btn-edit" data-id="${p.id}" style="background: #3b82f6; color: white;">Modifier</button>
                    <button class="btn delete btn-archive" data-id="${p.id}">Supprimer</button>
                </div>
            </div>
        `).join('');
    }

    // Archived Projects
    const archivedProjects = projects.filter(p => p.archived);
    if (archivedProjects.length === 0) {
        archivedList.innerHTML = '<p>Aucune archive.</p>';
    } else {
        archivedList.innerHTML = archivedProjects.map(p => `
            <div class="admin-project-item" style="opacity: 0.7;">
                <div class="admin-project-info">
                    <h4>${p.title}</h4>
                    <p>${p.category}</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn primary small btn-restore" data-id="${p.id}">Restaurer</button>
                    <button class="btn delete btn-hard-delete" data-id="${p.id}" style="background: darkred;">Supprimer DÉFINITIVEMENT</button>
                </div>
            </div>
        `).join('');
    }
}

// --- ACTIONS ---

// Edit Project
window.editProject = function (id) {
    const projects = getProjectsFromStorage();
    const project = projects.find(p => p.id === id);
    if (project) {
        console.log('Editing project:', project);
        // alert('Modification de : ' + project.title); // Debug removed
        document.querySelector('#edit-id').value = project.id;
        document.querySelector('#edit-title').value = project.title;
        document.querySelector('#edit-description').value = project.description;
        document.querySelector('#edit-image').value = project.image;
        document.querySelector('#edit-link').value = project.link;
        document.querySelector('#edit-category').value = project.category;

        document.querySelector('#edit-modal').style.display = 'block';
    }
};

window.closeEditModal = function () {
    document.querySelector('#edit-modal').style.display = 'none';
};

// Handle Image File Selection
const editImageFile = document.querySelector('#edit-image-file');
if (editImageFile) {
    editImageFile.addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            const fileName = e.target.files[0].name;
            // Auto-fill the path assuming the user puts images in asset/image/
            document.querySelector('#edit-image').value = `./asset/image/${fileName}`;
        }
    });
}

// Handle Edit Submit
const editForm = document.querySelector('#edit-project-form');
if (editForm) {
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = Number(document.querySelector('#edit-id').value);
        const projects = getProjectsFromStorage();
        const projectIndex = projects.findIndex(p => p.id === id);

        if (projectIndex !== -1) {
            projects[projectIndex].title = document.querySelector('#edit-title').value;
            projects[projectIndex].description = document.querySelector('#edit-description').value;
            projects[projectIndex].shortDesc = document.querySelector('#edit-description').value.substring(0, 100) + '...';
            projects[projectIndex].image = document.querySelector('#edit-image').value;
            projects[projectIndex].link = document.querySelector('#edit-link').value;
            projects[projectIndex].category = document.querySelector('#edit-category').value;

            saveProjectsToStorage(projects);
            renderAdminProjects();
            closeEditModal();
            alert('Projet modifié avec succès !');
        }
    });
}

// Toggle Featured
window.toggleFeatured = function (id) {
    let projects = getProjectsFromStorage();
    const project = projects.find(p => p.id === id);
    if (project) {
        project.featured = !project.featured;
        saveProjectsToStorage(projects);
        renderAdminProjects();
    }
};

// Soft Delete (Archive)
window.archiveProject = function (id) {
    if (confirm('Voulez-vous archiver ce projet ? Il ne sera plus visible sur le site.')) {
        let projects = getProjectsFromStorage();
        const project = projects.find(p => p.id === id);
        if (project) {
            project.archived = true;
            saveProjectsToStorage(projects);
            renderAdminProjects();
        }
    }
};

// Restore
window.restoreProject = function (id) {
    let projects = getProjectsFromStorage();
    const project = projects.find(p => p.id === id);
    if (project) {
        project.archived = false;
        saveProjectsToStorage(projects);
        renderAdminProjects();
    }
};

// Hard Delete
window.hardDeleteProject = function (id) {
    if (confirm('⚠️ ATTENTION : Cette action est irréversible. Voulez-vous vraiment supprimer ce projet ?')) {
        let projects = getProjectsFromStorage();
        projects = projects.filter(p => p.id !== id);
        saveProjectsToStorage(projects);
        renderAdminProjects();
    }
};

// Reset to Defaults
window.resetToDefaults = function () {
    if (confirm('Cela va ajouter les projets par défaut (Jardins de Marie, etc.) s\'ils sont manquants. Continuer ?')) {
        // We need the default projects. Since we can't import easily, we'll define the critical ones here.
        // This is a failsafe.
        const defaultProjects = [
            {
                id: 1,
                title: "ÉDUQTOI",
                category: "scolaire",
                image: "./asset/image/eduqtoi.png",
                role: "Développeur Front-end",
                context: "Projet scolaire - Lycée Arthur Rimbaud",
                tools: "VS Code, Figma",
                stack: "HTML, CSS, JavaScript",
                duration: "sur 2 ans",
                description: "Site éducatif conçu pour aider les nouveaux lycéens à s'orienter et à découvrir les spécialités du lycée. L'objectif était de créer une interface intuitive et attrayante pour un public jeune.",
                link: "https://eduqtoi.netlify.app/",
                shortDesc: "Site éducatif pour aider les nouveaux lycéens.",
                archived: false,
                featured: true
            },
            {
                id: 2,
                title: "Portfolio Tristan Lédé",
                category: "perso",
                image: "./asset/image/portfolio-tristan.png",
                role: "Développeur Fullstack",
                context: "Projet personnel",
                tools: "VS Code, GitHub",
                stack: "HTML5, CSS3, JavaScript, EmailJS",
                duration: "3 semaines",
                description: "Création d'un portfolio personnel pour présenter mes compétences et mes réalisations. Le site met l'accent sur le design et l'expérience utilisateur avec des animations fluides.",
                link: "https://tristan-lede.netlify.app/",
                shortDesc: "Un vrai portfolio pour présenter mes compétences.",
                archived: false,
                featured: true
            },
            {
                id: 3,
                title: "Les Jardins de Marie",
                category: "scolaire",
                image: "./asset/image/projet-ecole.png",
                role: "Co-développeur",
                context: "Devoir en binôme",
                tools: "Git, Trello",
                stack: "HTML, CSS, JavaScript",
                duration: "1 semaine",
                description: "Un projet collaboratif réalisé dans le cadre d'un devoir scolaire. Nous avons travaillé sur la structure HTML et le style CSS pour créer une page web responsive.",
                link: "https://milann-lede.github.io/les-jardins-de-marie/",
                shortDesc: "Un projet réalisé en binôme pour un devoir scolaire.",
                archived: false,
                featured: true
            },
            {
                id: 4,
                title: "Minifarm Manager",
                category: "ia",
                image: "./asset/image/Projet-farm-ia.png",
                role: "Prompt Engineer / Concepteur",
                context: "Projet généré avec l'IA Delia",
                tools: "Delia (IA)",
                stack: "Fullstack IA",
                duration: "1 semaine",
                description: "Un jeu de gestion de ferme complet où l'on peut acheter des parcelles, des véhicules et des graines pour gérer son entreprise agricole. Le jeu inclut un système de compte utilisateur pour sauvegarder sa progression.",
                link: "https://mini-farm-manager.netlify.app/",
                shortDesc: "Jeu de gestion de ferme créé avec l'IA Delia.",
                archived: false,
                featured: false
            }
        ];

        let currentProjects = getProjectsFromStorage();

        // Add defaults if they don't exist (check by ID)
        defaultProjects.forEach(defP => {
            if (!currentProjects.some(p => p.id === defP.id)) {
                currentProjects.push(defP);
            }
        });

        saveProjectsToStorage(currentProjects);
        renderAdminProjects();
        alert('Projets par défaut restaurés !');
    }
};
