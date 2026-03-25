document.addEventListener('DOMContentLoaded', () => {
    initRevealAnimations();
    initBurgerMenu();
    initCarousel();
});


function initRevealAnimations() {
    const cards = document.querySelectorAll('.card');
    if (!cards.length) {
        return;
    }



    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(({ isIntersecting, target }) => {
            if (!isIntersecting) {
                return;
            }

            target.classList.add('visible');
            obs.unobserve(target);
        });
    }, { threshold: 0.2, rootMargin: '0px 0px -40px 0px' });

    cards.forEach(card => observer.observe(card));
}

function initBurgerMenu() {
    const burger = document.querySelector('#burger');
    const nav = document.querySelector('#nav');

    burger?.addEventListener('click', () => {
        nav?.classList.toggle('active');
    });
}


function initCarousel() {
    // 1. Render Slides from LocalStorage
    const slidesContainer = document.querySelector('.carousel-slides');
    if (slidesContainer) {
        const storedProjects = localStorage.getItem('projects');
        if (storedProjects) {
            const projects = JSON.parse(storedProjects);
            // Filter featured and not archived
            const featuredProjects = projects.filter(p => p.featured && !p.archived);

            if (featuredProjects.length > 0) {
                slidesContainer.innerHTML = featuredProjects.map(p => `
                    <div class="carousel-slide" onclick="window.location.href='/asset/html/projets.php?id=${p.id}'" style="cursor: pointer;">
                        <img src="${p.image}" alt="${p.title}" class="slide-image">
                        <div class="slide-content">
                            <h3>${p.title}</h3>
                            <p>${p.shortDesc || p.description}</p>
                        </div>
                    </div>
                `).join('');
            } else {
                // Optional: Show message if no featured projects
                slidesContainer.innerHTML = '<div class="carousel-slide"><div class="slide-content"><h3>Aucun projet phare</h3><p>Aucun projet à afficher.</p></div></div>';
            }
        }
    }

    // 2. Initialize Carousel Logic (Existing)
    const slides = document.querySelector('.carousel-slides');
    const slideItems = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicatorsContainer = document.querySelector('.carousel-indicators');

    if (!slides || slideItems.length === 0) {
        return;
    }

    // Clear existing indicators
    if (indicatorsContainer) indicatorsContainer.innerHTML = '';

    let currentIndex = 0;
    const totalSlides = slideItems.length;

    // Créer les indicateurs
    for (let i = 0; i < totalSlides; i++) {
        const indicator = document.createElement('div');
        indicator.classList.add('indicator');
        indicatorsContainer.appendChild(indicator);
    }

    const indicators = document.querySelectorAll('.indicator');

    function updateCarousel() {
        slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
    }

    function goToNext() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateCarousel();
    }

    function goToPrev() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    nextBtn?.addEventListener('click', goToNext);
    prevBtn?.addEventListener('click', goToPrev);

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });

    updateCarousel();
}