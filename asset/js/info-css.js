document.addEventListener('DOMContentLoaded', () => {
    initCardReveal();
    initBurgerMenu();
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
