document.addEventListener('DOMContentLoaded', () => {
    initCardReveal();
    initBurgerMenu();
    initDemoForm();
});

function initCardReveal() {
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
    }, { threshold: 0.1 });

    cards.forEach(card => observer.observe(card));
}

function initBurgerMenu() {
    const burger = document.querySelector('#burger');
    const nav = document.querySelector('#nav');

    burger?.addEventListener('click', () => {
        nav?.classList.toggle('active');
    });
}

function initDemoForm() {
    document.querySelector('#demo-form')?.addEventListener('submit', (event) => {
        event.preventDefault();
        alert('Formulaire soumis avec succès! (Cette démo ne transmet pas réellement les données)');
    });
}
