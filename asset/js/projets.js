// 1. Créer une liste de projets (comme users dans le repo)
// 1. Créer une liste de projets (comme users dans le repo)
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
        shortDesc: "Site éducatif pour aider les nouveaux lycéens."
    },
    {
        id: 2,
        title: "Portfolio Tristan Lédé",
        category: "perso",
        image: "./asset/image/portfolio-tristan.png",
        role: "Développeur Fullstack",
        context: "Projet personnel",
        tools: "VS Code, GitHub",
        stack: "HTML5, CSS3, JS, EmailJS",
        duration: "3 semaines",
        description: "Création d'un portfolio personnel pour présenter mes compétences et mes réalisations. Le site met l'accent sur le design et l'expérience utilisateur avec des animations fluides.",
        link: "https://tristan-lede.netlify.app/",
        shortDesc: "Un vrai portfolio pour présenter mes compétences."
    },
    {
        id: 3,
        title: "Les Jardins de Marie",
        category: "scolaire",
        image: "./asset/image/projet-ecole.png",
        role: "Co-développeur",
        context: "Devoir en binôme",
        tools: "Git, Trello",
        stack: "HTML, CSS, JS",
        duration: "1 semaine",
        description: "Un projet collaboratif réalisé dans le cadre d'un devoir scolaire. Nous avons travaillé sur la structure HTML et le style CSS pour créer une page web responsive.",
        link: "https://les-jardins-de-marie.netlify.app/",
        shortDesc: "Un projet réalisé en binôme pour un devoir."
    }
];

// Load from localStorage or use default
let projects = JSON.parse(localStorage.getItem('projects'));

if (!projects || projects.length === 0) {
    projects = defaultProjects;
    localStorage.setItem('projects', JSON.stringify(projects));
}

// Sélection du conteneur
const projectsGrid = document.querySelector(".projects-grid-page");

// 2. Fonction pour afficher un projet (comme showUser)
function showProject(project) {
    return `
    <article class="project-card" data-category="${project.category}" data-id="${project.id}">
        <div class="card-image-wrapper">
            <img src="${project.image}" alt="${project.title}" class="project-img">
        </div>
        <div class="card-content">
            <h3>${project.title}</h3>
            <p>${project.shortDesc}</p>
            <button class="btn primary small open-modal-btn" onclick="openProjectModal(${project.id})">Voir plus</button>
        </div>
    </article>
    `;
}

// 3. Afficher tous les projets au chargement (comme la boucle for of)
function displayProjects(projectsToDisplay) {
    if (!projectsGrid) return; // Guard clause

    // Filter out archived projects
    const visibleProjects = projectsToDisplay.filter(p => !p.archived);

    let projectDom = "";
    for (let project of visibleProjects) {
        projectDom += showProject(project);
    }
    projectsGrid.innerHTML = projectDom;
}

// Initialisation
if (projectsGrid) {
    displayProjects(projects);
}

// 4. Filtrage (Adaptation de la logique de recherche)
const filterBtns = document.querySelectorAll('.filter-btn');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Gestion de la classe active
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filterValue = btn.getAttribute('data-filter');

        // Filtrer le tableau
        let filteredProjects = [];
        if (filterValue === 'all') {
            filteredProjects = projects;
        } else {
            filteredProjects = projects.filter(p => p.category === filterValue);
        }

        // Ré-afficher (comme searchUser qui vide et remplit)
        displayProjects(filteredProjects);
    });
});


// 5. Gestion de la Modale (Gardée car demandée par l'utilisateur)
const modal = document.getElementById('project-modal');
const modalBody = modal.querySelector('.modal-body');
const closeBtn = modal.querySelector('.close-modal');

// Fonction appelée par le onclick dans le HTML généré
window.openProjectModal = function (id) {
    const project = projects.find(p => p.id === id);
    if (project) {
        fillModal(project);
        modal.style.display = 'flex';
        // Force reflow
        modal.offsetHeight;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
};

function fillModal(project) {
    modalBody.innerHTML = `
        <img src="${project.image}" alt="${project.title}" class="modal-header-img">
        <div class="modal-info">
            <h2>${project.title}</h2>
            
            <div class="project-details-grid">
                <div class="detail-item">
                    <h4>Mon Rôle</h4>
                    <p>${project.role}</p>
                </div>
                <div class="detail-item">
                    <h4>Contexte</h4>
                    <p>${project.context}</p>
                </div>
                <div class="detail-item">
                    <h4>Outils</h4>
                    <p>${project.tools}</p>
                </div>
                <div class="detail-item">
                    <h4>Stack Technique</h4>
                    <p>${project.stack}</p>
                </div>
                <div class="detail-item">
                    <h4>Durée</h4>
                    <p>${project.duration}</p>
                </div>
            </div>

            <div class="modal-desc">
                <p>${project.description}</p>
            </div>

            <a href="${project.link}" target="_blank" class="btn primary">
                Ouvrir le site
            </a>
        </div>
    `;
}

closeBtn.addEventListener('click', closeModal);

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

function closeModal() {
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 300);
}
