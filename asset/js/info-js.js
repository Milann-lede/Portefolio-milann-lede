document.addEventListener('DOMContentLoaded', () => {
    initCardReveal();
    initBurgerMenu();
    initTextDemo();
    initCounterDemo();
    initColorGenerator();
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

function initTextDemo() {
    const changeTextBtn = document.querySelector('#change-text-btn');
    const demoText = document.querySelector('#demo-text');
    if (!changeTextBtn || !demoText) {
        return;
    }

    changeTextBtn.addEventListener('click', () => {
        const texts = [
            'Le texte a changé !',
            'JavaScript est puissant !',
            'Vous pouvez manipuler le DOM facilement.',
            'Les interactions rendent le web vivant.',
            'Retour au message initial.'
        ];

        let newText;
        do {
            newText = texts[Math.floor(Math.random() * texts.length)];
        } while (newText === demoText.textContent && texts.length > 1);

        demoText.textContent = newText;
    });
}

function initCounterDemo() {
    const counterDisplay = document.querySelector('#counter-value');
    const incrementBtn = document.querySelector('#increment-btn');
    const decrementBtn = document.querySelector('#decrement-btn');
    const resetBtn = document.querySelector('#reset-btn');

    if (!counterDisplay || !incrementBtn || !decrementBtn || !resetBtn) {
        return;
    }

    let counterValue = 0;

    const updateCounter = () => {
        counterDisplay.textContent = counterValue;
        if (counterValue > 0) {
            counterDisplay.style.color = '#4ade80';
        } else if (counterValue < 0) {
            counterDisplay.style.color = '#f87171';
        } else {
            counterDisplay.style.color = 'var(--accent-start)';
        }
    };

    incrementBtn.addEventListener('click', () => {
        counterValue++;
        updateCounter();
    });

    decrementBtn.addEventListener('click', () => {
        counterValue--;
        updateCounter();
    });

    resetBtn.addEventListener('click', () => {
        counterValue = 0;
        updateCounter();
    });
}

function initColorGenerator() {
    const generateColorBtn = document.querySelector('#generate-color-btn');
    const colorBox = document.querySelector('#color-box');
    const colorValue = document.querySelector('#color-value');

    if (!generateColorBtn || !colorBox || !colorValue) {
        return;
    }

    const applyColor = (hexColor) => {
        colorBox.style.backgroundColor = hexColor;
        colorValue.textContent = hexColor;
    };

    const setRandomColor = () => {
        applyColor(generateRandomColor());
    };

    generateColorBtn.addEventListener('click', setRandomColor);
    setRandomColor();
}

function generateRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
