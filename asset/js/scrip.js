const EMAILJS_PUBLIC_KEY = 'MHWfCFxbSaIfZJ-xN';
const EMAILJS_SERVICE_ID = 'service_jh1yade';
const EMAILJS_TEMPLATE_ID = 'template_4g6rna6';

document.addEventListener('DOMContentLoaded', () => {
    initRevealAnimations();
    initBurgerMenu();
    initContactForm();
});

function initRevealAnimations() {
    const cards = document.querySelectorAll('.card');
    if (!cards.length) {
        return;
    }

    if (!('IntersectionObserver' in window)) {
        cards.forEach(card => card.classList.add('visible'));
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
