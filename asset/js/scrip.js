const EMAILJS_PUBLIC_KEY = 'MHWfCFxbSaIfZJ-xN';
const EMAILJS_SERVICE_ID = 'service_jh1yade';
const EMAILJS_TEMPLATE_ID = 'template_4g6rna6';

document.addEventListener('DOMContentLoaded', () => {
    initRevealAnimations();
    initBurgerMenu();
    initContactForm();
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

function initContactForm() {
    const contactForm = document.querySelector('#contact-form');
    if (!contactForm) {
        return;
    }

    if (typeof emailjs === 'undefined') {
        console.warn('EmailJS is not loaded.');
        return;
    }

    emailjs.init(EMAILJS_PUBLIC_KEY);

    const formStatus = document.querySelector('#form-status');
    const nameInput = document.querySelector('#name');
    const emailInput = document.querySelector('#email');
    const messageInput = document.querySelector('#message');

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        updateFormStatus(formStatus, '⏳ Envoi en cours...', 'var(--muted)');

        const formData = {
            name: nameInput?.value.trim() ?? '',
            email: emailInput?.value.trim() ?? '',
            message: messageInput?.value.trim() ?? ''
        };

        try {
            await emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_TEMPLATE_ID, formData);
            updateFormStatus(formStatus, '✅ Message envoyé avec succès', '#4ade80');
            contactForm.reset();
        } catch (error) {
            console.error('FAILED...', error);
            updateFormStatus(formStatus, 'Erreur lors de l\'envoi. Veuillez réessayer.', '#f87171');
        } finally {
            scheduleStatusClear(formStatus);
        }
    });
}

function updateFormStatus(element, message, color) {
    if (!element) {
        return;
    }

    element.textContent = message;
    if (color) {
        element.style.color = color;
    }
}

function scheduleStatusClear(element) {
    if (!element) {
        return;
    }

    setTimeout(() => {
        element.textContent = '';
    }, 5000);
}

function initCarousel() {
    const slides = document.querySelector('.carousel-slides');
    const slideItems = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicatorsContainer = document.querySelector('.carousel-indicators');

    if (!slides || slideItems.length === 0) {
        return;
    }

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