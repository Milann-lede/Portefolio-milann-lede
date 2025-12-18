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
        link: "https://milann-lede.github.io/EDUQTOI/",
        shortDesc: "Site éducatif pour aider les nouveaux lycéens.",
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
        link: "https://milann-lede.github.io/Portfolio-tristan/",
        shortDesc: "Un vrai portfolio pour présenter mes compétences.",
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
        featured: true
    },
];

// Load from localStorage or use default
let projects = JSON.parse(localStorage.getItem('projects'));

if (!projects || projects.length === 0) {
    projects = defaultProjects;
    localStorage.setItem('projects', JSON.stringify(projects));
}

// FORCE UPDATE: Ensure the link is correct even if loaded from localStorage
const jardinsProject = projects.find(p => p.id === 3);
if (jardinsProject && jardinsProject.link !== "https://milann-lede.github.io/les-jardins-de-marie/") {
    jardinsProject.link = "https://milann-lede.github.io/les-jardins-de-marie/";
    localStorage.setItem('projects', JSON.stringify(projects));
    console.log('Link for Jardins de Marie updated in localStorage');
}

const eduqtoiProject = projects.find(p => p.id === 1);
if (eduqtoiProject && eduqtoiProject.link !== "https://milann-lede.github.io/EDUQTOI/") {
    eduqtoiProject.link = "https://milann-lede.github.io/EDUQTOI/";
    localStorage.setItem('projects', JSON.stringify(projects));
    console.log('Link for EDUQTOI updated in localStorage');
}

const tristanProject = projects.find(p => p.id === 2);
if (tristanProject && tristanProject.link !== "https://milann-lede.github.io/Portfolio-tristan/") {
    tristanProject.link = "https://milann-lede.github.io/Portfolio-tristan/";
    localStorage.setItem('projects', JSON.stringify(projects));
    console.log('Link for Tristan Project updated in localStorage');
}

// Remove IA project (id: 4) if present
const iaProjectIndex = projects.findIndex(p => p.id === 4);
if (iaProjectIndex !== -1) {
    projects.splice(iaProjectIndex, 1);
    localStorage.setItem('projects', JSON.stringify(projects));
    console.log('IA Project removed from localStorage');
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


// 5. Gestion de la Modale
const modal = document.querySelector('#project-modal');
const modalBody = modal.querySelector('.modal-body');
const closeBtn = modal.querySelector('.close-modal');

// Fonction pour ouvrir la modale
function openProjectModal(id) {
    const project = projects.find(p => p.id === id);
    if (project) {
        fillModal(project);
        modal.style.display = 'flex';
        // Force reflow
        modal.offsetHeight;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

// Remplir le contenu de la modale
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

// Fermeture de la modale
function closeModal() {
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 300);
}

if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
}

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// --- DEEP LINKING LOGIC ---
document.addEventListener('DOMContentLoaded', () => {
    // Check for 'id' parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const projectId = urlParams.get('id');

    if (projectId) {
        const id = Number(projectId);
        const project = projects.find(p => p.id === id && !p.archived);
        if (project) {
            openProjectModal(id);
        }
    }
});
