document.addEventListener('DOMContentLoaded', () => {
    initFilters();
    initModal();
});

// Données des projets
const projectsData = {
    1: {
        title: "ÉDUQTOI",
        image: "./asset/image/eduqtoi.png",
        role: "Développeur Front-end",
        context: "Projet scolaire - Lycée Arthur Rimbaud",
        tools: "VS Code, Figma",
        stack: "HTML, CSS, JavaScript",
        duration: "3 semaines",
        description: "Site éducatif conçu pour aider les nouveaux lycéens à s'orienter et à découvrir les spécialités du lycée. L'objectif était de créer une interface intuitive et attrayante pour un public jeune.",
        link: "#"
    },
    2: {
        title: "Portfolio Tristan Lédé",
        image: "./asset/image/portfolio-tristan.png",
        role: "Développeur Fullstack",
        context: "Projet personnel",
        tools: "VS Code, GitHub",
        stack: "HTML5, CSS3, JS, EmailJS",
        duration: "2 semaines",
        description: "Création d'un portfolio personnel pour présenter mes compétences et mes réalisations. Le site met l'accent sur le design et l'expérience utilisateur avec des animations fluides.",
        link: "#"
    },
    3: {
        title: "Projet à deux École",
        image: "./asset/image/projet-ecole.png",
        role: "Co-développeur",
        context: "Devoir en binôme",
        tools: "Git, Trello",
        stack: "HTML, CSS",
        duration: "1 semaine",
        description: "Un projet collaboratif réalisé dans le cadre d'un devoir scolaire. Nous avons travaillé sur la structure HTML et le style CSS pour créer une page web responsive.",
        link: "#"
    }
};

function initFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            projectCards.forEach(card => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.style.display = 'flex';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

function initModal() {
    const modal = document.getElementById('project-modal');
    const modalBody = modal.querySelector('.modal-body');
    const closeBtn = modal.querySelector('.close-modal');
    const openBtns = document.querySelectorAll('.open-modal');

    openBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default if it's a link
            const card = btn.closest('.project-card');
            const projectId = card.getAttribute('data-id');
            const project = projectsData[projectId];

            if (project) {
                fillModal(project);
                openModal();
            }
        });
    });

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

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

    function openModal() {
        modal.style.display = 'flex';
        // Force reflow
        modal.offsetHeight;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
}
